<?php

require_once 'bootstrap.php';

$user_id_ind = $_GET['id'] ?? null;
$user_id_ind = (int)clean($user_id_ind);

$subscription = $_GET['subscription'] ?? null;
$subscription = clean($subscription);

if ($subscription === 'true') {
    $res = add_subscription($connection, $user['id'], $user_id_ind);
    if ($res) {
        $user_for_email = user_subscriptions($connection, $user_id_ind);

        $message = new Swift_Message();
        $message->setSubject("Новый подписчик");
        $message->setFrom(['keks@phpdemo.ru' => 'README']);

        $recipients[$user_for_email['email']] = $user_for_email['name'];

        $message->setBcc($recipients);

        $msg_content = include_template('email/new_subscription.php', ['user_for_email' => $user_for_email, 'user' => $user]);
        $message->setBody($msg_content, 'text/html');

        $result = $mailer->send($message);

        if (!$result) {
            print("Не удалось отправить рассылку: " . $logger->dump());
        }
    }

} elseif ($subscription === 'false') {
    dell_subscription($connection, $user['id'], $user_id_ind);
}
header("Location: $_SERVER[HTTP_REFERER]");
exit();