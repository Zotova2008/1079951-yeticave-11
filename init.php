<?php
session_start();

require_once('helpers.php');

$is_auth = 0;
$user_name = 'Наталья Зотова'; // укажите здесь ваше имя
$page_title = 'YetiCave | Home';
$cat_index = 0;
$limit_time = 1;

// Подключаемся к БД
$con = mysqli_connect('localhost', 'root', '', 'yeti');
if (!$con) {
    print('Ошибка подключения к базе данных: ' . mysqli_connect_error());
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
