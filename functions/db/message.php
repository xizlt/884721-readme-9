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
    $dialog = $sender_id . 1 . $recipient_id;
    $sql = 'INSERT INTO messages (message, sender_id, recipient_id, dialog) 
            VALUES (?,?,?,?)';
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'siis', $message, $sender_id, $recipient_id, $dialog);
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

function get_users_message(mysqli $connection, int $recipient_id, $user_id_ind): ?array
{
    $sql = "SELECT * FROM messages m
JOIN users u ON u.id = m.sender_id
WHERE (recipient_id, create_date) IN
   (SELECT recipient_id, MAX(create_date) FROM messages
    GROUP BY sender_id, recipient_id)";
    mysqli_prepare($connection, $sql);
    $stmt = db_get_prepare_stmt($connection, $sql, []);
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


function get_message_my(mysqli $connection, int $recipient_id): ?array
{
    $sql = "SELECT m.id,
m.message,
m.create_date,
m.sender_id,
m.recipient_id,
m.is_read,
u.name AS user_name,
u.id AS user_id,
u.avatar
FROM messages m
         LEFT JOIN users u ON u.id = m.recipient_id
			WHERE (create_date) IN (SELECT MAX(create_date) FROM messages GROUP BY recipient_id)
			and m.sender_id = ?
         GROUP BY m.id";
    mysqli_prepare($connection, $sql);
    $stmt = db_get_prepare_stmt($connection, $sql, [$recipient_id]);
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

function get_message_me(mysqli $connection, int $recipient_id): ?array
{
    $sql = "SELECT m.id,
m.message,
m.create_date,
m.sender_id,
m.recipient_id,
m.is_read,
u.name AS user_name,
u.id AS user_id,
u.avatar
FROM messages m
LEFT JOIN users u ON u.id = m.sender_id
WHERE (create_date) IN (SELECT MAX(create_date) FROM messages GROUP BY sender_id)
and m.recipient_id = ?
GROUP BY m.id
";
    mysqli_prepare($connection, $sql);
    $stmt = db_get_prepare_stmt($connection, $sql, [$recipient_id]);
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




function get_message_user_id(mysqli $connection, int $user, $user_id): ?array
{
    $sql = "SELECT 
m.message,
m.create_date,
m.sender_id,
m.recipient_id,
m.is_read,
u.name AS user_name,
u.id AS user_id,
u.avatar, 
MAX(m.id) AS mas_id
FROM messages m 
join users u ON m.sender_id = u.id
WHERE (recipient_id = ? and sender_id = ?) or (recipient_id =?  and sender_id =?)
GROUP BY m.id
ORDER BY MAX(m.id) DESC
LIMIT 1
";
    mysqli_prepare($connection, $sql);
    $stmt = db_get_prepare_stmt($connection, $sql, [$user,$user_id,$user_id, $user]);
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



function get_mess(mysqli $connection, int $user): ?array
{
    $sql = "SELECT *, u.name as user_name
FROM messages m
join users u ON m.sender_id = u.id
                    WHERE m.id
                          IN(SELECT MAX(m.id)
                          FROM messages m
                          WHERE m.sender_id = ? OR m.recipient_id = ?
                          GROUP BY m.dialog)
                    ORDER BY m.create_date DESC

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


function get_dialogs($con, int $user_id)
{
    $dialogs_sql = "SELECT create_date, content, sen_id, rec_id,  dialog_name
                    FROM messages
                    WHERE mes_id
                          IN(SELECT max(mes_id)
                          FROM messages
                          WHERE sen_id = $user_id OR rec_id = $user_id
                          GROUP BY dialog_name)
                    ORDER BY pub_date DESC";
    $dialogs_res = mysqli_query($con, $dialogs_sql);
    $dialogs = mysqli_fetch_all($dialogs_res, MYSQLI_ASSOC);
    return $dialogs;
}