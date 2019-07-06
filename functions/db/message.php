<?php

/**
 *Получает все сообщения где адресат или получатель данный пользователь
 * @param mysqli $connection
 * @param int $user
 * @return array|null
 */
function get_all_message(mysqli $connection, int $user): ?array
{
    $sql = "SELECT *
FROM messages m
WHERE m.sender_id = ? OR m.recipient_id = ?
";
    mysqli_prepare($connection, $sql);
    $stmt = db_get_prepare_stmt($connection, $sql, [$user, $user]);
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

/**
 * Возвращает массив сообщений между пользователями
 * @param mysqli $connection
 * @param int $user
 * @param int $user_dialog
 * @return array
 */
function get_messages_for_dialog(mysqli $connection, int $user, int $user_dialog): array
{
    $sql = "SELECT *
FROM messages 
WHERE (sender_id = ? OR sender_id = ?) AND (recipient_id = ? OR recipient_id = ?)
GROUP BY id
ORDER BY create_date ASC  
";
    mysqli_prepare($connection, $sql);
    $stmt = db_get_prepare_stmt($connection, $sql, [$user, $user_dialog, $user, $user_dialog]);
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

/**
 * Возвращает массив сообщений между пользователями для отображения сообщений
 * @param mysqli $connection
 * @param int $user
 * @param int $user_dialog
 * @return array|null
 */
function get_message(mysqli $connection, int $user, int $user_dialog): ?array
{
    $sql = "SELECT *
FROM messages 
WHERE (sender_id = ? OR sender_id = ?) AND (recipient_id = ? OR recipient_id = ?)
GROUP BY id
ORDER BY create_date DESC  
LIMIT 1
";
    mysqli_prepare($connection, $sql);
    $stmt = db_get_prepare_stmt($connection, $sql, [$user, $user_dialog, $user, $user_dialog]);
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

/**
 * Возвращает общее кол-во непрочитанных сообщений
 * @param mysqli $connection
 * @param int $user
 * @param int $user_sender
 * @return int
 */
function get_count_new_message(mysqli $connection, int $user, int $user_sender): int
{
    $sql = "SELECT
        id
FROM messages
WHERE recipient_id = ? and sender_id = ? AND is_read = 'no'
";
    mysqli_prepare($connection, $sql);
    $stmt = db_get_prepare_stmt($connection, $sql, [$user, $user_sender]);
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
 * Возвращает кол-во непрочитанных сообщений с определенным пользователем
 * @param mysqli $connection
 * @param int $user
 * @return int
 */
function get_new_messages(mysqli $connection, ?int $user): ?int
{
    $sql = "SELECT *
FROM messages
WHERE recipient_id = ? AND is_read = 'no'
";
    mysqli_prepare($connection, $sql);
    $stmt = db_get_prepare_stmt($connection, $sql, [$user]);
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
 * Добавляет новое сообщение в БД
 * @param mysqli $connection
 * @param int $user_id
 * @param int $recipient_id
 * @param string $message
 * @return bool
 */
function add_message(mysqli $connection, int $user_id, int $recipient_id, string $message): bool
{
    $sql = 'INSERT INTO messages (sender_id, recipient_id, message) VALUE (? ,? ,?)';
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'iis', $user_id, $recipient_id, $message
    );
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $result;
}

/**
 * Помечает сообщение прочитанным
 * @param mysqli $connection
 * @param int $user_id
 * @param int $recipient_id
 * @return bool
 */
function add_read(mysqli $connection, int $user_id, int $recipient_id): bool
{
    $sql = 'UPDATE messages SET is_read = "yes"
    WHERE sender_id = ? AND recipient_id = ?';
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'ii', $recipient_id, $user_id);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $result;
}