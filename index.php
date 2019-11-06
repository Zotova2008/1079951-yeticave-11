<?php
require_once('helpers.php');

$is_auth = rand(0, 1);
$user_name = 'Наталья Зотова'; // укажите здесь ваше имя
$title = 'YetiCave | Home';
$cat_index = 0;
$limit_time = 1;
$categories = ['Доски и лыжи', 'Крепления', 'Ботинки', 'Одежда', 'Инструменты', 'Разное'];
$ads = [
    [
        'title' => '2014 Rossignol District Snowboard',
        'category' => 'Доски и лыжи',
        'price' => 10999,
        'img' => 'img/lot-1.jpg',
        'date' => '2019-11-05',
    ],
    [
        'title' => 'DC Ply Mens 2016/2017 Snowboard',
        'category' => 'Доски и лыжи',
        'price' => 159999,
        'img' => 'img/lot-2.jpg',
        'date' => '2019-11-10',
    ],
    [
        'title' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'category' => 'Крепления',
        'price' => 8000,
        'img' => 'img/lot-3.jpg',
        'date' => '2019-11-15',
    ],
    [
        'title' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'category' => 'Ботинки',
        'price' => 10999,
        'img' => 'img/lot-4.jpg',
        'date' => '2019-11-22',
    ],
    [
        'title' => 'Куртка для сноуборда DC Mutiny Charocal',
        'category' => 'Одежда',
        'price' => 7500,
        'img' => 'img/lot-5.jpg',
        'date' => '2019-11-18',
    ],
    [
        'title' => 'Маска Oakley Canopy',
        'category' => 'Разное',
        'price' => 5400,
        'img' => 'img/lot-6.jpg',
        'date' => '2019-11-17',
    ]
];

function format_amount($num)
{
    $res = ceil($num);
    if ($num >= 1000) {
        $res = number_format($res, 0, '.', ' ');
        $res .= ' ₽';
    }
    return $res;
};

function get_time($time)
{
    $computation = strtotime($time) - time();
    $hours = floor($computation / 3600);
    $hours = str_pad($hours, 2, '0', STR_PAD_LEFT);
    if ($hours < 0) {
        $hours = 0;
    }
    $minutes = floor(($computation % 3600) / 60);
    $minutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);
    if ($minutes < 0) {
        $minutes = 0;
    }

    return [$hours, $minutes];
};

$page_content = include_template('main.php', [
    'categories' => $categories,
    'ads' => $ads,
    'limit_time' => $limit_time,
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'title' => $title,
]);

htmlspecialchars(print($layout_content));
