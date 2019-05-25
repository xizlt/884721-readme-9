<?php

require 'bootstrap.php';
if (!$user) {
    header('Location: /');
    exit();
}

$post_id = $_GET['id'] ?? '';
if (empty($post_id)) {
    header("HTTP/1.0 404 Not Found");
    exit();
}

$post = get_post_info($connection, $post_id);
if (!$post) {
    header("HTTP/1.0 404 Not Found");
    exit();
}

$block_post = include_template(template_by_type($post['type']), ['post' => $post]);
$comments_count = get_count_comments($connection, $post_id);
$subscriptions = get_count_subscriptions($connection, $post['user']);
$comments = get_comments($connection, $post_id);

$page_content = include_template('post.php', [
    'post' => $post,
    'block_post' => $block_post,
    'comments_count' => $comments_count,
    'subscriptions' => $subscriptions,
    'comments' => $comments
]);

$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'title' => 'Публикация',
    'is_auth' => $is_auth,
    'user' => $user
]);
print ($layout_content);
