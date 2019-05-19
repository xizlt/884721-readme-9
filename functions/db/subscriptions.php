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
