<?php

/**
 * Возвращает ошибки поля комментарий
 * @param string $comment
 * @return string|null
 */
function validate_comment(string $comment): ?string
{
    if (empty($comment)) {
        return 'Введите текст';
    }
    if (mb_strlen($comment) > 1000) {
        return 'Максимальная длина 1 000 символов';
    }
    return null;
}
