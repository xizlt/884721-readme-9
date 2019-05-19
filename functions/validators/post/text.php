<?php

function validate_post_text(array $post_data): array
{
    $errors = [];
    if ($error = validate_title($post_data['title'])) {
        $errors['title'] = $error;
    }
    if ($error = validate_message($post_data['message'])) {
        $errors['message'] = $error;
    }
    if ($error = validate_tags($post_data['tags'])) {
        $errors['tags'] = $error;
    }
    return $errors;
}


function validate_message(string $message): ?array
{
    if (empty($message)) {
        return $arr = [
            'for_block' => 'Текст. Введите текст',
            'for_title' => 'Заполните поле',
            'for_text' => 'Необходимо заполнить данное поле'
        ];
    }
    if (mb_strlen($message) > 1000) {
        return $arr = [
            'for_block' => 'Текст. Максимальная длина 1 000 символов',
            'for_title' => 'Привышена длина',
            'for_text' => 'Максимальная длина 1000 символов.'
        ];
    }
    return null;
}
