<?php
require_once('helpers.php');

$is_auth = rand(0, 1);
$user_name = 'Наталья Зотова'; // укажите здесь ваше имя
$page_title = 'YetiCave | Home';
$cat_index = 0;
$limit_time = 1;

$con = mysqli_connect('localhost', 'root', '', 'yeti');
// Устанавливаем кодировку
mysqli_set_charset($con, 'utf8');
