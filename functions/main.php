<?php
const MINUTE = 60;
const HOUR = 3600;
const DAY = 86400;
const WEEK = 604800;
const MONTH = 2419200;
const FIVE_WEEKS = 3024000;
const YEARS = 31556926;

/**
 * Возвращает текст в короткой форме по лимиту символов
 * @param string $text
 * @param int $length
 * @return string
 */
function clips_text(string $text, int $length = 300): string
{
    $length_content = mb_strlen($text);
    $total = 0;

    if ($length_content > $length) {
        $result_words = [];
        $words = explode(" ", $text);
        foreach ($words as $word) {
            $num = mb_strlen($word);
            $total += $num;
            if ($total >= $length) {
                break;
            }
            $result_words[] = $word;

        }
        return '<p>' . implode(' ',
                $result_words) . ' ...' . '</p>' . '<a class="post-text__more-link" href="#">Читать далее</a>';
    }
    return '<p>' . $text . '</p>';
}

/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 * @param string $name Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return string Итоговый HTML
 */
function include_template(string $name, array $data = []): string
{
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
 * @param string|array $value
 * @return string|array
 */
function clean($value)
{
    if (gettype($value) === 'array') {
        $result = [];
        foreach ($value as $key => $val) {
            $val = trim($val);
            $val = stripslashes($val);
            $val = strip_tags($val);
            $val = htmlspecialchars($val);
            $result += [$key => $val];
        }
        return $result;
    }
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);

    return $value;
}

/**
 * возвращает время в формате "Х дней назад"
 * @param string $time
 * @return string
 */
function publication_date(string $time): string
{
    $dt_pub = strtotime($time);
    $dt_now = time();
    $dt_diff = $dt_now - $dt_pub;
    $result = null;

    if ($dt_diff < HOUR) {
        $dt_create = floor($dt_diff / MINUTE);
        $result = $dt_create . get_noun_plural_form($dt_create, ' минута', ' минуты', ' минут') . ' назад';

    } elseif ($dt_diff >= HOUR and $dt_diff < DAY) {
        $dt_create = floor($dt_diff / HOUR);
        $result = $dt_create . get_noun_plural_form($dt_create, ' час', ' часа', ' часов') . ' назад';

    } elseif ($dt_diff >= DAY and $dt_diff < WEEK) {
        $dt_create = floor($dt_diff / DAY);
        $result = $dt_create . get_noun_plural_form($dt_create, ' день', ' дня', ' дней') . ' назад';

    } elseif ($dt_diff >= WEEK and $dt_diff < FIVE_WEEKS) {
        $dt_create = floor($dt_diff / WEEK);
        $result = $dt_create . get_noun_plural_form($dt_create, ' неделя', ' недели', ' недель') . ' назад';

    } elseif ($dt_diff >= FIVE_WEEKS) {
        $dt_create = floor($dt_diff / MONTH);
        $result = $dt_create . get_noun_plural_form($dt_create, ' месяц', ' месяца', ' месяцев') . ' назад';
    }
    return $result;
}

/**
 * Возвращает корректную форму множественного числа
 * Ограничения: только для целых чисел
 *
 * Пример использования:
 * $remaining_minutes = 5;
 * echo "Я поставил таймер на {$remaining_minutes} " .
 *     get_noun_plural_form(
 *         $remaining_minutes,
 *         'минута',
 *         'минуты',
 *         'минут'
 *     );
 * Результат: "Я поставил таймер на 5 минут"
 *
 * @param int $number Число, по которому вычисляем форму множественного числа
 * @param string $one Форма единственного числа: яблоко, час, минута
 * @param string $two Форма множественного числа для 2, 3, 4: яблока, часа, минуты
 * @param string $many Форма множественного числа для остальных чисел
 *
 * @return string Рассчитанная форма множественнго числа
 */
