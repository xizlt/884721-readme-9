<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
<h1>Новая публикация от пользователя <?= $user['name'];?></h1>

<p>Здравствуйте, <?= $users_sub['name'];?>. Пользователь <?= $user['name'];?> только что опубликовал новую запись «<?= $post['title'];?>». Посмотрите её на странице пользователя: http://884721-readme-9/post.php?id=<?= $post['id'];?></p>


</body>
</html>


