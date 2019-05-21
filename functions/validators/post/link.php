<?php

/**
 * Возвращает ошибки добавления поста типа link
 * @param array $post_data
 * @return array
 */
function validate_post_link(array $post_data): array
{
    $errors = [];
    if ($error = validate_title($post_data['title'])) {
        $errors['title'] = $error;
    }
    if ($error = validate_link($post_data['link'])) {
        $errors['link'] = $error;
    }
    if ($error = validate_message_link($post_data['message'])) {
        $errors['message'] = $error;
    }
    if ($error = validate_tags($post_data['tags'])) {
        $errors['tags'] = $error;
    }
    return $errors;
}

/**
 * Возвращает ошибки в форме поля ссылка
 * @param $link
 * @return array|null
 */
function validate_link($link)
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
    return null;
}

function validate_message_link(string $message): ?array
{
    if (mb_strlen($message) > 1000) {
        return $arr = [
            'for_block' => 'Описание ссылки. Максимальная длина 1 000 символов',
            'for_title' => 'Привышена длина',
            'for_text' => 'Максимальная длина 1000 символов.'
        ];
    }
    return null;
}
