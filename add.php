<?php
const TAB_TEXT = 'text';
const TAB_LINK = 'link';
const TAB_VIDEO = 'video';
const TAB_QUOTE = 'quote';
const TAB_PHOTO = 'photo';

require 'bootstrap.php';
require 'functions/validators/post/common.php';
require 'functions/validators/post/text.php';
require 'functions/validators/post/video.php';
require 'functions/validators/post/photo.php';
require 'functions/validators/post/link.php';
require 'functions/validators/post/quote.php';
require 'functions/tags.php';

function upload_img_by_url($post_data)
{
    if ($post_data) {
        $path = 'uploads/' . basename($post_data);
        $file = file_get_contents($post_data);
        file_put_contents($path, $file);
        return $path;
    }
    return null;
}

$types = get_types($connection);
$tab = $_GET['tab'] ?? null;

if (empty($tab)) {
    header("Location: add.php?tab=text");
    exit();
}

if (!get_tab($tab)) {
    header("HTTP/1.0 404 Not Found");
    exit();
}

$file_data = [];
$post_data = [];
$errors = [];
$block_errors = null;

$name_type = get_name_type($tab);
$type_id = get_type_id($name_type, $types);

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

        if ($tab === TAB_PHOTO) {
            $post_data['img'] = upload_img($file_data['img']) ?? upload_img_by_url($post_data['link']);
        }

        $post_id = add_post($connection, $post_data, $type_id);

        $string_tags = $post_data['tags'];
        if ($string_tags) {
            add_tags($connection, $string_tags, $post_id);
        }
        if ($post_id) {
            header("Location: post.php?id=" . $post_id);
            exit();
        }
    }


    $block_errors = include_template('add_post_errors.php', ['errors' => $errors]);

}


$title_post = include_template('add_post_title.php', ['errors' => $errors, 'post_data' => $post_data]);
$tags_post = include_template('add_post_tag.php', ['errors' => $errors, 'post_data' => $post_data]);
$send_form = include_template('add_post_footer.php');
$page_content = include_template('add.php', [
    'tab' => $tab,
    'types' => $types,
    'block_errors' => $block_errors,
    'send_form' => $send_form,
    'title_post' => $title_post,
    'tags_post' => $tags_post,
    'errors' => $errors,
    'file_data' => $file_data,
    'post_data' => $post_data
]);
$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'title' => 'Популярное',
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);
print ($layout_content);