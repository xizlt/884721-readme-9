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


$posts = get_posts($connection, null, null, $user_id_ind);
$user_profile = get_user_by_id($connection, $user_id_ind);

$post_id = $_GET['post-id'] ?? null;;
$post_id = clean($post_id);

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = $_POST['comment'];
    $comment = clean($comment);

    $error = validate_comment($comment) ?? null;
    if (!$error) {
        add_comment($connection, $user['id'], $post_id, $comment);
        header("Location: profile.php?id=$user_id_ind&post-id=$post_id&show=true");
        exit();
    }


    add_subscription($connection, $user['id'], $user_id_ind);


}


$page_content = include_template('profile.php', [
    'posts' => $posts,
    'connection' => $connection,
    'user_profile' => $user_profile,
    'show_comments_block' => $show_comments_block,
    'user' => $user,
    'error' => $error
]);
$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'title' => 'Популярное',
    'is_auth' => $is_auth,
    'user' => $user
]);
print ($layout_content);