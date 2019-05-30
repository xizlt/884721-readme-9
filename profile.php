<?php

require 'bootstrap.php';
require 'functions/validators/comments.php';

if (!$user) {
    header('Location: /');
    exit();
}

$user_id_ind = $_GET['id'] ?? null;
$user_id_ind = clean($user_id_ind);

$profile_block = $_GET['tab'] ?? null;
$profile_block = clean($profile_block);

$show_comments_block = $_GET['show'] ?? null;
$show_comments_block = clean($show_comments_block);

$post_id = $_GET['post-id'] ?? null;;
$post_id = clean($post_id);

$like = $_GET['likes'] ?? null;
$like = clean($like);

$subscription = $_GET['subscription'] ?? null;
$subscription = clean($subscription);

$repost = $_GET['repost'] ?? null;
$repost = clean($repost);

$posts = get_posts($connection, null, null, $user_id_ind);
$user_profile = get_user_by_id($connection, $user_id_ind);

$subscription_check = get_subscription($connection, $user['id'], $user_id_ind);

$error = null;

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


if ($subscription === 'true') {
    add_subscription($connection, $user['id'], $user_id_ind);
} elseif ($subscription === 'false') {
    dell_subscription($connection, $user['id'], $user_id_ind);
}

if ($like === 'ok') {
    if (!get_like_by_user($connection, $post_id, $user['id'])) {
        add_like($connection, $post_id, $user['id']);
        header("Location: $_SERVER[HTTP_REFERER]");
        exit();
    }
}

if ($repost) {
    add_repost($connection, $post_id);
}

$page_content = include_template('profile.php', [
    'posts' => $posts,
    'connection' => $connection,
    'user_profile' => $user_profile,
    'show_comments_block' => $show_comments_block,
    'user' => $user,
    'error' => $error,
    'subscription_check' => $subscription_check
]);
$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'title' => 'Популярное',
    'is_auth' => $is_auth,
    'user' => $user
]);
print ($layout_content);