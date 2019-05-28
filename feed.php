<?php

require 'bootstrap.php';

$types = get_types($connection);
$type_block = $_GET['type_id'] ?? '';
$type_block = clean($type_block);

$types_correct = get_type_by_id($connection, $type_block);

if ($type_block && !$types_correct) {
    header("HTTP/1.0 404 Not Found");
    exit();
}


$posts = get_posts($connection, $type_block, null, $user['id']);


$page_content = include_template('feed.php', [
    'posts' => $posts,
    'connection' => $connection,
    'types_correct' => $types_correct,
    'types' => $types,
    'type_block'=> $type_block
]);
$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'title' => 'Популярное',
    'is_auth' => $is_auth,
    'user' => $user
]);
print ($layout_content);