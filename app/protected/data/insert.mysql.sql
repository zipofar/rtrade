INSERT INTO tbl_users (username, password, role) VALUES ('test1', '$2y$13$vuWxNshA/jRjdx.QrTZtp.uj8QumPknYJ7gUYR/9CyKb0R.m2sWTu', 'user');
INSERT INTO tbl_users (username, password, role) VALUES ('test2', '$2y$13$vuWxNshA/jRjdx.QrTZtp.uj8QumPknYJ7gUYR/9CyKb0R.m2sWTu', 'user');
INSERT INTO tbl_users (username, password, role) VALUES ('root', '$2y$13$vuWxNshA/jRjdx.QrTZtp.uj8QumPknYJ7gUYR/9CyKb0R.m2sWTu', 'admin');

INSERT INTO tbl_films (name, description, user_id) VALUES ('Film 1', 'Description 1', '1');
INSERT INTO tbl_films (name, description, user_id) VALUES ('Film 2', 'Description 2', '1');
INSERT INTO tbl_films (name, description, user_id) VALUES ('Film 3', 'Description 3', '2');
INSERT INTO tbl_films (name, description, user_id) VALUES ('Film 4', 'Description 4', '2');

INSERT INTO tbl_comments (content, user_id, film_id) VALUES ('Comment 1', '1', '1');
INSERT INTO tbl_comments (content, user_id, film_id) VALUES ('Comment 2', '2', '1');
INSERT INTO tbl_comments (content, user_id, film_id) VALUES ('Comment 3', '1', '2');
INSERT INTO tbl_comments (content, user_id, film_id) VALUES ('Comment 4', '2', '2');

