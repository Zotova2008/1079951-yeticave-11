<?php
require_once('init.php');

if (isset($_SESSION['user'])) {
    $page_content = include_template('error.php', ['error' => 'Вы уже зарегистрировались']);
    header('Location: index.php');
    http_response_code(403);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST;
    $required = ['email', 'password'];
    $errors = [];
    $rules = [
        'email' => function ($value) {
            return validateEmail($value);
        },

        'password' => function ($value) {
            return validateLength($value, 6, 30);
        }
    ];
    $user = filter_input_array(INPUT_POST, [
        'email' => FILTER_VALIDATE_EMAIL,
        'password' => FILTER_DEFAULT
    ], true);
    $fields = [
        'email' => 'E-mail',
        'password' => 'Пароль'
    ];

    $errors = validatePostData($form, $rules, $required, $fields);
    $errors = array_filter($errors);

    $email = mysqli_real_escape_string($con, $form['email']);
    $sql_email = "SELECT * FROM user_data WHERE user_email = '$email'";
    $res_email = mysqli_query($con, $sql_email);

    $user = $res_email ? mysqli_fetch_array($res_email, MYSQLI_ASSOC) : null;

    if (!count($errors) && $user) {
        if (password_verify($form['password'], $user['user_password'])) {
            $_SESSION['user'] = $user;
        } else {
            $errors['password'] = 'Неверный пароль';
        }
    } else {
        $errors['email'] = 'Такой пользователь не найден';
    }

    if (count($errors)) {
        $page_content = include_template('login.php', ['category' => $category, 'form' => $form, 'errors' => $errors]);
        if (isset($_SESSION['user'])) {
            header('Location: index.php');
            exit();
        }
    } else {
        header('Location: index.php');
        exit();
    }
} else {
    $page_content = include_template('login.php', ['category' => $category]);
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'category' => $category,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'page_title' => 'Регистрация',
]);

print($layout_content);
