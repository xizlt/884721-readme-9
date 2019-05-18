<?php

/**
 * Возвращает ошибки добавления поста типа video
 * @param array $post_data
 * @return array
 */
function validate_post_video(array $post_data): array
{
    $errors = [];
    if ($error = validate_title($post_data['title'])) {
        $errors['title'] = $error;
    }
    if ($error = validate_video($post_data['link'])) {
        $errors['video'] = $error;
    }
    if ($error = validate_tags($post_data['tags'])) {
        $errors['tags'] = $error;
    }
    return $errors;
}

/**
 * Возвращает ошибки в форме поля ссылка на видео
 * @param $link
 * @return array|null
 */
function validate_video($link)
{
    if (empty($link)) {
        return $arr = [
            'for_block' => 'Ссылка. Заполните поле',
            'for_title' => 'Заполните поле',
            'for_text' => 'Необходимо заполнить данное поле'
        ];
    }
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

    return null;
}