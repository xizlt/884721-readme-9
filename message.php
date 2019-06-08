<?php

require 'bootstrap.php';
require 'functions/validators/comments.php';

if (!$user) {
    header('Location: /');
    exit();
}

$error = null;

$user_id_ind = $_GET['tab'] ?? null;
$user_id_ind = (int)clean($user_id_ind);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message'];
    $message = clean($message);

    $error = validate_comment($message) ?? null;

    if (!$error) {
        add_message($connection, $message, $user['id'], $user_id_ind);
        header("Location: $_SERVER[HTTP_REFERER]");
        exit();
    }
}

$count_message = get_count_message($connection, 2, 35);
$messages = get_message($connection, $user_id_ind, $user['id']);
$users_messages = get_users_message($connection, $user['id']);



$page_content = include_template('message.php', [
    'error' => $error,
    'messages' => $messages,
    'count_message' => $count_message,
    'user' => $user,
    'users_messages' => $users_messages,
    'user_id_ind' => $user_id_ind

]);
$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'title' => 'Популярное',
    'user' => $user,
    'search' => $search
]);
print ($layout_content);
