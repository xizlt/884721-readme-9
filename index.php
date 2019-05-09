<?php
date_default_timezone_set("Europe/Moscow");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$is_auth = rand(0, 1);

$user_name = 'Иван'; // укажите здесь ваше имя

require_once 'functions/main.php';
require_once 'functions/db.php';

$config = require 'config.php';
$connection = connectDb($config['db']);

// сортировка по условию
$sort_field = 'like_post';
if (isset($_GET['tab']) && $_GET['tab'] === 'likes') {
    $sort_field = 'like_post';
} elseif (isset($_GET['tab']) && $_GET['tab'] === 'date') {
    $sort_field = 'create_time';
}
//
$types = get_types($connection);
$type_block = $_GET['type_id'] ?? '';
$types_correct = get_types_by_id($connection, $type_block);

// вывод постов по типу
if ($type_block) {
    $posts = get_posts_type($connection, $type_block, $sort_field);
    if (!$types_correct) {
        header("HTTP/1.0 404 Not Found");
        exit();
    }
} else {
    $posts = get_posts($connection, $sort_field);
}
//

$page_content = include_template('index.php', [
    'types' => $types,
    'posts' => $posts,
    'types_correct' => $types_correct,
    'type_block' => $type_block,
    'connection' => $connection
]);
$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'title' => 'Популярное',
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);
print ($layout_content);