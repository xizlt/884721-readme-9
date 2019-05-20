<?php

require 'bootstrap.php';
require 'functions/validators/user/login.php';

$login_data = null;
$errors = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login_data = $_POST ?? null;
    $login_data = clean($login_data);
    $user = get_user_by_email($connection, $login_data['email']);
    $errors = validate_login($connection, $login_data, $user['password']);

    if (!$errors) {
        $_SESSION['user_id'] = $user['id'];

        header("Location: feed.php");
        exit();
    }
}

$layout_content = include_template('index.php', [
    'title' => 'Популярное',
    'is_auth' => $is_auth,
    'user' => $user,
    'errors' => $errors,
    'login_data' => $login_data
]);
print ($layout_content);