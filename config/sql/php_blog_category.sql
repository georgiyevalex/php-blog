create table category
(
    category_id   int auto_increment
        primary key,
    category_name varchar(255) not null,
    constraint category_category_name_uindex
        unique (category_name)
);

INSERT INTO php_blog.category (category_id, category_name) VALUES (2, 'fashion');
INSERT INTO php_blog.category (category_id, category_name) VALUES (7, 'fitness');
INSERT INTO php_blog.category (category_id, category_name) VALUES (3, 'food');
INSERT INTO php_blog.category (category_id, category_name) VALUES (6, 'lifestyle');
INSERT INTO php_blog.category (category_id, category_name) VALUES (5, 'music');
INSERT INTO php_blog.category (category_id, category_name) VALUES (8, 'sport');
INSERT INTO php_blog.category (category_id, category_name) VALUES (4, 'travel');
INSERT INTO php_blog.category (category_id, category_name) VALUES (1, 'undefined');