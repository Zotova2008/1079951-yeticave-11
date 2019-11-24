<?php
require_once('init.php');

if (!isset($_SESSION['user'])) {
    http_response_code(403);
    exit();
}

$cur_user_id = $_SESSION['user']['id'];
$sql = "SELECT lot.id, lot.lot_title, lot.lot_img, cat.category_name, MAX(bet.bet_sum) AS bet_price,
MAX(bet.bet_time) AS bet_time, MAX(DATE_FORMAT(bet.bet_time, '%d.%m.%y %H:%i')) AS time_format, lot.date_final, user_data.user_email, user_data.user_contact
FROM bet LEFT JOIN lot ON bet.id_lot = lot.id
LEFT JOIN category AS cat ON lot.id_category = cat.id
LEFT JOIN user_data ON lot.id_user = user_data.id
WHERE bet.id_user = $cur_user_id
GROUP BY lot.id, cat.category_name, user_data.user_email
ORDER BY lot.date_final DESC";

$result = mysqli_query($con, $sql);
if (!$result) {
    $error = 'Ошибка MySQL: ' . mysqli_error($con);
    $page_content = include_template('error.php', ['error' => $error]);
}

$lots = mysqli_fetch_all($result, MYSQLI_ASSOC);

$page_content = include_template(
    'my-bets.php',
    ['category' => $category, 'lots' => $lots]
);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'category' => $category,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'page_title' => 'Мои ставки',
]);

print($layout_content);
