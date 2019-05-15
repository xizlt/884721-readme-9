<?php

/**
 * Возвращает массив ошибок валидации поста
 * @param array $post_data
 * @param string $add_post
 * @param array $file_data
 * @return array
 */
function validate_post(array $post_data, string $add_post, array $file_data): array
{
    $errors = [];
    if ($add_post === 'link') {
        if ($error = validate_post_link($post_data['link'])) {
            $errors['link'] = $error;
        }
    } elseif ($add_post === 'text') {
        if ($error = validate_post_message($post_data['message'])) {
            $errors['message'] = $error;
        }
    } elseif ($add_post === 'quote') {
        if ($error = validate_post_message($post_data['message'])) {
            $errors['message'] = $error;
        }
        if ($error = validate_post_quote($post_data['quote'])) {
            $errors['quote'] = $error;
        }
    } elseif ($add_post === 'photo') {
        if ($error = validate_post_photo($file_data['img'])) {
            $errors['img'] = $error;
        }
        if ($error = validate_post_link($post_data['link'])) {
            $errors['link'] = $error;
        }
    } elseif ($add_post === 'video') {
        if ($error = validate_post_video($post_data['link'])) {
            $errors['link'] = $error;
        }
    }

    if ($error = validate_post_title($post_data['title'])) {
        $errors['title'] = $error;
    }
    if ($error = validate_post_tags($post_data['tags'])) {
        $errors['tags'] = $error;
    }
    return $errors;
}


/**
 * Проверяет поле Заголовок
 * @param string $title
 * @return array|null
 */

function validate_post_title(string $title)
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
 * Проверяет поле <textarea>
 * @param string $message
 * @return array
 */
function validate_post_message(string $message)
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

/**
 * Проверят поле автор
 * @param string $quote
 * @return array|null
 */
function validate_post_quote(string $quote)
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

/**
 * Проверяет поле ссылка
 * @param $link
 * @return array|null
 */
function validate_post_link($link)
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

function validate_post_tags($tags)
{
    if (empty($tags)) {
        return $arr = [
            'for_block' => 'Ссылка. Заполните поле',
            'for_title' => 'Заполните поле',
            'for_text' => 'Необходимо заполнить данное поле'
        ];
    }
    if (!filter_var($tags, FILTER_VALIDATE_URL)) {
        return $arr = [
            'for_block' => 'Ссылка. Неправильно указана ссылка',
            'for_title' => 'Неверный формат',
            'for_text' => 'Необходимо заполнить поле в полном формате ссылки. Например: https://www.google.com/'
        ];
    }
    return null;
}

/**
 * Проверяет поле загрузки файла
 * @param array $file_data
 * @return array|null
 */
function validate_post_photo(array $file_data)
{
    $tmp_name = $file_data['tmp_name'];
    if ($tmp_name) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        if ($file_type !== 'image/jpg' and $file_type !== 'image/jpeg' and $file_type !== 'image/png') {
            return $arr = [
                'for_block' => 'Файл. Неподдерживаемый формат',
                'for_title' => 'Неверный формат',
                'for_text' => 'Необходимо загрузить файл в следующих форматах: .jpg .jpeg .png'
            ];
        }
        return null;
    }
    return $arr = [
        'for_block' => 'Файл. Выберите файл',
        'for_title' => 'Невыбран файл',
        'for_text' => 'Выберите файл для загрузки'
    ];
}


function validate_post_video($link)
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

