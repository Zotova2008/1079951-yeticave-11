<?php
session_start();

require_once('helpers.php');

$page_title = 'YetiCave | Home';
$is_auth = isset($_SESSION['user']);
$user_name = (isset($_SESSION['user'])) ? $_SESSION['user']['user_name'] : '';
$user_id = (isset($_SESSION['user'])) ? $_SESSION['user']['id'] : '';
$cat_index = 0;
$limit_time = 1;

// Подключаемся к БД
$con = mysqli_connect('localhost', 'root', '', 'yeti');
if (!$con) {
    $error = 'Ошибка подключения к базе данных: ' . mysqli_connect_error();
    $page_content = include_template('error.php', ['error' => $error]);
    $categories = 0;
}

// Устанавливаем кодировку
mysqli_set_charset($con, 'utf8');

// Отправляем запрос на получение категорий
$sql_cat = 'SELECT * FROM category';
$result_cat = mysqli_query($con, $sql_cat);
$cats_ids = [];
// Проверяем получены ли данные
if ($result_cat) {
    $category = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);
    $cats_ids = array_column($category, 'id');
} else {
    print('Ошибка подключения к базе данных: ' . mysqli_error($con));
}
