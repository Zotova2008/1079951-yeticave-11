<?php

require_once('init.php');

$lots = [];
$category_id = filter_input(INPUT_GET, 'id');

$url = 'category.php?id=' . $category_id;
$cur_page = $_GET['page'] ?? 1;
$page_items = 3;

$sql = 'SELECT lot.*, cat.category_name AS category_name FROM lot JOIN category cat ON  lot.id_category = cat.id WHERE lot.id_category = "%s" AND lot.date_final > NOW()';

$sql = sprintf($sql, $category_id);
$result = mysqli_query($con, $sql);

if (!$result) {
    print('Ошибка подключения к базе данных: ' . mysqli_error($con));
}

$items_count = (mysqli_num_rows($result));
$pages_count = ceil($items_count / $page_items);
$offset = ($cur_page - 1) * $page_items;
$page_prev = $cur_page - 1;

if ($cur_page < $pages_count) {
    $page_next = $cur_page + 1;
} else {
    $page_next = false;
}
$pages = range(1, $pages_count);

$sql_lots = $sql . ' LIMIT ' .  $page_items . ' OFFSET ' . $offset;
$sql_lots = sprintf($sql_lots, $category_id);
$result_lots = mysqli_query($con, $sql_lots);
$lots = mysqli_fetch_all($result_lots, MYSQLI_ASSOC);

$category_name = $lots[0]['category_name'] ?? '';

$page_content = include_template('category.php', [
    'category' => $category,
    'category_name' => $category_name,
    'category_id' => $category_id,
    'lots' => $lots,
    'url' => $url,
    'pages' => $pages,
    'pages_count' => $pages_count,
    'url' => $url,
    'cur_page' => $cur_page,
    'page_prev' => $page_prev,
    'page_next' => $page_next
]);

$page_title = $lots[0]['category'] ?? '';

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'category' => $category,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'page_title' => $page_title,
]);

print($layout_content);
