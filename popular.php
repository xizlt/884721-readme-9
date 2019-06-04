<?php

require 'bootstrap.php';
if (!$user) {
    header('Location: /');
    exit();
}

$types = get_types($connection);
$type_block = $_GET['type_id'] ?? null;
$type_block = (int)clean($type_block);

$types_correct = get_type_by_id($connection, $type_block);

if ($type_block && !$types_correct) {
    header("HTTP/1.0 404 Not Found");
    exit();
}
$sort = sort_field();

$cur_page = $_GET['page'] ?? 1;
if (!$cur_page) {
    header("HTTP/1.0 404 Not Found");
    exit();
}
$page_items = 9;
$items_count = get_count_posts($connection, $type_block);
$pages_count = ceil($items_count / $page_items);
$offset = ($cur_page - 1) * $page_items;
$pages = range(1, $pages_count);
if ($cur_page > $pages_count) {
    header("HTTP/1.0 404 Not Found");
    exit();
}

$posts = get_posts($connection, $type_block, $sort, null, $page_items, $offset);

$page_content = include_template('popular.php', [
    'types' => $types,
    'posts' => $posts,
    'types_correct' => $types_correct,
    'type_block' => $type_block,
    'connection' => $connection,
    'cur_page' => $cur_page,
    'user' => $user,
    'pages_count' => $pages_count
]);
$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'title' => 'Популярное',
    'user' => $user,
    'is_auth' => $is_auth
]);
print ($layout_content);