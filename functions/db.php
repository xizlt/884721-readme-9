<?php
/**
 * подключение к БД
 * @param $config
 * @return mysqli
 */
function connectDb($config)
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
 * @param $connection
 * @return array|int|null
 */
function get_types($connection)
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
 * Возвращает популярные посты на главной странице
 * @param $connection
 * @return array|int|null|string
 */
function get_posts($connection)
{
    $sql = 'SELECT p.id,
       p.create_time,
       p.title,
       p.message,
       p.quote_writer,
       p.image,
       p.video,
       p.link,
       p.content_type_id,
       u.name AS user_name,
       c.name AS type,
       u.avatar,
       COUNT(l.user_id) AS like_post
FROM posts p
         JOIN likes l ON p.id = l.post_id
         JOIN users u ON u.id = p.user_id
         JOIN content_type c ON c.id = p.content_type_id
GROUP BY p.id
ORDER BY like_post DESC
LIMIT 6
';
    if ($query = mysqli_query($connection, $sql)) {
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($connection);
        die('Ошибка MySQL ' . $error);
    }
    return $result;
}

/**
 * Возвращает посты по категориям
 * @param $connection
 * @param $type_block
 * @return array|null
 */
function get_posts_type($connection,int $type_block)
{
    $sql = "SELECT p.id,
       p.create_time,
       p.title,
       p.message,
       p.quote_writer,
       p.image,
       p.video,
       p.link,
       u.name AS user_name,
       c.name AS type,
       u.avatar,
       COUNT(l.user_id) AS like_post
FROM posts p
         JOIN likes l ON p.id = l.post_id
         JOIN users u ON u.id = p.user_id
         JOIN content_type c ON c.id = p.content_type_id
WHERE c.id = '$type_block'
GROUP BY p.id
ORDER BY like_post DESC
LIMIT 9
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
 * @param $connection
 * @param $type_block
 * @return array|null
 */
function get_types_by_id($connection,int $type_block)
{
    $sql = "SELECT * FROM content_type c
WHERE c.id = '$type_block'
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
 * Проверяет существование поста
 * @param $connection
 * @param $type_block
 * @return array|null
 */
function get_post_by_id($connection,int $type_block)
{
    $sql = "SELECT * FROM posts p
WHERE p.id = '$type_block'
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
 * Возвращает информацию по посту
 * @param $connection
 * @param $post_id
 * @return array|null
 */
function get_post_info($connection,int $post_id)
{
    $sql = "SELECT p.id,
       p.create_time,
       p.title,
       p.message,
       p.quote_writer,
       p.image,
       p.video,
       p.link,
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
WHERE p.id = '$post_id'
GROUP BY p.id
ORDER BY like_post DESC
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
 * @param $connection
 * @param $post_id
 * @return array|null
 */
function get_count_comments($connection,int $post_id)
{
    $sql = "SELECT
        COUNT(cm.id) AS count_comments
FROM comments cm
WHERE cm.post_id = $post_id
GROUP BY cm.post_id
";
    if ($query = mysqli_query($connection, $sql)) {
        $result = mysqli_fetch_array($query, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($connection);
        die('Ошибка MySQL ' . $error);
    }
    return $result;
}

/**
 * Возвращает кол-во подписчиков автора поста
 * @param $connection
 * @param $user
 * @return array|null
 */
function get_count_subscriptions($connection, int $user)
{
    $sql = "SELECT
        COUNT(s.subscriber_id) AS count_user
FROM subscriptions s
WHERE s.user_id = $user
GROUP BY s.user_id
";
    if ($query = mysqli_query($connection, $sql)) {
        $result = mysqli_fetch_array($query, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($connection);
        die('Ошибка MySQL ' . $error);
    }
    return $result;
}

/**
 * Возвращает комментарии по id поста
 * @param $connection
 * @param $post_id
 * @return array|null
 */
function get_comments($connection, int $post_id)
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