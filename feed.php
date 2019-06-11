<?php

require 'bootstrap.php';

if (!$user) {
    header('Location: /');
    exit();
}

$types = get_types($connection);
$type_block = $_GET['type_id'] ?? '';
$type_block = (int)clean($type_block);

$types_correct = get_type_by_id($connection, $type_block);

if ($type_block && !$types_correct) {
    header("HTTP/1.0 404 Not Found");
    exit();
}

$posts = get_post_for_feed($connection, $user['id']);

$page_content = include_template('feed.php', [
    'posts' => $posts,
    'connection' => $connection,
    'types_correct' => $types_correct,
    'types' => $types,
    'type_id'=> $type_block,
    'user' => $user,
    'type_block' => $type_block
]);
$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'title' => 'Популярное',
    'search' => $search,
    'user' => $user
]);
print ($layout_content);