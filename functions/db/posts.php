<?php

/**
 * Возвращает посты по условиям
 * @param mysqli $connection
 * @param string|null $type
 * @param string|null $order_by
 * @param int|null $user_id
 * @return array
 */
function get_posts(mysqli $connection, string $type = null, string $order_by = null, int $user_id = null, int $page_items = null, int $offset = null): array
{
    $type_ind = 'p.content_type_id = ';
    if ($user_id) {
        if ($type) {
            $where = "u.id = $user_id AND $type_ind $type";
        }
        if (!$type) {
            $where = "u.id = $user_id AND $type_ind  c.id";
        }
    } else {
        if ($type) {
            $where = $type_ind . $type;
        }
        if (!$type) {
            $where = "$type_ind c.id";
        }
    }
    if (!$order_by) {
        $order_by = 'view_count';
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
       u.id AS user,
       c.name AS type,
       u.avatar,
       p.is_repost AS repost,
       count(l.user_id) AS like_post
FROM posts p
         LEFT JOIN likes l ON p.id = l.post_id
         LEFT JOIN  users u ON u.id = p.user_id
         JOIN content_type c ON c.id = p.content_type_id
WHERE $where
GROUP BY p.id
ORDER BY $order_by DESC
LIMIT $page_items 
OFFSET $offset
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
function get_post_info(mysqli $connection, int $post_id): ?array
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
       p.is_repost AS repost,
       COUNT(p.user_id) AS public,
       u.name AS user_name,
       c.name AS type,
       u.avatar,
       p.user_id AS user,
       u.create_time as user_reg,
       COUNT(l.user_id) AS like_post
FROM posts p
         left JOIN likes l ON p.id = l.post_id
         JOIN users u ON u.id = p.user_id
         JOIN content_type c ON c.id = p.content_type_id
WHERE p.id = ?
GROUP BY p.id
";
    mysqli_prepare($connection, $sql);
    $stmt = db_get_prepare_stmt($connection, $sql, [$post_id]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($res) {
        $result = mysqli_fetch_assoc($res);
    } else {
        $error = mysqli_error($connection);
        die('Ошибка MySQL ' . $error);
    }
    if ($result['id']) {
        return $result;
    }
    return null;
}

/**
 * Добовление поста
 * @param mysqli $connection
 * @param array $post_data
 * @param int $type_id
 * @param int $user
 * @return int|string
 */
function add_post(mysqli $connection, array $post_data, int $type_id, int $user)
{
    $sql = 'INSERT INTO posts (title, message, quote_writer, image, video, link, user_id, content_type_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'ssssssii',
        $post_data['title'],
        $post_data['message'],
        $post_data['quote'],
        $post_data['img'],
        $post_data['video'],
        $post_data['link'],
        $user,
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

/**
 * Возвращает кол-во поблукаций для данного юзера
 * @param mysqli $connection
 * @param int $user_id
 * @return int
 */
function get_count_public(mysqli $connection, int $user_id): int
{
    $sql = "SELECT
        id
FROM posts
WHERE user_id = ?
";
    mysqli_prepare($connection, $sql);
    $stmt = db_get_prepare_stmt($connection, $sql, [$user_id]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($res) {
        $result = mysqli_num_rows($res);
    } else {
        $error = mysqli_error($connection);
        die('Ошибка MySQL ' . $error);
    }
    return $result;
}


/**
 * Обнавляет таблицу постов и добовляет кол-ву репостов +1
 * @param mysqli $connection
 * @param int $post_id
 * @return bool
 */
function add_repost(mysqli $connection, int $post_id): bool
{
    $sql = "UPDATE posts SET is_repost = is_repost + 1
WHERE id = ?
";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'ii', $post_id, $post_id
    );
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $result;
}

/**
 * Возвращает кол-во постов
 * @param mysqli $connection
 * @return array
 */
function get_count_posts(mysqli $connection) : int
{
    $sql = "SELECT id AS cnt
FROM posts
";
    if ($query = mysqli_query($connection, $sql)) {
        $result = mysqli_num_rows($query);
    } else {
        $error = mysqli_error($connection);
        die('Ошибка MySQL ' . $error);
    }
    return $result;
}