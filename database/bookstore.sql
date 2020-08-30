
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

CREATE TABLE Cart(
    insertion_id int(32) primary key AUTO_INCREMENT,
    user varchar(32),
    item int(32),
    foreign key(user) references Users(email) on update cascade on delete cascade,
    foreign key(item) references Books(book_id) on update cascade on delete cascade
);

CREATE TABLE Wishlist(
    user varchar(32),
    item int(32),
    primary key(user,item),
    foreign key(user) references Users(email) on update cascade on delete cascade,
    foreign key(item) references Books(book_id) on update cascade on delete cascade
);

CREATE TABLE Comments(
    id int(32) primary key AUTO_INCREMENT,
    user varchar(32),
    item int(32),
    comment text,
    date datetime,
    foreign key(user) references Users(email) on update cascade on delete cascade,
    foreign key(item) references Books(book_id) on update cascade on delete cascade
);

/*CREATE DOMAIN SCORE_RATE AS REAL CHECK
(value >= 1 && value <=5);*/

CREATE TABLE Rating(
    item int(32),
    user varchar(32),
    rate smallint(1) not null,
    primary key(user,item),
    foreign key(user) references Users(email) on update cascade on delete cascade,
    foreign key(item) references Books(book_id) on update cascade on delete cascade
);

CREATE TABLE Purchases(
    id int(32),
    user varchar(32),
    item int(32),
    quantity int(10),
    primary key(id, item),
    foreign key(user) references Users(email) on update cascade on delete cascade,
    foreign key(item) references Books(book_id) on update cascade on delete cascade
);

CREATE TABLE Payments(
        user varchar(32) primary key,
        card_number varchar(16),
        card_type varchar(32),
        expiry_date varchar(32),
        cvv int(3),
        card_holder varchar(32),
        foreign key(user) references Users(email) on update cascade on delete cascade
);

INSERT INTO Payments(user, card_number, card_type, expiry_date, cvv, card_holder)
    values('palfag@icloud.com', '365728835962346', 'american-express', '12/22', 600, 'Paolo Fagioli')

INSERT INTO Purchases(id, user, item, quantity)
    values  (1, 'palfag@icloud.com', 4, 5),
            (2, 'cirtlavinia@yahoo.com', 4, 5)

INSERT INTO Rating(item, user, rate)
    values  (4, 'palfag@icloud.com', 5),
            (4, 'cirtlavinia@yahoo.com', 1)

INSERT INTO Comments(user, item, comment, date)
    values('palfag@icloud.com', 4, 'awesome book !', now())

INSERT INTO Rating(item, user, rate)
                            VALUES(4, 'palfag@icloud.com', 4)
                            ON DUPLICATE KEY UPDATE rate = 4


