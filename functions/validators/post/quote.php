<?php

/**
 * Возвращает ошибки добавления поста типа quote
 * @param array $post_data
 * @return array
 */
function validate_post_quote(array $post_data): array
{
    $errors = [];
    if ($error = validate_title($post_data['title'])) {
        $errors['title'] = $error;
    }
    if ($error = validate_message($post_data['message'])) {
        $errors['message'] = $error;
    }
    if ($error = validate_quote($post_data['quote'])) {
        $errors['quote'] = $error;
    }
    if ($error = validate_tags($post_data['tags'])) {
        $errors['tags'] = $error;
    }
    return $errors;
}

/**
 * Возвращает ошибки в форме поля автор
 * @param string $quote
 * @return array|null
 */
function validate_quote(string $quote)
{
    if (empty($quote)) {
        return $arr = [
            'for_block' => 'Автор. Введите текст',
            'for_title' => 'Пустое поле',
            'for_text' => 'Необходимо заполнить данное поле'
        ];
    }
    if (mb_strlen($quote) > 1000) {
        return $arr = [
            'for_block' => 'Автор. Максимальная длина 1 000 символов',
            'for_title' => 'Привышена длина',
            'for_text' => 'Максимальная длина 1000 символов.'
        ];
    }
    return null;
}