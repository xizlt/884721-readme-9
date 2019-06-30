<?php
const TAB_TEXT = 'text';
const TAB_LINK = 'link';
const TAB_VIDEO = 'video';
const TAB_QUOTE = 'quote';
const TAB_PHOTO = 'photo';

require_once 'bootstrap.php';

if (!$user) {
    header('Location: /');
    exit();
}

require_once 'functions/validators/post/common.php';
require_once 'functions/validators/post/text.php';
require_once 'functions/validators/post/video.php';
require_once 'functions/validators/post/photo.php';
require_once 'functions/validators/post/link.php';
require_once 'functions/validators/post/quote.php';
require_once 'functions/tags.php';
require_once 'functions/photo.php';

$types = get_types($connection);
$tab = $_GET['tab'] ?? null;

if (empty($tab)) {
    header("Location: add.php?tab=text");
    exit();
}

if (!get_tab($tab)) {
    header("HTTP/1.0 404 Not Found");
    exit();
}

$file_data = [];
$post_data = [];
$errors = [];
$block_errors = null;

$name_type = get_name_type($tab);
$type_id = get_type_id($name_type, $types);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $post_data = $_POST;
    $post_data = clean($post_data);
    $file_data = $_FILES;

    switch ($tab) {
        case TAB_TEXT:
            $errors = validate_post_text($post_data);
            break;
        case TAB_LINK:
            $errors = validate_post_link($post_data);
            break;
        case TAB_VIDEO:
            $errors = validate_post_video($post_data);
            break;
        case TAB_QUOTE:
            $errors = validate_post_quote($post_data);
            break;
        case TAB_PHOTO:
            $errors = validate_post_photo($post_data, $file_data);
            break;
    }

    if (!$errors) {

        if ($tab === TAB_PHOTO) {
            $post_data['img'] = upload_img($file_data['img']) ?? upload_img_by_url($post_data['link']);
        }
        if ($tab === TAB_VIDEO) {
            $post_data['video'] = $post_data['link'];
            $post_data['link'] = null;
        }

        $post_id = add_post($connection, $post_data, $type_id, $user['id']);

        $string_tags = $post_data['tags'];
        if ($string_tags) {
            add_tags($connection, $string_tags, $post_id);
        }

        $users_subs = get_subscriptions($connection, $user['id']);

        if ($users_subs) {

            $post = get_post_info($connection, $post_id);

            $transport = new Swift_SmtpTransport($email ['host'], $email ['port']);
            $transport->setUsername($email ['user']);
            $transport->setPassword($email ['password']);

            $mailer = new Swift_Mailer($transport);

            $logger = new Swift_Plugins_Loggers_ArrayLogger();
            $mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));

            $message = new Swift_Message();
            $message->setSubject("Опубликован новый пост");
            $message->setFrom(['keks@phpdemo.ru' => 'README']);
            $recipients = [];

            foreach ($users_subs as $users_sub) {
                $recipients[$users_sub['email']] = $users_sub['name'];

                $msg_content = include_template('email/new_post.php',
                        ['user' => $user,
                        'users_sub' => $users_sub,
                        'post' => $post]);
                $message->setBody($msg_content, 'text/html');
            }

            $message->setBcc($recipients);
            $result = $mailer->send($message);

            if (!$result) {
                print("Не удалось отправить рассылку: " . $logger->dump());
            }
        }

        header("Location: post.php?id=" . $post_id);
        exit();

    }

    $block_errors = include_template('add_post_errors.php', ['errors' => $errors]);

}


$title_post = include_template('add_post_title.php', ['errors' => $errors, 'post_data' => $post_data]);
$tags_post = include_template('add_post_tag.php', ['errors' => $errors, 'post_data' => $post_data]);
$send_form = include_template('add_post_footer.php');
$page_content = include_template('add.php', [
    'tab' => $tab,
    'types' => $types,
    'no_result' => $block_errors,
    'send_form' => $send_form,
    'title_post' => $title_post,
    'tags_post' => $tags_post,
    'errors' => $errors,
    'file_data' => $file_data,
    'post_data' => $post_data
]);
$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'title' => 'Популярное',
    'search' => $search,
    'user' => $user
]);
print ($layout_content);