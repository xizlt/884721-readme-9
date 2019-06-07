<?php
require 'bootstrap.php';


mysqli_query($connection,
    "START TRANSACTION");
$res1 = mysqli_query($connection,
    "UPDATE posts SET is_repost = is_repost + 1 WHERE id = $post_id");

$res3 = mysqli_query($connection,
    "INSERT INTO posts (title, message, quote_writer, image, video, link, user_id, content_type_id, repost_doner_id) 
                VALUE (
                {$post['title']},
                {$post['message']},
                {$post['quote_writer']},
                {$post['image']},
                {$post['video']},
                {$post['link']},
                $user,
                {$post['type']},
                {$post['user']}
                )");

if ($res1 && $res3) {
    mysqli_query($connection,
        "COMMIT");
} else {
    mysqli_query($connection,
        "ROLLBACK");
}

// Лайк: like.php?post_id=


