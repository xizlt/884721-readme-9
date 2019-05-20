<?php

/**
 * Возвращает массив ошибок при валидации формы регистрации юзера
 * @param mysqli $connection
 * @param array $user_data
 * @param array $file_data
 * @return array|null
 */
function validate_user(mysqli $connection, array $user_data, array $file_data): ?array
{
    $errors = [];
    if ($error = validate_user_name($user_data['name'])) {
        $errors['name'] = $error;
    }
    if ($error = validate_user_password($user_data['password'], $user_data['password-repeat'])) {
        $errors['password'] = $error;
    }
    if ($error = validate_user_email($connection, $user_data['email'])) {
        $errors['email'] = $error;
    }
    if ($error = validate_user_about($user_data['about'])) {
        $errors['about'] = $error;
    }
    if ($error = validate_avatar_file($file_data['avatar'])) {
        $errors['avatar'] = $error;
    }
    return $errors;
}

/**
 * Проверяет поле Имя для формы регистрации
 * @param string $name
 * @return array|null
 */
function validate_user_name(string $name): ?array
{
    if (empty($name)) {
        return $arr = [
            'for_block' => 'Имя. Заполните поле',
            'for_title' => 'Заполните поле',
            'for_text' => 'Необходимо заполнить данное поле'
        ];
    }
    if (mb_strlen($name) > 250) {
        return $arr = [
            'for_block' => 'Имя. Максимальная длина 250 символов',
            'for_title' => 'Привышена длина',
            'for_text' => 'Максимальная длина 250 символов.'
        ];
    }
    return null;
}

/**
 * Проверяет поле Пароль для формы регистрации
 * @param string $password
 * @param string $password_repeat
 * @return array|null
 */
function validate_user_password(string $password, string $password_repeat): ?array
{
    if (empty($password)) {
        return $arr = [
            'for_block' => 'Пароль. Заполните поле',
            'for_title' => 'Заполните поле',
            'for_text' => 'Необходимо заполнить данное поле'
        ];
    }
    if (mb_strlen($password) > 250) {
        return $arr = [
            'for_block' => 'Пароль. Максимальная длина 250 символов',
            'for_title' => 'Привышена длина',
            'for_text' => 'Максимальная длина 250 символов.'
        ];
    }
    if ($password !== $password_repeat) {
        return $arr = [
            'for_block' => 'Пароль. Несовпадают',
            'for_title' => 'Проверьте пароль',
            'for_text' => 'Вы неверно ввели повторный пароль'
        ];
    }
    return null;
}

/**
 * Проверяет поле email для формы регистрации
 * @param mysqli $connection
 * @param string $email
 * @return array|null
 */
function validate_user_email(mysqli $connection, string $email): ?array
{
    if (empty($email)) {
        return $arr = [
            'for_block' => 'Email. Заполните поле',
            'for_title' => 'Заполните поле',
            'for_text' => 'Необходимо заполнить данное поле'
        ];
    }
    if (get_email($connection, $email)) {
        return $arr = [
            'for_block' => 'Email. Данный email уже зарегистрирован',
            'for_title' => 'email уже используется',
            'for_text' => 'Укажите другой email'
        ];
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return $arr = [
            'for_block' => 'Email. Неправильно указан',
            'for_title' => 'Неверный формат',
            'for_text' => 'Необходимо заполнить поле в формате email. Например email@domen.com'
        ];
    }
    if (mb_strlen($email) > 250) {
        return $arr = [
            'for_block' => 'Email. Максимальная длина 250 символов',
            'for_title' => 'Привышена длина',
            'for_text' => 'Максимальная длина 250 символов.'
        ];
    }
    return null;

}

/**
 * Проверяет поле информация о себе
 * @param string $about
 * @return array|null
 */
function validate_user_about(string $about): ?array
{
    if (mb_strlen($about) > 1000) {
        return $arr = [
            'for_block' => 'Информация о себе. Максимальная длина 1000 символов',
            'for_title' => 'Привышена длина',
            'for_text' => 'Максимальная длина 1000 символов.'
        ];
    }
    return null;
}

/**
 * Проверяет поле аватар для формы регистрации
 * @param $file_data
 * @return array|null
 */
function validate_avatar_file(array $file_data): ?array
{
    $tmp_name = $file_data['tmp_name'];
    if ($tmp_name) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        if (!is_image($file_type)) {
            return $arr = [
                'for_block' => 'Файл. Неподдерживаемый формат',
                'for_title' => 'Неверный формат',
                'for_text' => 'Необходимо загрузить файл в следующих форматах: .gif .jpeg .png'
            ];
        }
    }
    return null;
}