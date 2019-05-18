<?php

/**
 * Возвращает ошибки в форме поля title
 * @param string $title
 * @return array|null
 */
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

/**
 * Возвращает ошибку если найден недопустимый символ в слове
 * @param string $tags
 * @return array|null
 */
function validate_tags(string $tags): ?array
{
    if(preg_match("/[^(\w)|(\x7F-\xFF)|(\s)]/",$tags))
        return $arr = [
    'for_block' => 'Теги. Недопустимые символы',
    'for_title' => 'Недопустимые символы',
    'for_text' => 'В тегах можно использовать только буквы, цифры, пробел и нижнее подчеркивание'
];
    return null;
}