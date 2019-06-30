<?php

require 'bootstrap.php';
require 'functions/validators/comments.php';

if (!$user) {
    header('Location: /');
    exit();
}

$user_id_ind = isset($_GET['id']) ? (int)$_GET['id'] : null;
$profile_block = isset($_GET['tab']) ? clean($_GET['tab']) : null;

if (!$profile_block) {
    $profile_block = 'posts';
}

$show_comments_block = $_GET['show'] ?? null;
$show_comments_block = clean($show_comments_block);

$post_id = $_GET['post_id'] ?? null;;
$post_id = (int)clean($post_id);

$error = null;
$order_by = 'create_time';

$user_profile = get_user_by_id($connection, $user_id_ind);

$subscription_check = get_subscription($connection, $user['id'], $user_id_ind);

if ($user['id'] === $user_id_ind) {
    $profiles = get_all_subscription($connection, $user['id']);
} else {
    $profiles = get_all_subscription($connection, $user_id_ind);
}

$posts = get_posts($connection, null, $order_by, $user_id_ind);
$likes = get_posts_tab_likes($connection, $user_id_ind) ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = $_POST['comment'];
    $comment = clean($comment);

    $error = validate_comment($comment) ?? null;
    if (!$error) {
        add_comment($connection, $user['id'], $post_id, $comment);
        header("Location: $_SERVER[HTTP_REFERER]");
        exit();
    }
}

$page_content = include_template('profile.php', [
    'posts' => $posts,
    'connection' => $connection,
    'user_profile' => $user_profile,
    'show_comments_block' => $show_comments_block,
    'user' => $user,
    'error' => $error,
    'subscription_check' => $subscription_check,
    'profile_block' => $profile_block,
    'profiles' => $profiles,
    'likes' => $likes

]);
$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'title' => 'Популярное',
    'search' => $search,
    'user' => $user
]);
print ($layout_content);