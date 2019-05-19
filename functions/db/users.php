<?php

/**
 * Сверка email для формы регистрации юзера
 * @param $connection
 * @param $email
 * @return string|null
 */
function get_email($connection, $email)
{
    $email_user = mysqli_real_escape_string($connection, $email);
    $sql = "SELECT id FROM users WHERE email = '$email_user'";
    $res = mysqli_query($connection, $sql);
    $isset = mysqli_num_rows($res);
    if ($isset > 0) {
        return false;
    }
    return null;
}
