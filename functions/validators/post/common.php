<?php

function validate_title(string $title): ?array
{
    if (empty($title)) {
        return $arr = [
            'for_block' => 'Заголовок. Укажите заголовок',
            'for_title' => 'Нет заголовка',
            'for_text' => 'Необходимо заполнить данное поле'
        ];
    }
    if (mb_strlen($title) > 250) {
        return $arr = [
            'for_block' => 'Заголовок. Максимальная длина 250 символов',
            'for_title' => 'Привышена длина',
            'for_text' => 'Максимальная длина 250 символов. Пожалуйста укоротите заголовок'
        ];
    }
    return null;
}

function validate_tags(string $tags): ?array
{
    // TODO: реализовать проверку что строка состоит из букв и пробелов
    return null;
}