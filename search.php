<?php
require_once 'init.php';

$lots = [];
$lots_page = [];
$search = trim($_GET['search']) ?? '';

if ($search == !'') {
    $sql = 'SELECT lot.id, lot.lot_title, lot.lot_descript, lot.lot_img, lot.lot_price, lot.lot_step, lot.date_creation, lot.date_final, lot.id_category, cat.category_name FROM lot
	LEFT JOIN category AS cat ON lot.id_category = cat.id
	LEFT JOIN bet ON lot.id = bet.id_lot
    WHERE MATCH(lot_title, lot_descript) AGAINST(?)
    ORDER BY lot.date_creation DESC';

    $stmt = db_get_prepare_stmt($con, $sql, [$search]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);

    //Делаем пагинацию
    $cur_page = $_GET['page'] ?? 1;
    $page_items = 3;
    $lots_count = count($lots);
    $pages_count = ceil($lots_count / $page_items);
    $offset = ($cur_page - 1) * $page_items;
    $page_prev = $cur_page - 1;

    if ($cur_page < $pages_count) {
        $page_next = $cur_page + 1;
    } else {
        $page_next = false;
    }

    $pages = range(1, $pages_count);

    $sql_page = "$sql LIMIT $page_items OFFSET $offset";
    $stmt_page = db_get_prepare_stmt($con, $sql_page, [$search]);
    mysqli_stmt_execute($stmt_page);
    $result_page = mysqli_stmt_get_result($stmt_page);
    $lots_page = mysqli_fetch_all($result_page, MYSQLI_ASSOC);

    if ($pages_count <= 0) {
        $error = "Ничего не найдено по вашему запросу.";
        $page_content = include_template('error.php', ['error' => $error]);
    } else {
        $page_content = include_template('search.php', [
            'category' => $category,
            'lots' => $lots_page,
            'search' => $search,
            'pages_count' => $pages_count,
            'page_next' => $page_next,
            'page_prev' => $page_prev,
            'pages' => $pages,
            'cur_page' => $cur_page
        ]);
    }
} else {
    $error = "Введите поисковой запрос";
    $page_content = include_template('error.php', ['error' => $error]);
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'category' => $category,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'page_title' => $page_title,
]);

print($layout_content);
