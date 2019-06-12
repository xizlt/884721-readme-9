<?php

$transport = new Swift_SmtpTransport("phpdemo.ru", 25);
$transport->setUsername("keks@phpdemo.ru");
$transport->setPassword("htmlacademy");

$mailer = new Swift_Mailer($transport);

$logger = new Swift_Plugins_Loggers_ArrayLogger();
$mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));
$user_for_email = [];
$message = new Swift_Message();
$message->setSubject("У вас новый подписчик");
$message->setFrom(['keks@phpdemo.ru' => 'README']);
$message->setBcc($user_for_email);

$msg_content = include_template('email/new_subscription.php', ['user_for_email' => $user_for_email]);
$message->setBody($msg_content, 'text/html');

$result = $mailer->send($message);

if (!$result) {
    print("Не удалось отправить рассылку: " . $logger->dump());
}