<?php

/**
 * Возвращает массив ошибок валидации поста
 * @param array $post_data
 * @param string $add_post
 * @return array
 */
function validate_post(array $post_data, string $add_post): array
{
    $errors = [];
    if ($add_post === 'link') {
        if ($error = validate_post_title($post_data['title'])) {
            $errors['title'] = $error;
        }
        if ($error = validate_post_link($post_data['link'])) {
            $errors['link'] = $error;
        }
        if ($error = validate_post_tags($post_data['tags'])) {
            $errors['tags'] = $error;
        }
    }

    elseif ($add_post === 'text') {
        if ($error = validate_post_title($post_data['title'])) {
            $errors['title'] = $error;
        }
        if ($error = validate_post_message($post_data['message'])) {
            $errors['message'] = $error;
        }
        if ($error = validate_post_tags($post_data['tags'])) {
            $errors['tags'] = $error;
        }
    }

    elseif ($add_post === 'quote') {
        if ($error = validate_post_title($post_data['title'])) {
            $errors['title'] = $error;
        }
        if ($error = validate_post_message($post_data['message'])) {
            $errors['message'] = $error;
        }
        if ($error = validate_post_message($post_data['quote'])) {
            $errors['quote'] = $error;
        }
        if ($error = validate_post_tags($post_data['tags'])) {
            $errors['tags'] = $error;
        }
    }

    elseif ($add_post === 'photo') {
        if ($error = validate_post_title($post_data['title'])) {
            $errors['title'] = $error;
        }
        /*if ($error = validate_post_photo($post_data['img'])) {
            $errors['img'] = $error;
        }*/
        if ($error = validate_post_link($post_data['link'])) {
            $errors['link'] = $error;
        }
        if ($error = validate_post_tags($post_data['tags'])) {
            $errors['tags'] = $error;
        }
    }

    elseif ($add_post === 'video') {
        if ($error = validate_post_title($post_data['title'])) {
            $errors['title'] = $error;
        }
        if ($error = validate_post_link($post_data['link'])) {
            $errors['link'] = $error;
        }
        if ($error = validate_post_tags($post_data['tags'])) {
            $errors['tags'] = $error;
        }
    }
    return $errors;
}


/**
 * Проверяет поле Заголовок
 * @param string $title
 * @return string|null
 */
function validate_post_title($title)
{
    if (empty($title)) {
        return 'Укажите заголовок';
    }
    if (mb_strlen($title) > 250) {
        return 'Максимальная длина строки 250 символов';
    }
    return null;
}


/**
 * Проверяет поле <textarea>
 * @param string $message
 * @return string|null
 */
function validate_post_message($message)
{
    if (empty($message)) {
        return 'Введите текст';
    }
    if (mb_strlen($message) > 1000) {
        return 'Максимальная длина 1 000 символов';
    }
    return null;
}


function validate_post_link($link)
{
    if (empty($link)) {
        return 'Заполните поле ссылка';
    }
    if (!filter_var($link, FILTER_VALIDATE_URL)) {
        return 'Проверьте правильность написания ссылки';
    }

return null;
}

function validate_post_tags($tags)
{

}

function validate_post_photo($img)
{

}

function validate_post_video($video)
{

}