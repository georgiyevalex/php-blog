/*0. Create dbConnect.php file
    'dsn' => 'mysql:host=127.0.0.1;dbname=db_name',
    'username' => 'userName',
    'password'=> 'userPassword'
 */

/*1. Create database
CREATE DATABASE php_blog; */

USE php_blog;

/*2. Create posts table*/

CREATE TABLE `post` (
                        `post_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                        `title` varchar(255) NOT NULL,
                        `url_key` varchar(255) NOT NULL,
                        `image_path` varchar(255) DEFAULT NULL,
                        `content` text,
                        `description` varchar(255) DEFAULT NULL,
                        `published_date` datetime NOT NULL,
                        PRIMARY KEY (`post_id`),
                        UNIQUE KEY `url_key` (`url_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* Add Posts*/

INSERT INTO post (title, url_key, content, description, published_date) VALUES ('Hello World', 'hello-world', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.', 'My first blog post', '2020-12-05 12:00:00');
INSERT INTO post (title, url_key, content, description, published_date) VALUES ('Fact that a reader', 'fact-that-a-reader', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using Content here, content here, making it look like readable English.', 'It is a long established fact that a reader .','2020-12-09 12:00:00');
INSERT INTO post (title, url_key, content, description, published_date) VALUES ('Many variations of passages', 'many-variations-of-passages', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don''t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn''t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', 'There are many variations of passages of Lorem Ipsum available', '2020-12-10 12:00:00');
INSERT INTO post (title, url_key, content, description, published_date) VALUES ('Test post', 'new-post', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don''t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn''t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', 'There are many variations of passages of Lorem Ipsum available', '2020-12-10 13:00:00');
INSERT INTO post (title, url_key, content, description, published_date) VALUES ('Test post 2', 'l2-post', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don''t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn''t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', 'There are many variations of passages of Lorem Ipsum available', '2020-12-10 15:00:00');
INSERT INTO post (title, url_key, content, description, published_date, image_path) VALUES ('Test post 3', 'another-post', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don''t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn''t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', 'There are many variations of passages of Lorem Ipsum available', '2020-12-10 18:00:00', '/static/images/post_images/blog-1.jpg');

/* Create users base */
create table users (
                       user_id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                       first_name varchar(255) NOT NULL,
                       last_name varchar(255) NOT NULL,
                       email varchar(255) NOT NULL UNIQUE,
                       password varchar(255) NOT NULL,
                       role varchar(50) NOT NULL DEFAULT 'user',
                       PRIMARY KEY (user_id)
) ENGINE  = InnoDB;

/*Add Admin user*/
INSERT INTO users (user_id, first_name, last_name, email, password, role) VALUES ('1', 'Admin', 'Admin', 'admin@mail.ru', '$2y$10$OmZpp6uNq49fZrexGUTxVeiSZHWCXgK2c4QFcsphryR3lDRlljOGW', 'admin'); /*password = 123456*/
INSERT INTO users (user_id, first_name, last_name, email, password, role) VALUES ('2', 'User', 'User', 'user@mail.ru', '$2y$10$OmZpp6uNq49fZrexGUTxVeiSZHWCXgK2c4QFcsphryR3lDRlljOGW', 'user'); /*password = 123456*/
INSERT INTO users (user_id, first_name, last_name, email, password, role) VALUES ('3', 'Reviewer', 'Reviewer', 'reviewer@mail.ru', '$2y$10$OmZpp6uNq49fZrexGUTxVeiSZHWCXgK2c4QFcsphryR3lDRlljOGW', 'reviewer'); /*password = 123456*/