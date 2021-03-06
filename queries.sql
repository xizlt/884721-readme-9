-- внес типы постов
INSERT INTO content_type (name)
    VALUE ('post-quote'),
    ('post-text'),
    ('post-photo'),
    ('post-video'),
    ('post-link');


-- Внес пользователей
INSERT INTO users (email, name, password, avatar, about)
      VALUE ('qwe@qwe.ru', 'Эльвира', '123456', 'img/userpic-elvira.jpg', 'У разностороннего множество увлечений, ни одно из которых не относится к работе. Он занимается йогой, конным спортом, играет на фортепиано и тромбоне, любит сериал «Игра престолов» и переводит книги с иврита. Я не против разностороннего, если помимо его интересов в письме что-то по делу: чем он будет полезен и почему он справится с задачей. К сожалению, пока таких не было.'),
      ('asd@qwe.ru', 'Лариса', '789456', 'img/userpic-larisa.jpg', 'У разностороннего множество увлечений, ни одно из которых не относится к работе. Он занимается йогой, конным спортом, играет на фортепиано и тромбоне, любит сериал «Игра престолов» и переводит книги с иврита. Я не против разностороннего, если помимо его интересов в письме что-то по делу: чем он будет полезен и почему он справится с задачей. К сожалению, пока таких не было.'),
      ('zxc@qwe.ru', 'Марк', '147258', 'img/userpic-mark.jpg', 'У разностороннего множество увлечений, ни одно из которых не относится к работе. Он занимается йогой, конным спортом, играет на фортепиано и тромбоне, любит сериал «Игра престолов» и переводит книги с иврита. Я не против разностороннего, если помимо его интересов в письме что-то по делу: чем он будет полезен и почему он справится с задачей. К сожалению, пока таких не было.'),
      ('tyu@qwe.ru', 'Петя', '963258', 'img/userpic-petro.jpg', 'У разностороннего множество увлечений, ни одно из которых не относится к работе. Он занимается йогой, конным спортом, играет на фортепиано и тромбоне, любит сериал «Игра престолов» и переводит книги с иврита. Я не против разностороннего, если помимо его интересов в письме что-то по делу: чем он будет полезен и почему он справится с задачей. К сожалению, пока таких не было.');


-- Внес посты
INSERT INTO posts (title, message, user_id, content_type_id, image, link)
    VALUE ('Цитата', 'Мы в жизни любим только раз, а после ищем лишь похожих', 1, 1, NULL, NULL),
    ('Игра престолов', 'Не могу дождаться начала финального сезона своего любимого сериала!', 2, 2, NULL, NULL),
    ('Наконец, обработал фотки!', NULL, 3, 3, 'img/rock-medium.jpg', NULL),
    ('Моя мечта', NULL, 4, 3, 'img/coast-medium.jpg', NULL),
    ('Лучшие курсы', NULL, 2, 5, NULL, 'www.htmlacademy.ru');


-- Внес комментарии
INSERT INTO comments (user_id, post_id, message)
      VALUE (1, 3, 'Однако, уважаемый Максим Ильяхов, снимаю шляпу. Читать эти письма, не допуская внутреннего кипения (я гуманист, но увы, вышел из себя'),
      (1, 4, 'Можно немало посмеяться над приведенными образцами.Но вспоминается советское время,когда классу задавали сочинение на тему:«Как хорошо жить в советской стране!»'),
      (2, 3, 'Алекс, к сожалению, большинство кандидатов не смогли даже списать письмо с образца по ссылке.'),
      (3, 2, 'Для чайника по СУБД как я, отличный урок﻿'),
      (4, 1, 'Всё понятно и без воды, мне понравилось, хороший видосик﻿'),
      (3, 1, 'очень вовремя, у меня как раз курсовой по БД, думаю SQL и выберу для создания проекта');


-- Заполнил таблицу likes
INSERT INTO likes (user_id, post_id)
      VALUE (1, 5),
      (2, 4),
      (3, 3),
      (4, 2),
      (2, 5);


-- добавил лайк к посту;
INSERT INTO likes
SET post_id = 3, user_id = 2;


-- подписался на пользователя.
INSERT INTO subscriptions
SET subscriber_id = 3, user_id = 4;

-- получил список постов с сортировкой по популярности и вместе с именами авторов и типом контента;
SELECT p.id,
       p.create_time,
       p.title,
       p.message,
       p.quote_writer,
       p.image,
       p.video,
       p.link,
       u.name,
       c.name AS type,
       COUNT(l.user_id) AS like_post
FROM posts p
         JOIN likes l ON p.id = l.post_id
         JOIN users u ON u.id = p.user_id
         JOIN content_type c ON c.id = p.content_type_id
WHERE l.post_id = p.id
GROUP BY p.id
ORDER BY like_post DESC;


-- получил список постов для конкретного пользователя;
SELECT p.id,
       p.create_time,
       p.title,
       p.message,
       p.quote_writer,
       p.image,
       p.video,
       p.link,
       u.name,
       u.email
FROM posts p
         JOIN users u
              ON p.user_id = u.id
WHERE u.id = 4;


-- получил список комментариев для одного поста, в комментариях должен быть логин пользователя;
SELECT p.id,
       p.create_time,
       p.title,
       p.message,
       p.quote_writer,
       p.image,
       p.video,
       p.link,
       cm.message,
       u.email,
       u.name
FROM comments cm
         JOIN posts p
              ON cm.post_id = p.id
         JOIN users u
              ON u.id = cm.user_id
WHERE p.id = 2;



