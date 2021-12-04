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