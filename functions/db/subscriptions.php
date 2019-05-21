<?php
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
