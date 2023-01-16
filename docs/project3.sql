DROP TABLE IF EXISTS project3;
CREATE TABLE user (
    email varchar(60) not null check (email != ''),
    user_password varchar(60) not null check (user_password != ''),
    information LONGTEXT NOT NULL,
    saved LONGTEXT NOT NULL DEFAULT ''
);
-- INSERT INTO project3 VALUES ('etagaca@csub.edu', 'etagaca', '{"job" : "developer"}', '{"title": "software engineer"}');
-- INSERT INTO lab6_credentials VALUES ('$2y$10$NjtLNxeb1Jq0FsY8VYCDfuVhd5IkteEWIkCdynOAFNR5Y6r6ucsrq');