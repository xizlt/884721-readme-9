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
