<?php
date_default_timezone_set("Europe/Moscow");

$is_auth = rand(0, 1);

$user_name = 'Иван'; // укажите здесь ваше имя

require_once "functions.php";
require_once "data.php";

$time = '17.04.2019 21:10:20';
$ter = publication_date($time);
var_dump($ter);

$page_content = include_template('index.php', ['card_posts' => $card_posts]);
$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'title' => 'Популярное',
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);
print ($layout_content);