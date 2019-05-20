<?php

require 'bootstrap.php';

$types = get_types($connection);
$type_block = $_GET['type_id'] ?? '';
$type_block = clean($type_block);

$types_correct = get_type_by_id($connection, $type_block);
var_dump($type_block);
if ($type_block && !$types_correct) {
    header("HTTP/1.0 404 Not Found");
    exit();
}
$sort = sort_field();

$posts = get_posts($connection, $type_block, $sort);

$page_content = include_template('popular.php', [
    'types' => $types,
    'posts' => $posts,
    'types_correct' => $types_correct,
    'type_block' => $type_block,
    'connection' => $connection
]);
$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'title' => 'Популярное',
    'user' => $user,
    'is_auth' => $is_auth
]);
print ($layout_content);