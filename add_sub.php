<?php

require_once 'bootstrap.php';

$user_id_ind = $_GET['id'] ?? null;
$user_id_ind = (int)clean($user_id_ind);

$subscription = $_GET['subscription'] ?? null;
$subscription = clean($subscription);

if ($subscription === 'true') {
    add_subscription($connection, $user['id'], $user_id_ind);

} elseif ($subscription === 'false') {
    dell_subscription($connection, $user['id'], $user_id_ind);
}
header("Location: $_SERVER[HTTP_REFERER]");
exit();