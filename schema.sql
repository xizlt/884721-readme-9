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
    about VARCHAR(900) NULL,
    post_id INT NULL,
    messages_id INT NULL
);

CREATE INDEX post_id_index ON users(post_id);
CREATE INDEX messages_id ON users(messages_id);


CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    title VARCHAR(250) NOT NULL,
    message VARCHAR(1000) NOT NULL,
    quote_writer VARCHAR(250) NOT NULL,
    image VARCHAR(1000) NOT NULL,
    video VARCHAR(1000) NOT NULL,
    link VARCHAR(1000) NOT NULL,
    view INT NULL,
    user_id INT NOT NULL,
    type_content INT NOT NULL,
    hash_tag_id INT NULL
);

CREATE INDEX user_id_index ON posts(user_id);
CREATE INDEX type_content_index ON posts(type_content);
CREATE INDEX hash_tags_index ON posts(hash_tag_id);
CREATE INDEX title_index ON posts(title);
CREATE INDEX messages_index ON posts(message);


CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    create_date TIMESTAMP DEFAULT CURRENT_TIME,
    message VARCHAR(1000) NOT NULL,
    user_id INT NOT NULL,
    message_id INT NOT NULL
);

CREATE INDEX user_id_index ON comments(user_id);
CREATE INDEX messages_id_index ON comments(message_id);


CREATE TABLE likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    message_id INT NULL
);

CREATE INDEX user_id_index ON likes(user_id);
CREATE INDEX messages_id_index ON likes(message_id);


CREATE TABLE subscription (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id_on INT NOT NULL,
    user_id_who INT NOT NULL
);


CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    create_date TIMESTAMP DEFAULT CURRENT_TIME,
    sender INT NOT NULL,
    recipient INT NOT NULL
);

CREATE INDEX sender_index ON messages(sender);
CREATE INDEX recipient_index ON messages(recipient);


CREATE TABLE hash_tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name_tag VARCHAR(1000) UNIQUE NOT NULL
);

CREATE INDEX name_tag_index ON hash_tags(name_tag);


CREATE TABLE content (
    id int auto_increment primary key,
    type varchar(255) unique not null
);

CREATE INDEX type_index ON content(type);