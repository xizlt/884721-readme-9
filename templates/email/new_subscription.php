<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
<h1>У вас новый подписчик</h1>

<p>Здравствуйте, <?= $user_for_email['name'];?>. На вас подписался новый пользователь <?= $user['name'];?>. Вот ссылка на его профиль: http://884721-readme-9/profile.php?id=<?= $user['id'];?>

</p>


</body>
</html>

