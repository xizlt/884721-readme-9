<?php

function validate_post_photo(array $post_data, array $file_data): array
{
    $errors = [];
    if ($error = validate_title($post_data['title'])) {
        $errors['title'] = $error;
    }
    if ($error = validate_img($file_data['img'])) {
        $errors['img'] = $error;
    }
    if ($error = validate_link_upload($post_data['link'])) {
        $errors['link'] = $error;
    }
    if ($error = validate_tags($post_data['tags'])) {
        $errors['tags'] = $error;
    }
    return $errors;
}

/**
 * Проверяет поле загрузки файла
 * @param array $file_data
 * @return array|null
 */
function validate_img(array $file_data)
{
    $tmp_name = $file_data['tmp_name'];
    if ($tmp_name) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        if ($file_type !== 'image/jpg' and $file_type !== 'image/jpeg' and $file_type !== 'image/png') {
            return $arr = [
                'for_block' => 'Файл. Неподдерживаемый формат',
                'for_title' => 'Неверный формат',
                'for_text' => 'Необходимо загрузить файл в следующих форматах: .jpg .jpeg .png'
            ];
        }
        return null;
    }
    return $arr = [
        'for_block' => 'Файл. Выберите файл',
        'for_title' => 'Невыбран файл',
        'for_text' => 'Выберите файл для загрузки'
    ];
}

/**
 * Проверяет поле ссылка
 * @param string $link
 * @return array|null
 */
function validate_link_upload(string $link)
{
    if (!empty($link)) {
        if (!filter_var($link, FILTER_VALIDATE_URL)) {
            return $arr = [
                'for_block' => 'Ссылка. Неправильно указана ссылка',
                'for_title' => 'Неверный формат',
                'for_text' => 'Необходимо заполнить поле в полном формате ссылки. Например: https://www.google.com/'
            ];
        }
        $urlHeaders = get_headers($link, 1);
// проверяем ответ сервера на наличие кода: 200 - ОК
        if (!strpos($urlHeaders[0], '200')) {
            return $arr = [
                'for_block' => 'Ссылка. Неверно указан путь',
                'for_title' => 'Ошибка в загрузке',
                'for_text' => 'Проверьте правильность пути к файлу'
            ];
        }
        if ($urlHeaders['Content-Type'] !== 'image/jpg' and $urlHeaders['Content-Type'] !== 'image/jpeg' and $urlHeaders['Content-Type'] !== 'image/png') {
            return $arr = [
                'for_block' => 'Ссылка. Неподдерживаемый формат',
                'for_title' => 'Неподдерживаемый формат',
                'for_text' => 'Необходимо загрузить файл в следующих форматах: .jpg .jpeg .png'
            ];
        }
    }
    return null;
}