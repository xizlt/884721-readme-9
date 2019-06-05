<?php

/**
 * Добавление лайка посту
 * @param mysqli $connection
 * @param int $post_id
 * @param int $user
 * @return int|null
 */
function add_like(mysqli $connection, int $post_id, int $user): ?int
{
    $sql = 'INSERT INTO likes (user_id, post_id) 
            VALUES (?,?)';
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'ii', $user, $post_id);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    if (!$result) {
        die('Ошибка при сохранении');
    }
    $id = mysqli_insert_id($connection);
    return $id;
}


/**
 * Возвращает кол-во лайков для поста
 * @param mysqli $connection
 * @param int $post_id
 * @return int|null
 */
function get_count_likes(mysqli $connection, int $post_id): ?int
{
    $sql = "SELECT count(user_id) AS likes
FROM likes
WHERE post_id = ?
";
    mysqli_prepare($connection, $sql);
    $stmt = db_get_prepare_stmt($connection, $sql, [$post_id]);
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
 * Проверяет ставил ли юзер этому посту лайк
 * @param mysqli $connection
 * @param int $post_id
 * @param int $user_id
 * @return int|null
 */
function get_like_by_user(mysqli $connection, int $post_id, int $user_id): ?int
{
    $sql = "SELECT id
FROM likes
WHERE post_id = ? AND user_id = ?
";
    mysqli_prepare($connection, $sql);
    $stmt = db_get_prepare_stmt($connection, $sql, [$post_id, $user_id]);
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
 * Возвращает массив с юзерами которые ставили лайки посту
 * @param mysqli $connection
 * @param int $post_id
 * @return array|null
 */
function get_likes(mysqli $connection, int $post_id): ?array
{
    $sql = "SELECT user_id
FROM likes
WHERE post_id = ?";
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
    return $result;
}

