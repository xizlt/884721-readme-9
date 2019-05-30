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
 * @param integer $type_id
 * @return array|null
 */
function get_type_by_id(mysqli $connection, int $type_id): ?array
{
    $sql = "SELECT * FROM content_type
WHERE id = ?
";

    $result = null;
    mysqli_prepare($connection, $sql);
    $stmt = db_get_prepare_stmt($connection, $sql, [$type_id]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($res) {
        $result = mysqli_fetch_array($res, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($connection);
        die('Ошибка MySQL ' . $error);
    }
    return $result;

}