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
    if (mb_strlen($comment) < 4) {
        return 'Введите более 4 символов';
    }
    return null;
}


/**
 * Возвращает ошибки поля message
 * @param string $message
 * @return string|null
 */
function validate_message(string $message): ?string
{
    if (empty($message)) {
        return 'Введите текст';
    }
    if (mb_strlen($message) > 1000) {
        return 'Максимальная длина 1 000 символов';
    }
    return null;
}