<?php

require 'bootstrap.php';
if (!$user) {
    header('Location: /');
    exit();
}

$types = get_types($connection);
$type_id = $_GET['type_id'] ?? null;
$type_id = (int)$type_id;

$type = get_type_by_id($connection, $type_id);

if ($type_id && !$type) {
    header("HTTP/1.0 404 Not Found");
    exit();
}
$tab = isset($_GET['tab']) ? clean($_GET['tab']) : null;

$sort = sort_field($tab);

$cur_page = $_GET['page'] ?? 1;
if (!$cur_page) {
    header("HTTP/1.0 404 Not Found");
    exit();
}

$page_items = $config['pagination']['posts_per_page'];

$items_count = get_count_posts($connection, $type_id);

$pages_count = null;
$offset = null;

if ($items_count !== 0) {
    $pages_count = ceil($items_count / $page_items);
    $offset = ($cur_page - 1) * $page_items;
    if ($cur_page > $pages_count) {
        header("HTTP/1.0 404 Not Found");
        exit();
    }
}
$posts = get_posts($connection, $type_id, $sort, null, $page_items, $offset);

$page_content = include_template('popular.php', [
    'types' => $types,
    'posts' => $posts,
    'type' => $type,
    'type_id' => $type_id,
    'connection' => $connection,
    'cur_page' => $cur_page,
    'user' => $user,
    'pages_count' => $pages_count
]);
$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'title' => 'Популярное',
    'user' => $user,
    'search' => $search
]);
print ($layout_content);