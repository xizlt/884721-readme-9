<?php

require_once 'bootstrap.php';

$posts = [];
$search = isset($_GET['search']) ? trim(preg_replace("/[^а-яёa-z,#,0-9]/iu", ' ', $_GET['search'])) : null;
$url = $_SERVER['HTTP_REFERER'] ?? null;


if (empty($search)) {
    header("Location: $url");
    exit();
}

$search = urldecode($search);
$post_id = null;

if (substr($search, 0, 1) === '#') {
    $search = substr($search, 1);
    $order_by = 'create_time';
    $name_tags = get_tag_by_name($connection, $search);
    $posts = get_posts($connection, null, $order_by, null, null, null, null, $name_tags['id']);
} else {
    $posts = get_posts($connection, null, null, null, null, null, $search);
}


if (!$posts) {
    $page_content = include_template('search_no_results.php', [
        'search' => $search,
        'url' => $url
    ]);
} else {
    $page_content = include_template('search.php', [
        'posts' => $posts,
        'search' => $search,
        'connection' => $connection,
        'user' => $user
    ]);
}

$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'title' => 'Страница поиска',
    'search' => $search,
    'user' => $user
]);
print ($layout_content);
