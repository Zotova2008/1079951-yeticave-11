<?php
require_once('init.php');

// Отправляем запрос на получение категорий
$sql_cat = 'SELECT * FROM category';
$result_cat = mysqli_query($con, $sql_cat);
// Проверяем получены ли данные
if ($result_cat) {
    $category = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);
} else {
    print('Ошибка подключения к базе данных: ' . mysqli_error($con));
}

//Получаем данные лота из БД
if (!isset($_GET['id'])) {
    header('HTTP/1.0 404 Not Found');
    exit;
} else {
    $sql_lot = 'SELECT lot.id, lot.lot_title, lot.lot_descript, lot.lot_img, lot.lot_price, lot.lot_step, lot.date_final, cat.category_name FROM lot
	LEFT JOIN category cat ON lot.id_category = cat.id
	LEFT JOIN bet ON lot.id = bet.id_lot
	WHERE lot.id = ?';

    $stmt_lot = db_get_prepare_stmt($con, $sql_lot, [$_GET['id']]);
    mysqli_stmt_execute($stmt_lot);
    $result_lot = mysqli_stmt_get_result($stmt_lot);
    if (!$result_lot) {
        print("Ошибка MySQL: " . mysqli_error($con));
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
