<?php
require_once 'bootstrap.php';
require_once "functions/message.php";
require_once "functions/validators/comments.php";

$user_dialog = $_GET['u'] ?? null;
$user_dialog = (int)$user_dialog;

$messages = get_all_message($connection, $user['id']);
$my_dialog = my_dialogs($messages, $user['id']);

$dialogs = array_unique($my_dialog);

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $text_message = $_POST['text'];
    $text_message = clean($text_message);

    $error = validate_comment($text_message) ?? null;
    if (!$error) {
        add_message($connection, $user['id'], $user_dialog, $text_message);
        header("Refresh:0");
    }
}
if ($user_dialog) {
    add_read($connection, $user['id'], $user_dialog);
}

$page_content = include_template('message.php', [
    'dialogs' => $dialogs,
    'user' => $user,
    'connection' => $connection,
    'user_dialog' => $user_dialog,
    'error' => $error
]);
$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'title' => 'Сообщения',
    'search' => $search,
    'user' => $user,
    'new_messages' => $new_messages
]);
print ($layout_content);