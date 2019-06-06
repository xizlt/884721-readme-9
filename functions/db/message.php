<?php


function get_count_message(mysqli $connection, int $sender_id, int $recipient_id): ?int
{
    $sql = "SELECT count(message) AS message
FROM messages
WHERE sender_id = ? AND recipient_id = ?
";
    mysqli_prepare($connection, $sql);
    $stmt = db_get_prepare_stmt($connection, $sql, [$sender_id, $recipient_id]);
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
 * Добавление сообщения
 * @param mysqli $connection
 * @param string $message
 * @param int $sender_id
 * @param int $recipient_id
 * @return bool
 */
function add_message(mysqli $connection, string $message, int $sender_id, int $recipient_id): bool
{
    $sql = 'INSERT INTO messages (message, sender_id, recipient_id) 
            VALUES (?,?,?)';
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'sii', $message, $sender_id, $recipient_id);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    if (!$result) {
        die('Ошибка при сохранении');
    }
    return $result;
}


function get_message(mysqli $connection, int $sender_id, int $recipient_id): ?array
{
    $sql = "SELECT * FROM messages m 
join users u ON m.sender_id = u.id
WHERE (recipient_id = ? and sender_id = ?) or (recipient_id =?  and sender_id =? )";
    mysqli_prepare($connection, $sql);
    $stmt = db_get_prepare_stmt($connection, $sql, [$recipient_id, $sender_id, $sender_id, $recipient_id]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($res) {
        $result = mysqli_fetch_all($res, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($connection);
        die('Ошибка MySQL ' . $error);
    }
    return $result;
}

function get_users_message(mysqli $connection, int $recipient_id): ?array
{
    $sql = "SELECT * FROM messages m
JOIN users u ON u.id = m.sender_id
WHERE (sender_id, create_date) IN
   (SELECT sender_id, MAX(create_date) FROM messages
    GROUP BY sender_id) AND recipient_id = ? AND sender_id != ?";
    mysqli_prepare($connection, $sql);
    $stmt = db_get_prepare_stmt($connection, $sql, [$recipient_id, $recipient_id]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($res) {
        $result = mysqli_fetch_all($res, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($connection);
        die('Ошибка MySQL ' . $error);
    }
    return $result;
}