<?php

date_default_timezone_set("Europe/Moscow");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$is_auth = rand(0, 1);

$user_name = 'Иван'; // укажите здесь ваше имя

require_once 'functions/main.php';
require_once 'functions/db.php';
require_once 'functions/validation_post.php';

$config = require 'config.php';
$connection = connectDb($config['db']);

$types = get_types($connection);
$add_post = $_GET['tab'] ?? '';

if (empty($add_post)) {
    header("Location: add.php?tab=text");
    exit();
}

if (!get_tab($add_post)) {
    header("HTTP/1.0 404 Not Found");
    exit();
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $post_data = $_POST;
    $file_data = $_FILES;

    $errors = validate_post($post_data, $add_post, $file_data);


}
$block_errors = null;
if ($errors){
    $block_errors = include_template('add_post_errors.php', ['errors' => $errors]);
}


$title_post = include_template('add_post_title.php', ['errors' => $errors]);
$tags_post = include_template('add_post_tag.php', ['errors' => $errors]);
$send_form = include_template('add_post_footer.php');
$page_content = include_template('add.php', [
    'add_post' => $add_post,
    'types' => $types,
    'block_errors' => $block_errors,
    'send_form' => $send_form,
    'title_post' => $title_post,
    'tags_post' => $tags_post,
    'errors' => $errors
]);
$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'title' => 'Популярное',
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);
print ($layout_content);