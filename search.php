<?php
require_once 'init.php';

$lots = [];
$search = $_GET['search'] ?? '';

if ($search) {
    $sql = 'SELECT lot.id, lot.lot_title, lot.lot_descript, lot.lot_img, lot.lot_price, lot.lot_step, lot.date_creation, lot.date_final, lot.id_category, cat.category_name FROM lot
	LEFT JOIN category AS cat ON lot.id_category = cat.id
	LEFT JOIN bet ON lot.id = bet.id_lot
    WHERE MATCH(lot_title, lot_descript) AGAINST(?)
    ORDER BY lot.date_creation DESC';

    $stmt = db_get_prepare_stmt($con, $sql, [$search]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

$page_content = include_template('search.php', ['category' => $category, 'lots' => $lots, 'search' => $search,]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'category' => $category,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'page_title' => $page_title,
]);

print($layout_content);
