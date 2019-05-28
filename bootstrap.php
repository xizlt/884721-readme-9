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

$config = require 'config.php';
$connection = connectDb($config['db']);

$user = null;
$user_id = $_SESSION['user_id'] ?? null;
if ($user_id) {
    $user = get_user_by_id($connection, $user_id) ?? null;
}
if (basename(__FILE__) !== 'index.php' && !$user) {
    header('Location: /');
    exit();
}