function get_noun_plural_form(int $number, string $one, string $two, string $many): string
{
    $number = (int)$number;
    $mod10 = $number % 10;
    $mod100 = $number % 100;

    switch (true) {
        case ($mod100 >= 11 && $mod100 <= 20):
            return $many;

        case ($mod10 > 5):
            return $many;

        case ($mod10 === 1):
            return $one;

        case ($mod10 >= 2 && $mod10 <= 4):
            return $two;

        default:
            return $many;
    }
}

/**
 * Генератор случайныъ чисел
 * @param int $index
 * @return string
 */
function generate_random_date(int $index): string
{
    $deltas = [['minutes' => 59], ['hours' => 23], ['days' => 6], ['weeks' => 4], ['months' => 11]];
    $dcnt = count($deltas);

    if ($index < 0) {
        $index = 0;
    }

    if ($index >= $dcnt) {
        $index = $dcnt - 1;
    }

    $delta = $deltas[$index];
    $timeval = rand(1, current($delta));
    $timename = key($delta);

    $ts = strtotime("$timeval $timename ago");
    $dt = date('Y-m-d H:i:s', $ts);

    return $dt;
}

/**
 * Возвращает дату в формате дд.мм.гггг чч:мм
 * @param string $time
 * @return string
 */
function date_for_title(string $time): string
{
    $timestamp = strtotime($time);
    $time = date('d.m.Y H:i', $timestamp);
    return $time;
}

/**
 * Возвращает дату в формате дд.мм.гггг чч:мм
 * @param string $time
 * @return string
 */
function date_for_user(string $time): string
{
    $timestamp = strtotime($time);
    $time = date('Y-m-d', $timestamp);
    return $time;
}

/**
 * Подключение шаблона по типу поста
 * @param string $type
 * @return string
 */
function template_by_type(string $type): string
{
    $result = '';
    switch ($type) {
        case 'post-quote':
            $result = 'block_quote.php';
            break;
        case 'post-text':
            $result = 'block_text.php';
            break;
        case 'post-link':
            $result = 'block_link.php';
            break;
        case 'post-video':
            $result = 'block_video.php';
            break;
        case 'post-photo':
            $result = 'block_photo.php';
            break;
    }
    return $result;
}

/**
 * Возвращает время в формате "Х лет на сайте"
 * @param string $time
 * @return string
 */
function user_date_registration(string $time): string
{
    $dt_pub = strtotime($time);
    $dt_now = time();
    $dt_diff = $dt_now - $dt_pub;
    $result = null;

    if ($dt_diff < HOUR) {
        $dt_create = floor($dt_diff / MINUTE);
        $result = $dt_create . get_noun_plural_form($dt_create, ' минута', ' минуты', ' минут') . ' на сайте';

    } elseif ($dt_diff >= HOUR and $dt_diff < DAY) {
        $dt_create = floor($dt_diff / HOUR);
        $result = $dt_create . get_noun_plural_form($dt_create, ' час', ' часа', ' часов') . ' на сайте';

    } elseif ($dt_diff >= DAY and $dt_diff < WEEK) {
        $dt_create = floor($dt_diff / DAY);
        $result = $dt_create . get_noun_plural_form($dt_create, ' день', ' дня', ' дней') . ' на сайте';

    } elseif ($dt_diff >= WEEK and $dt_diff < FIVE_WEEKS) {
        $dt_create = floor($dt_diff / WEEK);
        $result = $dt_create . get_noun_plural_form($dt_create, ' неделя', ' недели', ' недель') . ' на сайте';

    } elseif ($dt_diff >= FIVE_WEEKS and $dt_diff < YEARS) {
        $dt_create = floor($dt_diff / MONTH);
        $result = $dt_create . get_noun_plural_form($dt_create, ' месяц', ' месяца', ' месяцев') . ' на сайте';

    } elseif ($dt_diff >= YEARS) {
        $dt_create = floor($dt_diff / YEARS);
        $result = $dt_create . get_noun_plural_form($dt_create, ' год', ' года', ' лет') . ' на сайте';

    }
    return $result;
}

/**
 * Условие по сортировки
 * @return string
 */
