<?php

require 'bootstrap.php';
require 'functions/validators/user/registration.php';


$user_data = [];
$file_data = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_data = $_POST;
    $file_data = $_FILES;


}
$block_errors = include_template('add_post_errors.php', ['errors' => $errors]);
$page_content = include_template('login.php', [
    'block_errors' => $block_errors,
    'errors' => $errors,
    'user_data' => $user_data


]);
$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'title' => 'Популярное',
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);
print ($layout_content);
