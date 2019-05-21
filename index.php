<?php
session_start();
date_default_timezone_set("Europe/Moscow");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$is_auth = rand(0, 1);

require_once 'functions/main.php';
require_once 'functions/db/common.php';
require_once 'functions/db/comments.php';
require_once 'functions/db/posts.php';
require_once 'functions/db/subscriptions.php';
require_once 'functions/db/tags.php';
require_once 'functions/db/types.php';
require_once 'functions/db/users.php';
require 'functions/validators/user/login.php';

$config = require 'config.php';
$connection = connectDb($config['db']);

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
    'errors' => $errors,
    'login_data' => $login_data
]);
print ($layout_content);