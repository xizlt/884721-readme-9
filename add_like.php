<?php
require "bootstrap.php";

$post_id = $_GET['post_id'] ?? null;;
$post_id = clean($post_id);

if (!get_like_by_user($connection, $post_id, $user['id'])) {
    add_like($connection, $post_id, $user['id']);
}

header("Location: $_SERVER[HTTP_REFERER]");
exit();