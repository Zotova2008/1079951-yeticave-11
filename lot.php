<?php
require_once('init.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user'])) {
        http_response_code(403);
        exit();
    }
}
$lot_id = filter_input(INPUT_GET, 'id');
$sql_lot = 'SELECT lot.id, lot.lot_title, lot.lot_descript, lot.lot_img, lot.lot_price, MAX(bet_sum) AS bet_sum, lot.lot_step, lot.date_final, lot.id_category, cat.category_name FROM lot LEFT JOIN category AS cat ON lot.id_category = cat.id LEFT JOIN bet ON lot.id = bet.id_lot WHERE lot.id = ' . $lot_id;

$result_lot = mysqli_query($con, $sql_lot);

if (!$result_lot) {
    $error = 'Ошибка MySQL: ' . mysqli_error($con);
    $page_content = include_template('error.php', ['error' => $error]);
} else {

    $lot = mysqli_fetch_assoc($result_lot);

    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $cost = $_POST['cost'] ?? '';
        if (empty($cost)) {
            $errors['cost'] = 'Заполните это поле';
        } else if (!filter_var($cost, FILTER_VALIDATE_INT) && filter_var($cost, FILTER_VALIDATE_INT) > 0) {
            $errors['cost'] = 'Введите целое число';
        } else if ($cost < ($lot['bet_sum'] ? ($lot['bet_sum'] + $lot['lot_step']) : ($lot['lot_price'] + $lot['lot_step']))) {
            $errors['cost'] = 'Заполните поле корректным значением';
        }

        if (!count($errors)) {
            $bet = [$user_id, $lot['id'], $cost];
            $sql_bet = 'INSERT INTO bet (bet_time, id_user, id_lot, bet_sum) VALUES (NOW(), ?, ?, ?)';
            $stmt = db_get_prepare_stmt($con, $sql_bet, $bet);
            $res_bet = mysqli_stmt_execute($stmt);

            if (!$res_bet) {
                $error = 'Ошибка MySQL: ' . mysqli_error($con);
                $page_content = include_template('error.php', ['error' => $error]);
            }

            $this_lot_id = mysqli_insert_id($con);
            header('Location: lot.php?id=' . $lot['id']);
            exit();
        }
    }

    //История ставок
    $sql_history = 'SELECT bet.bet_time, bet.bet_sum, user_data.user_name FROM bet LEFT JOIN user_data ON bet.id_user = user_data.id WHERE id_lot = ' . $lot_id . ' ORDER BY bet_sum DESC LIMIT 10';

    $result_history = mysqli_query($con, $sql_history);

    if (!$result_history) {
        $page_content = include_template('error.php', ['error' => 'Ошибка']);
    } else {

        $history = mysqli_fetch_all($result_history, MYSQLI_ASSOC);

        $page_content = include_template(
            'lot.php',
            [
                'category' => $category,
                'lot' => $lot,
                'limit_time' => $limit_time,
                'history' => $history
            ]
        );

        $page_title = $lot['lot_title'];

        $layout_content = include_template('layout.php', [
            'content' => $page_content,
            'category' => $category,
            'is_auth' => $is_auth,
            'user_name' => $user_name,
            'page_title' => $page_title,
        ]);

        print($layout_content);
    }
}
