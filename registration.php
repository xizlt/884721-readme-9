<?php
session_start();
date_default_timezone_set("Europe/Moscow");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$is_auth = rand(0, 1);

require_once 'functions/main.php';
require_once 'functions/db/common.php';
require_once 'functions/db/users.php';
require 'functions/validators/user/registration.php';
require 'functions/photo.php';
$config = require 'config.php';
$connection = connectDb($config['db']);

$user_data = [];
$file_data = [];
$errors = [];
$user = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_data = $_POST;
    $user_data = clean($user_data);
    $file_data = $_FILES;

    $errors = validate_user($connection, $user_data, $file_data);

    if (!$errors) {

        $user_data['avatar'] = upload_img($file_data['avatar']);
        add_user($connection, $user_data);

         header("Location: /");
         exit();
    }
}
$block_errors = include_template('add_post_errors.php', ['errors' => $errors]);
$page_content = include_template('registration.php', [
    'block_errors' => $block_errors,
    'errors' => $errors,
    'user_data' => $user_data,
    'file_data' => $file_data

]);
$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'title' => 'Популярное',
    'is_auth' => $is_auth,
    'user' => $user
]);
print ($layout_content);
