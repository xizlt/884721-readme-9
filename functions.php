<?php

/**
 * Возвращает текст в короткой форме по лимиту символов
 * @param string $text
 * @param int $length
 * @return string
 */
function clips_text($text, $length = 300)
{
    $length_content = strlen($text);
    $total = 0;
    if ($length_content > $length) {
        $array_words = explode(" ", $text);
        foreach ($array_words as $word) {
            $num = strlen($word);
            $total += $num;
            if ($total < $length) {
                $show_contentent[] = $word;
            }
        }
        return '<p>' . implode(' ', $show_contentent) . ' ...' . '</p>' . '<a class="post-text__more-link" href="#">Читать далее</a>';
    }
    return '<p>' . $text . '</p>';
}

/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 * @param string $name Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return string Итоговый HTML
 */
function include_template($name, array $data = []) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

/**
 * Xss защита
 * @param string $value
 * @return string
 */
function clean($value)
{
    //$value = trim($value);
    //$value = stripslashes($value);
   // $value = strip_tags($value);
    $value = htmlspecialchars($value);

    return $value;
}