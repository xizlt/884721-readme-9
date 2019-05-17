<?php

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
 * Проверяет поле ссылка на видео
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
    if (!check_youtube_url($link)) {
        return $arr = [
            'for_block' => 'Ссылка. Данного файла нет',
            'for_title' => 'Файла нет',
            'for_text' => 'Проверьте наличие указываемого видео. Возможно его удалили или органичили доступ'
        ];
    }
    return null;
}