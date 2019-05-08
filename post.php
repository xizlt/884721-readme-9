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

$types = get_types($connection);
$posts = get_posts($connection);

$post_id = $_GET['id'] ?? '';
$control = get_post_by_id($connection, $post_id);

if (!$post_id or !$control) {
    header("HTTP/1.0 404 Not Found");
    exit();
}

$page_content = include_template('post.php', [
    'types' => $types,
    'posts' => $posts

]);
$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'title' => 'Публикация',
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);
print ($layout_content);
