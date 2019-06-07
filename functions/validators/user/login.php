<?php

/**
 * Возвращает массив ошибок при валидации формы авторизации юзера
 * @param mysqli $connection
 * @param array $login_data
 * @param string|null $user
 * @return array|null
 */
function validate_login(mysqli $connection, array $login_data, ?string $user): ?array
{
    $errors = [];
    if ($error = validate_login_email($connection, $login_data['email'])) {
        $errors['email'] = $error;
    }
    if (empty($errors['email'])) {
        if ($error = validate_login_password($login_data['password'], $user)) {
            $errors['password'] = $error;
        }
    }
    return $errors;
}


/**
 * Проверяет поле Пароль для формы регистрации
 * @param string $password
 * @param string $user
 * @return array|null
 */
function validate_login_password(string $password, ?string $user): ?string
{
    if (empty($password)) {
        return 'Заполните поле';
    }
    if (mb_strlen($password) > 250) {
        return 'Максимальная длина 250 символов';
    }

    if (!password_verify($password, $user)) {
        return 'Неверный пароль';
    }
    return null;
}

/**
 * Проверяет поле email для формы регистрации
 * @param mysqli $connection
 * @param string $email
 * @return string|null
 */
function validate_login_email(mysqli $connection, string $email): ?string
{
    if (empty($email)) {
        return 'Заполните поле';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'Неправильно указан формат email';
    }
    if (mb_strlen($email) > 250) {
        return 'Максимальная длина 250 символов';
    }
    if (!get_email($connection, $email)) {
        return 'Данный email не зарегистрирован';
    }
    return null;

}
