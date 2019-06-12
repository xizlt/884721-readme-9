<?php

/**
 * @param mysqli $connection
 * @param string $string_tags
 * @param int $post_id
 */
function add_tags(mysqli $connection, string $string_tags, int $post_id)
{
    // разбить строку tags на отдельные слова
    // пройти массив по словам
    // проверить существование каждого тега в базе
    // если tag существует получить его id
    // если не сущ то добавить и получить id
    // записать в таблицу связи tag_id и post_id в таблицу
    $words = split_tags_string($string_tags);
    foreach ($words as $word) {
        $tag = get_tag_by_name($connection, $word);
        if ($tag) {
            $tag_id = $tag['id'];
        } else {
            $tag_id = add_tag($connection, $word);
        }
        add_posts_tags($connection, $tag_id, $post_id);
    }
}

/**
 * Возвращает массив разбитый по отдельным словам
 * @param string $string_tags
 * @return array
 */
function split_tags_string(string $string_tags): array
{
    if ($string_tags) {
        $result = explode(" ", $string_tags);
        return $result;
    }
    return null;
}