function sort_field(): string
{
    $sort_field = 'view_count';
    if (isset($_GET['tab'])) {
        switch ($_GET['tab']) {
            case 'likes':
                $sort_field = 'like_post';
                break;
            case 'date':
                $sort_field = 'create_time';
                break;
        }
    }
    return $sort_field;
}

/**
 * Проверяет существование формы добавления поста
 * @param string $add_post
 * @return bool
 */
function get_tab(string $add_post): bool
{
    $result = false;
    if (!empty($add_post)) {
        switch ($add_post) {
            case 'photo':
                $result = true;
                break;
            case 'video':
                $result = true;
                break;
            case 'link':
                $result = true;
                break;
            case 'quote':
                $result = true;
                break;
            case 'text':
                $result = true;
                break;
        }
    }
    return $result;
}


/**
 * Извлекает из ссылки на youtube видео его уникальный ID
 * @param string $youtube_url Ссылка на youtube видео
 * @return bool
 */
function extract_youtube_id(string $youtube_url): bool
{
    $id = false;

    $parts = parse_url($youtube_url);

    if ($parts) {
        if ($parts['path'] == '/watch') {
            parse_str($parts['query'], $vars);
            $id = $vars['v'] ?? null;
        } else {
            if ($parts['host'] == 'youtu.be') {
                $id = substr($parts['path'], 1);
            }
        }
    }

    return $id;
}


/**
 * Проверяет, что переданная ссылка ведет на публично доступное видео с youtube
 * @param string $youtube_url Ссылка на youtube видео
 * @return bool
 */
function check_youtube_url(string $youtube_url): bool
{
    $res = false;
    $id = extract_youtube_id($youtube_url);

    if ($id) {
        $api_data = ['id' => $id, 'part' => 'id,status', 'key' => 'AIzaSyC-n4aQQk0mZrZNsfswKcaljExfM1UG57c'];
        $url = "https://www.googleapis.com/youtube/v3/videos?" . http_build_query($api_data);

        $resp = file_get_contents($url);

        if ($resp && $json = json_decode($resp, true)) {
            $res = $json['pageInfo']['totalResults'] > 0 && $json['items'][0]['status']['privacyStatus'] == 'public';
        }
    }

    return $res;
}

/**
 * Возвращает код iframe для вставки youtube видео на страницу
 * @param string $youtube_url Ссылка на youtube видео
 * @return string
 */
function embed_youtube_video($youtube_url)
{
    $res = "";
    $id = extract_youtube_id($youtube_url);

    if ($id) {
        $src = "https://www.youtube.com/embed/" . $id;
        $res = '<iframe width="760" height="400" src="' . $src . '" frameborder="0"></iframe>';
    }

    return $res;
}


/**
 * Возвращает путь на загруженный файл . Перемещает файл
 * @param $file_data
 * @return string
 */
function upload_img($file_data)
{
    $path = $file_data['name'];
    if (!$path) {
        return null;
    }
    $tmp_name = $file_data['tmp_name'];
    $result = 'uploads/' . $path;
    if (!move_uploaded_file($tmp_name, $result)) {
        die('Не найдена папка uploads или отсутствуют права на запись в неё');
    }
    return $result;
}

/**
 * Возвращает название типа поста по условию $_GET
 * @param string $add_post
 * @return string
 */
function get_name_type(string $add_post): string
{
    switch ($add_post) {
        case 'photo':
            return 'post-photo';
            break;
        case 'video':
            return 'post-video';
            break;
        case 'link':
            return 'post-link';
            break;
        case 'quote':
            return 'post-quote';
            break;
        case 'text':
            return 'post-text';
            break;
    }
    return $add_post;
}

/**
 * Возвращает id типа поста из данных метода $_GET
 * @param string $name_type
 * @param array $types
 * @return int
 */
function get_type_id(string $name_type, array $types): int
{
    foreach ($types as $type) {
        if ($name_type === $type['name']) {
            return $type['id'];
        }
    }
    return null;
}
