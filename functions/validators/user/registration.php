<?php


//Возвращает массив ошибок при валидации формы регистрации юзера

function validate_user(mysqli $connection, array $user_data, array $file_data): ?array
{
    $errors = [];
    if ($error = validate_user_name($user_data['name'])) {
        $errors['name'] = $error;
    }
    if ($error = validate_user_password($user_data['password'])) {
        $errors['password'] = $error;
    }
    if ($error = validate_user_email($connection, $user_data['email'])) {
        $errors['email'] = $error;
    }
    if ($error = validate_user_about($user_data['contacts'])) {
        $errors['contacts'] = $error;
    }
    if ($error = validate_avatar_file($file_data['uploads'])) {
        $errors['uploads'] = $error;
    }
    return $errors;
}

/**
 * Проверяет поле Имя для формы регистрации
 * @param $name
 * @return string|null
 */
function validate_user_name($name)
{
    if (empty($name)) {
        return 'Заполните поле Имя';
    }
    if (mb_strlen($name) > 255) {
        return 'Допустимая длина строки 255 символов';
    }
    return null;
}

/**
 * Проверяет поле Пароль для формы регистрации
 * @param $password
 * @return string|null
 */
function validate_user_password($password)
{
    if (empty($password)) {
        return 'Заполните поле пароль';
    }
    if (mb_strlen($password) > 255) {
        return 'Допустимая длина строки 255 символов';
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

    if (!filter_var($email, FILTER_VALIDATE_URL)) {
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
 * Проверяет поле контакты для формы регистрации
 * @param $contacts
 * @return string|null
 */
function validate_user_about($contacts)
{
    if (empty($contacts)) {
        return 'Заполните поле контакты';
    }
    if (mb_strlen($contacts) > 1000) {
        return 'Допустимая длина строки 1000 символов';
    }
    return null;
}

/**
 * Проверяет поле аватар для формы регистрации
 * @param $file_data
 * @return string|null
 */
function validate_avatar_file($file_data)
{
    if (!$tmp_name = get_value($file_data, 'tmp_name')) {
        return null;
    }
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file_type = finfo_file($finfo, $tmp_name);
    if ($file_type !== 'image/gif' and $file_type !== 'image/jpg' and $file_type !== 'image/jpeg' and $file_type !== 'image/png') {
        return 'Файл нужно загрузить в формате .jpg, .jpeg, .png';
    }
    return null;
}