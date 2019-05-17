<?php

/**
 * Возвращает посты по условиям
 * @param mysqli $connection
 * @param string|null $type
 * @param string|null $sort
 * @param int|null $user_id
 * @return array
 */
function get_posts(mysqli $connection, string $type = null, string $sort = null, int $user_id = null): array
{
    if (!$type) {
        $type = 'c.id';
    }
    if (!$sort) {
        $sort = 'view_count';
    }

    $sql = "SELECT p.id,
       p.create_time,
       p.title,
       p.message,
       p.quote_writer,
       p.image,
       p.video,
       p.link,
       p.view_count,
       p.content_type_id,
       u.name AS user_name,
       c.name AS type,
       u.avatar,
       count(l.user_id) AS like_post
FROM posts p
         LEFT JOIN likes l ON p.id = l.post_id
         LEFT JOIN  users u ON u.id = p.user_id
         JOIN content_type c ON c.id = p.content_type_id
WHERE p.content_type_id = $type
GROUP BY p.id
ORDER BY $sort DESC
";
    if ($query = mysqli_query($connection, $sql)) {
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($connection);
        die('Ошибка MySQL ' . $error);
    }
    return $result;
}

/**
 * Возвращает информацию по посту
 * @param mysqli $connection
 * @param int $post_id
 * @return array|null
 */
function get_post_info(mysqli $connection, int $post_id)
{
    $sql = "SELECT p.id,
       p.create_time,
       p.title,
       p.message,
       p.quote_writer,
       p.image,
       p.video,
       p.link,
       p.view_count,
       SUM(p.is_repost) AS repost,
       COUNT(p.user_id) AS public,
       u.name AS user_name,
       c.name AS type,
       u.avatar,
       p.user_id AS user,
       u.create_time as user_reg,
       COUNT(l.user_id) AS like_post
FROM posts p
         JOIN likes l ON p.id = l.post_id
         JOIN users u ON u.id = p.user_id
         JOIN content_type c ON c.id = p.content_type_id
WHERE p.id = $post_id
";
    if ($query = mysqli_query($connection, $sql)) {
        $result = $query ? mysqli_fetch_array($query, MYSQLI_ASSOC) : null;
    } else {
        $error = mysqli_error($connection);
        die('Ошибка MySQL ' . $error);
    }
    return $result;
}

/**
 * Добовление поста
 * @param mysqli $connection
 * @param array $post_data
 * @param int $type_id
 * @return int|string
 */
function add_post(mysqli $connection, array $post_data, int $type_id)
{
    $sql = 'INSERT INTO posts (title, message, quote_writer, image, video, link, user_id, content_type_id) 
            VALUES (?, ?, ?, ?, ?, ?, 1, ?)';
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'ssssssi',
        $post_data['title'],
        $post_data['message'],
        $post_data['quote'],
        $post_data['img'],
        $post_data['video'],
        $post_data['link'],
        $type_id
    );
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    if (!$result) {
        die('Ошибка при сохранении лота');
    }
    $post_id = mysqli_insert_id($connection);
    return $post_id;
}
