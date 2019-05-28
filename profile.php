<?php

require 'bootstrap.php';

if (!$user) {
    header('Location: /');
    exit();
}

///////////
/**
 * Возвращает имя пользователя с переносом имени
 * @param string $name
 * @return string
 */
function name_profile(string $name): string
{
    $words = explode(" ", $name);
    if ($words < 1) {
        return $name;
    }
    $result = null;
    foreach ($words as $word) {
        $result .= $word . '<br>';
    }
return $result;
}

/**
 * Возвращает кол-во поблукаций для данного юзера
 * @param mysqli $connection
 * @param int $user_id
 * @return int
 */
function get_count_public(mysqli $connection, int $user_id): int
{
    $sql = "SELECT
        id
FROM posts
WHERE user_id = ?
";
    mysqli_prepare($connection, $sql);
    $stmt = db_get_prepare_stmt($connection, $sql, [$user_id]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($res) {
        $result = mysqli_num_rows($res);
    } else {
        $error = mysqli_error($connection);
        die('Ошибка MySQL ' . $error);
    }
    return $result;
}

function add_subscription($connection, $user, $subscriber){
    $sql = "INSERT INTO subscriptions (subscriber_id, user_id) 
            VALUES (?, ?)";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'ii', $user, $subscriber);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    if (!$result) {
        die('Ошибка при сохранении лота');
    }
    $id = mysqli_insert_id($connection);
    return $id;
}

function get_tag_by_id(mysqli $connection, string $id): ?array
{
    $result = null;
    $sql = "SELECT * FROM posts_tags
                WHERE post_id = ?";

    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($res) {
        $result = mysqli_fetch_all($res, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($connection);
        die('Ошибка MySQL ' . $error);
    }
    return $result;
}

function get_tags($connection, $tag)
{
    $result = null;
    $sql = "SELECT * FROM tags
                WHERE id = ?";

    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $tag);
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

function add_comment($connection, $user_id, $post_id, $comment)
{
    $sql = 'INSERT INTO comments (user_id, post_id, message) VALUE (? ,? ,?)';
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'iis', $user_id, $post_id, $comment
    );
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $result;
}


//////


$user_id_ind = $_GET['id'] ?? null;
$user_id_ind = clean($user_id_ind);

$profile_block = $_GET['tab'] ?? null;
$profile_block = clean($profile_block);

$show_comments_block = $_GET['show'] ?? null;
$show_comments_block = clean($show_comments_block);


$posts = get_posts($connection, null, null, $user_id_ind);
$user_profile = get_user_by_id($connection, $user_id_ind);

$post_id = $_GET['post-id'] ?? null;;
$post_id = clean($post_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = $_POST['comment'];

    if (add_comment($connection, $user['id'], $post_id, $comment)) {
        header("Location: profile.php?id=$user_id_ind&post-id=$post_id&show=true");
        exit();
    }

        add_subscription($connection, $user['id'], $user_id_ind);



}


$page_content = include_template('profile.php', [
    'posts' => $posts,
    'connection' => $connection,
    'user_profile' => $user_profile,
    'show_comments_block' => $show_comments_block,
    'user' => $user
]);
$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'title' => 'Популярное',
    'is_auth' => $is_auth,
    'user' => $user
]);
print ($layout_content);