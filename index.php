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

// Отправляем запрос на получение карточек лотов
$sql_lot = 'SELECT lot.id, lot.lot_title, lot.lot_img, lot.lot_price, lot.date_creation, lot.date_final, cat.category_name FROM lot JOIN category cat ON lot.id_category = cat.id ORDER BY lot.date_creation DESC';
$result_lot = mysqli_query($con, $sql_lot);
// Проверяем получены ли данные
if ($result_lot) {
    $ads = mysqli_fetch_all($result_lot, MYSQLI_ASSOC);
} else {
    print('Ошибка подключения к базе данных: ' . mysqli_error($con));
};

$page_content = include_template('main.php', [
    'category' => $category,
    'ads' => $ads,
    'limit_time' => $limit_time,
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'category' => $category,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'page_title' => $page_title,
]);

print($layout_content);
