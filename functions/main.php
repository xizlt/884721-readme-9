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
function clips_text($text, $length = 300)
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
        return '<p>' . implode(' ', $result_words) . ' ...' . '</p>' . '<a class="post-text__more-link" href="#">Читать далее</a>';
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
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);

    return $value;
}

/**
 * возвращает время в формате "Х дней назад"
 * @param $time
 * @return string
 */
function publication_date(string $time): string
{
    $dt_pub = strtotime($time);
    $dt_now = time();
    $dt_diff = $dt_now - $dt_pub;

    if ($dt_diff < HOUR) {
        $dt_create = floor($dt_diff / MINUTE);
        $result = $dt_create . get_noun_plural_form($dt_create, ' минута', ' минуты', ' минут') . ' назад';
        return $result;

    } elseif ($dt_diff >= HOUR and $dt_diff < DAY) {
        $dt_create = floor($dt_diff / HOUR);
        $result = $dt_create . get_noun_plural_form($dt_create, ' час', ' часа', ' часов') . ' назад';
        return $result;

    } elseif ($dt_diff >= DAY and $dt_diff < WEEK) {
        $dt_create = floor($dt_diff / DAY);
        $result = $dt_create . get_noun_plural_form($dt_create, ' день', ' дня', ' дней') . ' назад';
        return $result;

    } elseif ($dt_diff >= WEEK and $dt_diff < FIVE_WEEKS) {
        $dt_create = floor($dt_diff / WEEK);
        $result = $dt_create . get_noun_plural_form($dt_create, ' неделя', ' недели', ' недель') . ' назад';
        return $result;

    } elseif ($dt_diff >= FIVE_WEEKS) {
        $dt_create = floor($dt_diff / MONTH);
        $result = $dt_create . get_noun_plural_form($dt_create, ' месяц', ' месяца', ' месяцев') . ' назад';
        return $result;
    }
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
function get_noun_plural_form (int $number, string $one, string $two, string $many): string
{
    $number = (int) $number;
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
 * @param $index
 * @return false|string
 */
function generate_random_date($index) {
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
 * @return false|string
 */
function date_for_title(string $time)
{
    $timestamp = strtotime($time);
    $time = date('d.m.Y H:i', $timestamp);
    return $time;
}

/**
 * Возвращает дату в формате дд.мм.гггг чч:мм
 * @param string $time
 * @return false|string
 */
function date_for_user(string $time)
{
    $timestamp = strtotime($time);
    $time = date('Y-m-d', $timestamp);
    return $time;
}

/**
 * Подключение шаблона по типу поста
 * @param $post
 * @return string|null
 */
function template_by_type($post)
{
    $result = null;
    if ($post === 'post-quote') {
        $result = 'block_quote.php';
    } elseif ($post === 'post-text') {
        $result = 'block_text.php';
    }elseif ($post === 'post-link') {
        $result = 'block_link.php';
    }elseif ($post === 'post-video') {
        $result = 'block_video.php';
    }elseif ($post === 'post-photo') {
        $result = 'block_photo.php';
    }
    return $result;
}

/**
 * возвращает время в формате "Х лет на сайте"
 * @param $time
 * @return string
 */
function user_date_registration(string $time): string
{
    $dt_pub = strtotime($time);
    $dt_now = time();
    $dt_diff = $dt_now - $dt_pub;

    if ($dt_diff < HOUR) {
        $dt_create = floor($dt_diff / MINUTE);
        $result = $dt_create . get_noun_plural_form($dt_create, ' минута', ' минуты', ' минут') . ' на сайте';
        return $result;

    } elseif ($dt_diff >= HOUR and $dt_diff < DAY) {
        $dt_create = floor($dt_diff / HOUR);
        $result = $dt_create . get_noun_plural_form($dt_create, ' час', ' часа', ' часов') . ' на сайте';
        return $result;

    } elseif ($dt_diff >= DAY and $dt_diff < WEEK) {
        $dt_create = floor($dt_diff / DAY);
        $result = $dt_create . get_noun_plural_form($dt_create, ' день', ' дня', ' дней') . ' на сайте';
        return $result;

    } elseif ($dt_diff >= WEEK and $dt_diff < FIVE_WEEKS) {
        $dt_create = floor($dt_diff / WEEK);
        $result = $dt_create . get_noun_plural_form($dt_create, ' неделя', ' недели', ' недель') . ' на сайте';
        return $result;

    } elseif ($dt_diff >= FIVE_WEEKS and $dt_diff < YEARS) {
        $dt_create = floor($dt_diff / MONTH);
        $result = $dt_create . get_noun_plural_form($dt_create, ' месяц', ' месяца', ' месяцев') . ' на сайте';
        return $result;
    } elseif ($dt_diff >= YEARS) {
        $dt_create = floor($dt_diff / YEARS);
        $result = $dt_create . get_noun_plural_form($dt_create, ' год', ' года', ' лет') . ' на сайте';
        return $result;
    }
}

/**
 * Условие по сортировки
 * @return string
 */
function sort_field()
{
    $sort_field = 'view_count';
    if (isset($_GET['tab']) && $_GET['tab'] === 'likes') {
        $sort_field = 'like_post';
    } elseif (isset($_GET['tab']) && $_GET['tab'] === 'date') {
        $sort_field = 'create_time';
    }
    return $sort_field;
}

/**
 * Возвращает данные поста в зависемости от фильтров
 * @param $connection
 * @param $type_block
 * @param $types_correct
 * @param $sort_field
 * @return array|null
 */
function get_posts_by_filter($connection, $type_block, $types_correct)
{
    $sort_field = sort_field();
    if ($type_block) {
        $posts = get_posts_type($connection, $type_block, $sort_field);
        if (!$types_correct) {
            header("HTTP/1.0 404 Not Found");
            exit();
        }
    } else {
        $posts = get_posts($connection, $sort_field);
    }
    return $posts;
}