<?php
require_once('init.php');

$cur_page = $_GET['page'] ?? 1;
$page_items = 9;

$result_cnt = mysqli_query($con, 'SELECT COUNT(*) as cnt FROM lot');
$items_count = mysqli_fetch_assoc($result_cnt)['cnt'];

$pages_count = ceil($items_count / $page_items);
$offset = ($cur_page - 1) * $page_items;
$page_prev = $cur_page - 1;

if ($cur_page < $pages_count) {
    $page_next = $cur_page + 1;
} else {
    $page_next = false;
}

$pages = range(1, $pages_count);

// запрос на показ девяти самых популярных гифок
$sql = 'SELECT lot.id, lot.lot_title, lot.lot_img, lot.lot_price, lot.date_creation, lot.date_final, cat.category_name FROM lot JOIN category cat ON lot.id_category = cat.id ORDER BY lot.date_creation DESC LIMIT ' . $page_items . ' OFFSET ' . $offset;

// Отправляем запрос на получение карточек лотов
$result_lot = mysqli_query($con, $sql);
// Проверяем получены ли данные
if ($result_lot) {
    $lots = mysqli_fetch_all($result_lot, MYSQLI_ASSOC);
} else {
    print('Ошибка подключения к базе данных: ' . mysqli_error($con));
};

$page_content = include_template('main.php', [
    'category' => $category,
    'lots' => $lots,
    'limit_time' => $limit_time,
    'pages_count' => $pages_count,
    'page_next' => $page_next,
    'page_prev' => $page_prev,
    'pages' => $pages,
    'cur_page' => $cur_page
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'category' => $category,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'page_title' => $page_title,
]);

print($layout_content);
