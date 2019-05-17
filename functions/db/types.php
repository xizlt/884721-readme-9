<?php

/**
 * Возвращает типы контента
 * @param mysqli $connection
 * @return array
 */
function get_types(mysqli $connection): array
{
    $sql = 'SELECT * FROM content_type';
    if ($query = mysqli_query($connection, $sql)) {
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($connection);
        die('Ошибка MySQL ' . $error);
    }
    return $result;
}

/**
 * Проверяет существования такой категории
 * @param mysqli $connection
 * @param string $type_id
 * @return array|null
 */
function get_type_by_id(mysqli $connection, string $type_id)
{
    $sql = "SELECT * FROM content_type
WHERE id = '$type_id'
";
    if ($query = mysqli_query($connection, $sql)) {
        $result = mysqli_fetch_array($query, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($connection);
        die('Ошибка MySQL ' . $error);
    }
    return $result;
}