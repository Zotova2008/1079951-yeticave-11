<?php
require_once('init.php');

//Получаем данные лота из БД
if (!isset($_GET['id'])) {
    header('HTTP/1.0 404 Not Found');
    exit;
} else {
    $sql_lot = 'SELECT lot.id, lot.lot_title, lot.lot_descript, lot.lot_img, lot.lot_price, lot.lot_step, lot.date_final, lot.id_category, cat.category_name FROM lot
	LEFT JOIN category AS cat ON lot.id_category = cat.id
	LEFT JOIN bet ON lot.id = bet.id_lot
	WHERE lot.id = ' . $_GET['id'];
    $result_lot = mysqli_query($con, $sql_lot);
    if (!$result_lot) {
        $error = 'Ошибка MySQL: ' . mysqli_error($con);
        $page_content = include_template('error.php', ['error' => $error]);
        http_response_code(404);
    }

    $ads = mysqli_fetch_assoc($result_lot);

    if (!$ads['id']) {
        header('HTTP/1.0 404 Not Found');
        exit;
    } else {
        $page_content = include_template(
            'lot.php',
            [
                'category' => $category,
                'ads' => $ads,
                'limit_time' => $limit_time,
            ]
        );
        $page_title = $ads['lot_title'];
    }

    $layout_content = include_template('layout.php', [
        'content' => $page_content,
        'category' => $category,
        'is_auth' => $is_auth,
        'user_name' => $user_name,
        'page_title' => $page_title,
    ]);

    print($layout_content);
}
