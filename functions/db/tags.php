<?php

function get_tag_by_name(mysqli $connection, string $name): ?array
{ $result = null;
        $sql = "SELECT * FROM tags
                WHERE name = ?";
    mysqli_prepare($connection, $sql);
    $stmt = db_get_prepare_stmt($connection, $sql, [$name]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($res) {
        $result = mysqli_fetch_array($res, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($connection);
        die('Ошибка MySQL ' . $error);
    }
    return $result;
}

/**
 * @param mysqli $connection
 * @param string $name
 * @return int id сохраненного тега
 */
function add_tag(mysqli $connection, string $name):int
{
    $sql = "INSERT INTO tags (name) 
            VALUES ?";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 's', $name);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    if (!$result) {
        die('Ошибка при сохранении лота');
    }
    $id = mysqli_insert_id($connection);
    return $id;
}

function add_posts_tags(mysqli $connection, int $tag_id, int $post_id):int
{
    $sql = 'INSERT INTO posts_tags (tag_id, post_id) 
            VALUES (?,?)';
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'ii', $tag_id, $post_id);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    if (!$result) {
        die('Ошибка при сохранении лота');
    }
    $id = mysqli_insert_id($connection);
    return $id;
}