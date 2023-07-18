CREATE TABLE news
(
    id                serial       NOT NULL primary key,
    title             varchar(120) NOT NULL,
    short_description varchar(255)          DEFAULT NULL,
    description       text         NOT NULL,
    date_create       timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    user_id           int          NOT NULL
);


INSERT INTO news (title, short_description, description, date_create, user_id)
VALUES ('Наименование новости', 'Краткое описание новости',
        'Описание новости Описание новости Описание новости Описание новости Описание новости Описание новости Описание новости Описание новости Описание новости Описание новости ',
        '2022-05-05 17:55:47', 1),
       ('Наименование новости 2', 'Краткое описание новости 2',
        'Описание новости 2 Описание новости 2 Описание новости 2 Описание новости 2 Описание новости 2 Описание новости 2 Описание новости 2 Описание новости 2 Описание новости 2 ',
        '2022-05-06 06:40:24', 1);


CREATE TABLE users
(
    id       serial       NOT NULL primary key,
    username varchar(120) NOT NULL,
    login    varchar(24)  NOT NULL,
    password varchar(250) NOT NULL,
    is_admin bool         NOT NULL DEFAULT false
);

INSERT INTO users (username, login, password, is_admin)
VALUES ('admin', 'admin', '$2y$10$G9mhZHzTIReQY3OhqebeQuF9SXqWylXwqP6ukw23MHBrm94yZTfAi', true),
       ('user', 'user', '$2y$10$Y/gftkXEwWbTZPDmO5QJm.fbM/2MiOplLNLWufWpUi32k.TWKbhW2', false);
