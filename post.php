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

$post_id = $_GET['id'] ?? '';
$post = get_post_info($connection, $post_id);

if (!$post_id or !$post) {
    header("HTTP/1.0 404 Not Found");
    exit();
}

$block_post = include_template(template_by_type($post['type']), ['post' => $post]);
$comments_count = get_count_comments($connection, $post_id);
$subscriptions = get_count_subscriptions($connection, $post['user']);
$comments = get_comments($connection, $post_id);


$page_content = include_template('post.php', [
    'post' => $post,
    'block_post' => $block_post,
    'comments_count' => $comments_count,
    'subscriptions' => $subscriptions,
    'comments' => $comments
]);

$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'title' => 'Публикация',
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);
print ($layout_content);
