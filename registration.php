<?php
require_once 'bootstrap.php';
require_once 'functions/validators/user/registration.php';
require_once 'functions/photo.php';

$user_data = [];
$file_data = [];
$errors = [];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $user_data = load_user_data($_POST);
    $file_data = $_FILES ?? null;

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
