<?php

require 'bootstrap.php';

$user_id_ind = $_GET['id'] ?? null;
$user_id_ind = (int)clean($user_id_ind);

$subscription = $_GET['subscription'] ?? null;
$subscription = clean($subscription);


if ($subscription === 'true') {
    $res = add_subscription($connection, $user['id'], $user_id_ind);

    if ($res) {

        $transport = new Swift_SmtpTransport($email ['host'], $email ['port'], 'ssl');
        $transport->setUsername($email ['user']);
        $transport->setPassword($email ['password']);

        $mailer = new Swift_Mailer($transport);

        $logger = new Swift_Plugins_Loggers_ArrayLogger();
        $mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));

        $user_for_email = user_subscriptions($connection, $user_id_ind);

        $message = new Swift_Message();
        $message->setSubject("Новый подписчик");
        $message->setFrom(["$email ['user']" => 'README']);

        $recipients[$user_for_email['email']] = $user_for_email['name'];

        $message->setBcc($recipients);

        $msg_content = include_template('email/new_subscription.php',
            ['user_for_email' => $user_for_email, 'user' => $user]);
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