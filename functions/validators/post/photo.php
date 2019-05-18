<?php

/**
 * Возвращает ошибки добавления поста типа photo
 * @param array $post_data
 * @param array $file_data
 * @return array
 */
function validate_post_photo(array $post_data, array $file_data): array
{
    $errors = [];
    if ($error = validate_title($post_data['title'])) {
        $errors['title'] = $error;
    }
    if ($error = validate_img($file_data['img'], $post_data)) {
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
 * Возвращает ошибки в форме поля загрузки файла
 * @param array $file_data
 * @return array|null
 */
function validate_img(array $file_data, $post_data)
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
    if (!$tmp_name and !$post_data['link']) {
        return $arr = [
            'for_block' => 'Загрузите файл или укажите ссылку',
            'for_title' => 'Незагружен файл',
            'for_text' => 'Необходимо загрузить файл в следующих форматах: .jpg .jpeg .png или указать ссылку на картинку'
        ];
    }
}

/**
 * Возвращает ошибки в форме поля ссылка
 * @param string $link
 * @return array|null
 */
function validate_link_upload(string $link): ?array
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