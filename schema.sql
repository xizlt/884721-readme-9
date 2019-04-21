CREATE DATABASE readme
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;

USE readme;

CREATE TABLE users(
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_registration TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    email VARCHAR(250)UNIQUE NOT NULL,
    name VARCHAR(250) NOT NULL,
    password VARCHAR(250) NOT NULL,
    avatar VARCHAR(900),
    about VARCHAR(900) NULL
);


CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    title VARCHAR(250) NOT NULL,
    message VARCHAR(1000) NOT NULL,
    quote_writer VARCHAR(250) NULL,
    image VARCHAR(1000) NULL,
    video VARCHAR(1000) NULL,
    link VARCHAR(1000) NULL,
    view INT NULL,
    user_id INT NOT NULL,
    type_content INT NOT NULL,
    hash_tag INT NULL
);

CREATE INDEX user_id_index ON posts(user_id);
CREATE INDEX type_content_index ON posts(type_content);
CREATE INDEX hash_tag_index ON posts(hash_tag);
CREATE INDEX title_index ON posts(title);
CREATE INDEX messages_index ON posts(message);


CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    create_date TIMESTAMP DEFAULT CURRENT_TIME,
    message VARCHAR(1000) NOT NULL,
    user_id INT NOT NULL,
    post_id INT NOT NULL
);

CREATE INDEX message_comment_index ON comments(message);
CREATE INDEX user_id_index ON comments(user_id);
CREATE INDEX post_id_index ON comments(post_id);


CREATE TABLE likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    post_id INT NULL
);


CREATE TABLE subscription (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id_on INT NOT NULL,
    user_id_who INT NOT NULL
);


CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message VARCHAR(1000) NOT NULL,
    create_date TIMESTAMP DEFAULT CURRENT_TIME,
    sender INT NOT NULL,
    recipient INT NOT NULL
);

CREATE INDEX sender_index ON messages(sender);
CREATE INDEX recipient_index ON messages(recipient);


CREATE TABLE hash_tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hash_tag_id INT NULL
);


CREATE TABLE content (
    id int auto_increment primary key,
    type varchar(255) unique not null
);

CREATE INDEX type_index ON content(type);