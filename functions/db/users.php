<?php

/**
 * Сверка email для формы регистрации юзера
 * @param mysqli $connection
 * @param string $email
 * @return bool|null
 */
function get_email(mysqli $connection, string $email): ?bool
{
    $email_user = mysqli_real_escape_string($connection, $email);
    $sql = "SELECT id FROM users WHERE email = ?";
    mysqli_prepare($connection, $sql);
    $stmt = db_get_prepare_stmt($connection, $sql, [$email_user]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($res) {
        $isset = mysqli_num_rows($res);
        if ($isset > 0) {
            return true;
        }
    }
    return null;
}


/**
 * Запись нового юзера
 * @param $connection
 * @param $user_data
 * @return int|string
 */
function add_user($connection, $user_data)
{
    $password = password_hash($user_data['password'], PASSWORD_DEFAULT);
    $sql = 'INSERT INTO users (name, email, about, avatar, password) VALUE (? ,? ,? ,? ,?)';
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'sssss',
        $user_data['name'],
        $user_data['email'],
        $user_data['about'],
        $user_data['avatar'],
        $password
    );
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    if ($result) {
        $user_id = mysqli_insert_id($connection);
        return $user_id;
    }
    return null;
}

/**
 * Получение массива с данными о пользователе по id
 * @param mysqli $connection
 * @param int $id
 * @return array|null
 */
function get_user_by_id(mysqli $connection, int $id): ?array
{
    $sql = "SELECT * FROM users WHERE id = ?";
    mysqli_prepare($connection, $sql);
    $stmt = db_get_prepare_stmt($connection, $sql, [$id]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($res) {
        $result = mysqli_fetch_array($res, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($connection);
        die('Ошибка MySQL ' . $error);
    }
    return $result;
}

/**
 * Получение данных юзера
 * @param mysqli $connection
 * @param string $email
 * @return array|null
 */
function get_user_by_email(mysqli $connection, string $email): ?array
{
    $email = mysqli_real_escape_string($connection, $email);
    $sql = "SELECT * FROM users WHERE email = ?";
    mysqli_prepare($connection, $sql);
    $stmt = db_get_prepare_stmt($connection, $sql, [$email]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($res) {
        $result = mysqli_fetch_array($res, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($connection);
        die('Ошибка MySQL ' . $error);
    }
    return $result;
}