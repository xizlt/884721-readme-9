CREATE DATABASE readme
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE readme;

CREATE TABLE users
(
    id          INT AUTO_INCREMENT PRIMARY KEY,
    create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    email       VARCHAR(250) UNIQUE NOT NULL,
    name        VARCHAR(250)        NOT NULL,
    password    VARCHAR(250)        NOT NULL,
    avatar      VARCHAR(1000)        NULL,
    about       VARCHAR(1000)        NULL
);


CREATE TABLE content_type
(
    id   INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) UNIQUE NOT NULL
);


CREATE TABLE posts
(
    id              INT AUTO_INCREMENT PRIMARY KEY,
    create_time     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    title           VARCHAR(250)  NOT NULL,
    message         TEXT NULL,
    quote_writer    VARCHAR(250)  NULL,
    image           VARCHAR(1000) NULL,
    video           VARCHAR(1000) NULL,
    link            VARCHAR(1000) NULL,
    view_count      INT       DEFAULT 0,
    user_id         INT           NOT NULL,
    content_type_id INT           NOT NULL,
    is_repost       TINYINT   DEFAULT 0,
    repost_doner_id INT           NULL
);

CREATE INDEX title_idx ON posts (title);


ALTER TABLE posts
    ADD FOREIGN KEY (user_id)
        REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE posts
    ADD FOREIGN KEY (content_type_id)
        REFERENCES content_type (id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE posts
    ADD FOREIGN KEY (repost_doner_id)
        REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE FULLTEXT INDEX posts_search ON posts(title, message);


CREATE TABLE comments
(
    id          INT AUTO_INCREMENT PRIMARY KEY,
    create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    message     VARCHAR(1000) NOT NULL,
    user_id     INT           NOT NULL,
    post_id     INT           NOT NULL
);

CREATE INDEX message_comment_idx ON comments (message);

ALTER TABLE comments
    ADD FOREIGN KEY (user_id)
        REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE comments
    ADD FOREIGN KEY (post_id)
        REFERENCES posts (id) ON DELETE CASCADE ON UPDATE CASCADE;


CREATE TABLE likes
(
    id      INT AUTO_INCREMENT PRIMARY KEY,
    create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_id INT NULL,
    post_id INT NULL
);

ALTER TABLE likes
    ADD FOREIGN KEY (user_id)
        REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE likes
    ADD FOREIGN KEY (post_id)
        REFERENCES posts (id) ON DELETE CASCADE ON UPDATE CASCADE;


CREATE TABLE subscriptions
(
    id            INT AUTO_INCREMENT PRIMARY KEY,
    subscriber_id INT NOT NULL,
    user_id       INT NOT NULL
);

CREATE UNIQUE INDEX subscriptions_subscriber_user_udx ON subscriptions (subscriber_id, user_id);

ALTER TABLE subscriptions
    ADD FOREIGN KEY (user_id)
        REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE subscriptions
    ADD FOREIGN KEY (subscriber_id)
        REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE;


CREATE TABLE messages
(
    id           INT AUTO_INCREMENT PRIMARY KEY,
    message      VARCHAR(1000) NOT NULL,
    create_date  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    sender_id    INT           NOT NULL,
    recipient_id INT           NOT NULL
);

ALTER TABLE messages
    ADD FOREIGN KEY (sender_id)
        REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE messages
    ADD FOREIGN KEY (recipient_id)
        REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE;


CREATE TABLE tags
(
    id   INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NULL UNIQUE
);


CREATE TABLE posts_tags
(
    post_id INT NULL,
    tag_id INT NULL
);

ALTER TABLE posts_tags
    ADD FOREIGN KEY (post_id)
        REFERENCES posts (id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE posts_tags
    ADD FOREIGN KEY (tag_id)
        REFERENCES tags (id) ON DELETE CASCADE ON UPDATE CASCADE;
