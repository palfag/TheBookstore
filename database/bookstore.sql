
CREATE TABLE Users(
    email varchar(32) primary key,
    name varchar(32) NOT NULL ,
    surname varchar(32),
    pwd varchar(256) NOT NULL,
    image varchar(256)
);

CREATE TABLE Books(
    book_id int(32) primary key AUTO_INCREMENT,
    title varchar(32) NOT NULL,
    genre varchar(32),
    trama text,
    author varchar(32) NOT NULL,
    published_year year(4),
    cover varchar(255) NOT NULL,
    price decimal(6,2),
    foreign key(genre) references BookGenres(genre) on update cascade on delete set null
);

CREATE TABLE BookGenres(
    genre varchar(32) primary key
);


INSERT INTO Books(title, genre, trama, author, published_year, cover, price)
    values ('The Little Prince', 'Novel', ' A book to discover during childhood and re-read throughout your life. A must-read that highlights deep life topics like love, friendship, solitude, and the meaning of life. A young aviator crashes his plane in the middle of the Sahara Desert. In the isolation of the blistering sand dunes, he meets a strange little boy - the little prince. Over the next ten days, as the aviator tries to fix his plane on a fast depleting store of food and water, he also gradually learns the little prince''s extraordinary story. The little prince talks of his own tiny planet, his beloved rose, the serious threat of baobabs, and of his travels to different planets. As the sad experiences of the little prince''s life are unfurled, so grows the affection for him in the aviator''s heart. Antoine de Saint-Exupery''s classic text has enthralled its readers, adults and children alike, over decades. The story is reflective of notions of loyalty, friendship, love and hope, easy but intense. The little prince s simplicity throws the futility of endless human desires into a sharp relief, making it as profound as it is poetic.',
            'Antoine de Saint-Exupéry','1943','../images/book_covers/the_little_prince.jpg',10.07);


INSERT INTO BookGenres(genre)
    values('Novel');
