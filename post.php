<?php

require_once 'bootstrap.php';
require_once 'functions/validators/comments.php';
if (!$user) {
    header('Location: /');
    exit();
}

$post_id = $_GET['id'] ?? '';
$post_id = clean($post_id);

if (empty($post_id)) {
    header("HTTP/1.0 404 Not Found");
    exit();
}

$post = get_post_info($connection, $post_id);

if (!$post) {
    header("HTTP/1.0 404 Not Found");
    exit();
}

add_view($connection, $post_id);

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = $_POST['comment'];
    $comment = clean($comment);

    $error = validate_comment($comment) ?? null;
    if (!$error) {
        add_comment($connection, $user['id'], $post_id, $comment);
        header("Location: post.php?id=$post_id");
        exit();
    }
}

$subscription_check = get_subscription($connection, $user['id'], $post['user']);
$block_post = include_template(template_by_type($post['type']), ['post' => $post]);
$comments_count = get_count_comments($connection, $post_id);
$subscriptions = get_count_subscriptions($connection, $post['user']);
$comments = get_comments($connection, $post_id, 2);
$public_count = get_count_public($connection, $post['user']);

$all_comments = $_GET['com'] ?? null;
$all_comments = clean($all_comments);

$no_limit = null;

if ($all_comments === 'all') {
    $comments = get_comments($connection, $post_id);
    $no_limit = true;
}

$page_content = include_template('post.php', [
    'post' => $post,
    'block_post' => $block_post,
    'comments_count' => $comments_count,
    'subscriptions' => $subscriptions,
    'comments' => $comments,
    'user' => $user,
    'error' => $error,
    'connection' => $connection,
    'public_count' => $public_count,
    'subscription_check' => $subscription_check,
    'no_limit' => $no_limit
]);

$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'title' => 'Просмотр поста',
    'search' => $search,
    'user' => $user,
    'new_messages' => $new_messages
]);
print ($layout_content);
