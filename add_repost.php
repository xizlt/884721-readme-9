<?php

require "bootstrap.php";

$post_id = $_GET['post_id'] ?? null;;
$post_id = clean($post_id);

$post = get_post_info($connection, $post_id);

if ($post['user'] !== $user['id']) {
    add_repost($connection, $user['id'], $post);
}

header("Location: $_SERVER[HTTP_REFERER]");
exit();
