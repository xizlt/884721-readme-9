<?php
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
