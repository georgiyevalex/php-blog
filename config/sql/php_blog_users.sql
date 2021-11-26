create table users
(
    user_id    int unsigned auto_increment
        primary key,
    first_name varchar(255)               not null,
    last_name  varchar(255)               not null,
    email      varchar(255)               not null,
    password   varchar(255)               not null,
    role       varchar(50) default 'user' not null,
    constraint email
        unique (email)
);

INSERT INTO php_blog.users (user_id, first_name, last_name, email, password, role) VALUES (1, 'Admin', 'Admin', 'admin@mail.ru', '$2y$10$OmZpp6uNq49fZrexGUTxVeiSZHWCXgK2c4QFcsphryR3lDRlljOGW', 'admin');
INSERT INTO php_blog.users (user_id, first_name, last_name, email, password, role) VALUES (2, 'User', 'User', 'user@mail.ru', '$2y$10$OmZpp6uNq49fZrexGUTxVeiSZHWCXgK2c4QFcsphryR3lDRlljOGW', 'user');
INSERT INTO php_blog.users (user_id, first_name, last_name, email, password, role) VALUES (3, 'Reviewer', 'Reviewer', 'reviewer@mail.ru', '$2y$10$OmZpp6uNq49fZrexGUTxVeiSZHWCXgK2c4QFcsphryR3lDRlljOGW', 'reviewer');