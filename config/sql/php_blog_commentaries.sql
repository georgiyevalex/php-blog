create table commentaries
(
    comment_id     int auto_increment
        primary key,
    user_id        int      not null,
    post_id        int      not null,
    published_date datetime not null,
    comment        text     not null
);

INSERT INTO php_blog.commentaries (comment_id, user_id, post_id, published_date, comment) VALUES (1, 1, 1, '2021-12-03 14:39:04', 'There are many variations of passages of Lorem Ipsum available');
INSERT INTO php_blog.commentaries (comment_id, user_id, post_id, published_date, comment) VALUES (2, 3, 1, '2021-12-04 13:41:24', 'food post with category content');
INSERT INTO php_blog.commentaries (comment_id, user_id, post_id, published_date, comment) VALUES (3, 1, 21, '2022-03-23 08:57:29', 'comment
');
INSERT INTO php_blog.commentaries (comment_id, user_id, post_id, published_date, comment) VALUES (4, 1, 27, '2022-06-10 12:03:35', 'Danis kakawka');
INSERT INTO php_blog.commentaries (comment_id, user_id, post_id, published_date, comment) VALUES (5, 4, 27, '2022-06-10 12:06:04', 'tochno, kakawka ');
INSERT INTO php_blog.commentaries (comment_id, user_id, post_id, published_date, comment) VALUES (6, 4, 31, '2022-06-10 12:12:42', 'норм тема');
INSERT INTO php_blog.commentaries (comment_id, user_id, post_id, published_date, comment) VALUES (7, 5, 31, '2022-06-10 12:13:00', 'da
');
INSERT INTO php_blog.commentaries (comment_id, user_id, post_id, published_date, comment) VALUES (8, 1, 31, '2022-06-10 12:13:16', 'точно');