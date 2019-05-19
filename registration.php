<?php

require 'bootstrap.php';
require 'functions/db/users.php';
require 'functions/validators/user/registration.php';
require 'functions/db/common.php';
$tab = $_GET['form'] ?? null;

$user_data = [];
$file_data = [];
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_data = $_POST;
    $file_data = $_FILES;

    $errors = validate_user($user_data, $file_data, $connection);

    if (!$errors) {
        $user_data['avatar'] = upload_img(get_value($file_data, 'avatar'));
        add_user($connection, $user_data);

        header("Location: login.php");
        exit();
    }
}
/*$errors = [];
$block_errors = null;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $post_data = $_POST;
    $post_data = clean($post_data);
    $file_data = $_FILES;

    switch ($tab) {
        case TAB_TEXT:
            $errors = validate_post_text($post_data);
            break;
        case TAB_LINK:
            $errors = validate_post_link($post_data);
            break;
        case TAB_VIDEO:
            $errors = validate_post_video($post_data);
            break;
        case TAB_QUOTE:
            $errors = validate_post_quote($post_data);
            break;
        case TAB_PHOTO:
            $errors = validate_post_photo($post_data, $file_data);
            break;
    }

    if (!$errors) {


        $post_id = add_post($connection, $post_data, $type_id);

        if ($post_id) {
            header("Location: post.php?id=" . $post_id);
            exit();
        }
    }


    $block_errors = include_template('add_post_errors.php', ['errors' => $errors]);

}*/


$page_content = include_template('registration.php', [

]);
$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'title' => 'Популярное',
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);
print ($layout_content);
