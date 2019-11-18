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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $required = ['lot-name', 'category-id', 'message', 'lot-img', 'lot-rate', 'lot-step', 'lot-date'];
    $errors = [];
    $rules = [
        'category-id' => function ($value) use ($category) {
            return validateCategory($value, $category);
        },
        'lot-name' => function ($value) {
            return validateLength($value, 10, 200);
        },
        'message' => function ($value) {
            return validateLength($value, 10, 3000);
        },
        'lot-date' => function ($value) {
            return validateDate($value);
        },
        'lot-rate' => function ($value) {
            return validatePrice($value);
        },
        'lot-step' => function ($value) {
            return validateStep($value);
        }
    ];
    $lot = filter_input_array(INPUT_POST, [
        'lot-name' => FILTER_DEFAULT, 'message' => FILTER_DEFAULT,
        'category-id' => FILTER_DEFAULT, 'lot-date' => FILTER_DEFAULT, 'lot-rate' => FILTER_DEFAULT, 'lot-step' => FILTER_DEFAULT
    ], true);
    $fields = [
        'lot-name' => 'Наименование',
        'message' => 'Описание',
        'category-id' => 'Категория',
        'lot-date' => 'Дата окончания торгов ',
        'lot-rate' => 'Начальная цена',
        'lot-step' => 'Шаг ставки',
    ];
    $errors = validatePostData($lot, $rules, $required, $fields);
    $errors = array_filter($errors);
    if (!empty($_FILES['lot-img']['name'])) {
        $tmp_name = $_FILES['lot-img']['tmp_name'];
        $path = $_FILES['lot-img']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $ext;
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        if ($file_type !== "image/jpeg" && $file_type !== "image/png") {
            $errors['file'] = 'Загрузите картинку в форматах jpg, jpeg, png';
        } else {
            if (!count($errors)) {
                move_uploaded_file($tmp_name, 'uploads/' . $filename);
                $lot['path'] = $filename;
            }
        }
    } else {
        $errors['file'] = 'Вы не загрузили файл';
    }
    if (count($errors)) {
        $page_content = include_template('add.php', ['lot' => $lot, 'errors' => $errors, 'category' => $category]);
    } else {
        $sql = 'INSERT INTO lot (lot_title, lot_descript, id_category, date_final, lot_price, lot_step, lot_img, date_creation, id_user, id_user_winner) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), 1, 2)';
        $stmt = db_get_prepare_stmt($con, $sql, $lot);
        $res = mysqli_stmt_execute($stmt);
        if ($res) {
            $lot_id = mysqli_insert_id($con);
            header("Location: lot.php?id=" . $lot_id);
        };
    }
} else {
    $page_content = include_template('add-lot.php', ['category' => $category]);
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'category' => $category,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'page_title' => 'Новый лот',
]);

print($layout_content);
