<?php
require_once('init.php');

if (isset($_SESSION['user'])) {
    http_response_code(403);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST;
    $required = ['email', 'password', 'name', 'contact'];
    $errors = [];
    $rules = [
        'email' => function ($value) {
            return validateEmail($value);
        },

        'password' => function ($value) {
            return validateLength($value, 6, 30);
        },
        'name' => function ($value) {
            return validateLength($value, 2, 100);
        },
        'contact' => function ($value) {
            return validateLength($value, 11, 500);
        },
    ];
    $user = filter_input_array(INPUT_POST, [
        'email' => FILTER_VALIDATE_EMAIL,
        'password' => FILTER_DEFAULT,
        'name' => FILTER_DEFAULT,
        'contact' => FILTER_DEFAULT
    ], true);
    $fields = [
        'email' => 'E-mail',
        'password' => 'Пароль',
        'name' => 'Имя',
        'contact' => 'Контактные данные'
    ];

    $errors = validatePostData($user, $rules, $required, $fields);
    $errors = array_filter($errors);

    if (empty($errors)) {
        $email = mysqli_real_escape_string($con, $form['email']);
        $sql_email = "SELECT id FROM user_data WHERE user_email = '$email'";
        $res_email = mysqli_query($con, $sql_email);

        if (mysqli_num_rows($res_email) > 0) {
            $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
        } else {
            $password = password_hash($form['password'], PASSWORD_DEFAULT);

            $sql = 'INSERT INTO user_data (user_email, user_password, user_name, user_contact, date_registr) VALUES (?, ?, ?, ?, NOW())';
            $stmt = db_get_prepare_stmt($con, $sql, $user);
            $res_email = mysqli_stmt_execute($stmt);
        }

        if ($res_email && empty($errors)) {
            header("Location: /index.php");
            exit();
        }
    }
    $page_content = include_template('sign-up.php', ['category' => $category, 'errors' => $errors,]);
} else {
    $page_content = include_template('sign-up.php', ['category' => $category]);
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'category' => $category,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'page_title' => 'Новый лот',
]);

print($layout_content);
