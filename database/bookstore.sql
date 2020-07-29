
CREATE TABLE Users(
    email varchar(32) primary key,
    name varchar(32) NOT NULL ,
    surname varchar(32),
    pwd varchar(256) NOT NULL,
    image varchar(256)
);
