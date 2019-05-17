<?php
/**
 * Подключение к БД
 * @param array $config
 * @return mysqli
 */
function connectDb(array $config): mysqli
{
    $connection = mysqli_connect($config['host'], $config['user'], $config['password'], $config['database']);

    if ($connection === false) {
        die("Ошибка подключения: " . mysqli_connect_error()); // проверка на ошибку соединения
    }

    mysqli_set_charset($connection, "utf8");
    mysqli_options($connection, MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);

    return $connection;
}