INSERT INTO Books(title, genre, trama, author, published_year, cover, price)
    values ('The Little Prince', 'Novel', ' A book to discover during childhood and re-read throughout your life. A must-read that highlights deep life topics like love, friendship, solitude, and the meaning of life. A young aviator crashes his plane in the middle of the Sahara Desert. In the isolation of the blistering sand dunes, he meets a strange little boy - the little prince. Over the next ten days, as the aviator tries to fix his plane on a fast depleting store of food and water, he also gradually learns the little prince''s extraordinary story. The little prince talks of his own tiny planet, his beloved rose, the serious threat of baobabs, and of his travels to different planets. As the sad experiences of the little prince''s life are unfurled, so grows the affection for him in the aviator''s heart. Antoine de Saint-Exupery''s classic text has enthralled its readers, adults and children alike, over decades. The story is reflective of notions of loyalty, friendship, love and hope, easy but intense. The little prince s simplicity throws the futility of endless human desires into a sharp relief, making it as profound as it is poetic.',
            'Antoine de Saint-Exupéry','1943','../images/book_covers/the_little_prince.jpg',10.07),
            ('Frankenstein','Novel', 'I saw the pale student of unhallowed arts kneeling beside the thing he had put together. I saw the hideous phantasm of a man stretched out, and then, on the working of some powerful engine, show signs of life and stir with an uneasy, half-vital motion. "A summer evening"s ghost stories, lonely insomnia in a moonlit Alpines room, and a runaway imagination -- fired by philosophical discussions with Lord Byron and Percy Bysshe Shelley about science, galvanism, and the origins of life -- conspired to produce for Mary Shelley this haunting night specter. By morning, it had become the germ of her Romantic masterpiece, "Frankenstein." Written in 1816 when she was only 19, Mary Shelley''s novel of ''The Modern Prometheus'' chillingly dramatized the dangerous potential of life begotten upon a laboratory table. A frightening creation myth for our own time, "Frankenstein" remains one of the greatest horror stories ever written and is an undisputed classic of its kind.',
            'Mary Shelley', '1994', '../images/book_covers/frankenstein.jpg', 6.00),
            ('The Great Gatsby', 'Classic','The Great Gatsby, F. Scott Fitzgerald s third book, stands as the supreme achievement of his career. First published in 1925, this quintessential novel of the Jazz Age has been acclaimed by generations of readers. The story of the mysteriously wealthy Jay Gatsby and his love for the beautiful Daisy Buchanan, of lavish parties on Long Island at a time when The New York Times noted "gin was the national drink and sex the national obsession," it is an exquisitely crafted tale of America in the 1920s.',
            'F. Scott Fitzgerald ', '1925', '../images/book_covers/gatsby.jpg', 15.64),
            ('Dr Jekyll & Mr Hyde', 'Classic', '"Jekyll And Hyde" was an instant success and brought Stevenson his first taste of fame. Though sometimes dismissed as a mere mystery story, the book has evoked much literary admirations. Vladimir Nabokov likened it to "Madame Bovary" and "Dead Souls" as "a fable that lies nearer to poetry than to ordinary prose fiction."',
            'Robert Louis Stevenson', '1866', '../images/book_covers/jekill.jpg', 2.76),
            ('Machbeth', 'Classic', 'Shakespeare s Macbeth is one of the greatest tragic dramas the world has known. Macbeth himself, a brave warrior, is fatally impelled by supernatural forces, by his proud wife, and by his own burgeoning ambition. As he embarks on his murderous course to gain and retain the crown of Scotland, we see the appalling emotional and psychological effects on both Lady Macbeth and himself. The cruel ironies of their destiny are conveyed in poetry of unsurpassed power. In the theatre, this tragedy remains perennially engrossing.',
            'William Shakespeare', '1997', '../images/book_covers/machbeth.jpg', 8.58),
            ('Don Quixotte', 'Classic', 'Cervantes tale of the deranged gentleman who turns knight-errant, tilts at windmills and battles with sheep in the service of the lady of his dreams, Dulcinea del Toboso, has fascinated generations of readers, and inspired other creative artists such as Flaubert, Picasso and Richard Strauss. The tall, thin knight and his short, fat squire, Sancho Panza, have found their way into films, cartoons and even computer games.',
            'Miguel de Cervantes', '1992', '../images/book_covers/don_quixote.jpg', 6.80),
            ('Moby Dick', 'Novel', 'At the heart of Moby-Dick is the powerful, unknowable sea--and Captain Ahab, a brooding, one-legged fanatic who has sworn vengeance on the mammoth white whale that crippled him. Narrated by Ishmael, a wayfarer who joins the crew of Ahab s whaling ship, this is the story of that hair-raising voyage, and of the men who embraced hardship and nameless horrors as they dared to challenge God s most dreaded creation and death itself for a chance at immortality.
                        A novel that delves with astonishing vigor into the complex souls of men, Moby-Dick is an impassioned drama of the ultimate human struggle that the Atlantic Monthly called "the greatest of American novels."',
            'Herman Melville', '2013', '../images/book_covers/moby_dick.jpg', 5.47),
            ('Romeo & Juliet', 'Tragic', 'In Romeo and Juliet, Shakespeare creates a violent world, in which two young people fall in love. It is not simply that their families disapprove; the Montagues and the Capulets are engaged in a blood feud.
                        In this death-filled setting, the movement from love at first sight to the lovers final union in death seems almost inevitable. And yet, this play set in an extraordinary world has become the quintessential story of young love. In part because of its exquisite language, it is easy to respond as if it were about all young lovers.',
            'William Shakespeare','2004', '../images/book_covers/romeo_juliet.jpg', 6.43),
            ('Ulysses', 'Classic', 'Stately- plump Buck Mulligan came from the stairhead- bearing a bowl of lather on which a mirror and a razor lay crossed.(Except)',
            'James Joyce', '1990', '../images/book_covers/ulysses.jpg', 15.64)


INSERT INTO BookGenres(genre)
    values('Novel'),
          ('Classic'),
          ('Tragic')


INSERT INTO Wishlist(user, item)
    values('palfag@icloud.com', 1);
