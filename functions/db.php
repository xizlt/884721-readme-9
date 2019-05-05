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