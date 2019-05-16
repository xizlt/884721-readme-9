<?php
/**
 * Подключение к БД
 * @param array $config
 * @return mysqli
 */
function connectDb(array $config): mysqli
{
    $connection = mysqli_connect($config['host'], $config['user'], $config['password'], $config['database']);

    if ($connection === false) {
        die("Ошибка подключения: " . mysqli_connect_error()); // проверка на ошибку соединения
    }

    mysqli_set_charset($connection, "utf8");
    mysqli_options($connection, MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);

    return $connection;
}

/**
 * Возвращает типы контента
 * @param mysqli $connection
 * @return array
 */
function get_types(mysqli $connection): array
{
    $sql = 'SELECT * FROM content_type';
    if ($query = mysqli_query($connection, $sql)) {
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($connection);
        die('Ошибка MySQL ' . $error);
    }
    return $result;
}


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
       l.user_id AS like_post
FROM posts p
         JOIN likes l ON p.id = l.post_id
         JOIN users u ON u.id = p.user_id
         JOIN content_type c ON c.id = p.content_type_id
WHERE c.id = $type
GROUP BY like_post, p.id
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
 * Проверяет существования такой категории
 * @param mysqli $connection
 * @param string $type_id
 * @return int
 */
function get_type_by_id(mysqli $connection, string $type_id): int
{
    $sql = "SELECT * FROM content_type
WHERE id = '$type_id'
";
    if ($query = mysqli_query($connection, $sql)) {
        $result = mysqli_num_rows($query);
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
 * Возвращает кол-во постов
 * @param mysqli $connection
 * @param int $post_id
 * @return int
 */
function get_count_comments(mysqli $connection, int $post_id): int
{
    $sql = "SELECT
        id
FROM comments
WHERE post_id = $post_id
";
    if ($query = mysqli_query($connection, $sql)) {
        $result = mysqli_num_rows($query);
    } else {
        $error = mysqli_error($connection);
        die('Ошибка MySQL ' . $error);
    }
    return $result;
}

/**
 * Возвращает кол-во подписчиков автора поста
 * @param mysqli $connection
 * @param int $user_id
 * @return int
 */
function get_count_subscriptions(mysqli $connection, int $user_id) : int
{
    $sql = "SELECT
        subscriber_id
FROM subscriptions
WHERE user_id = $user_id
";
    if ($query = mysqli_query($connection, $sql)) {
        $result = mysqli_num_rows($query);
    } else {
        $error = mysqli_error($connection);
        die('Ошибка MySQL ' . $error);
    }
    return $result;
}


/**
 * Возвращает комментарии по id поста
 * @param mysqli $connection
 * @param int $post_id
 * @return array
 */
function get_comments(mysqli $connection, int $post_id): array
{
    $sql = "SELECT *,
       cm.create_time AS time_comment
FROM comments cm
     JOIN users u
ON u.id = cm.user_id
WHERE cm.post_id = $post_id
LIMIT 2
";
    if ($query = mysqli_query($connection, $sql)) {
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($connection);
        die('Ошибка MySQL ' . $error);
    }
    return $result;
}


function add_post($connection, $post_data)
{
    $sql = 'INSERT INTO posts (title, message, quote_writer, image, video, link, user_id, content_type_id) 
            VALUES (?, ?, ?, ?, ?, ?, 1, 1)';
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'ssssss',
    $post_data['title'],
    $post_data['message'],
    $post_data['quote'],
    $post_data['img'],
    $post_data['video'],
    $post_data['link']
    );
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    if (!$result) {
        die('Ошибка при сохранении лота');
    }
    $lot_id = mysqli_insert_id($connection);
    return $lot_id;
}
