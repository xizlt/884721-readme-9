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
    $sql = "SELECT id FROM users WHERE email = '$email_user'";
    $res = mysqli_query($connection, $sql);
    $isset = mysqli_num_rows($res);
    if ($isset > 0) {
        return true;
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