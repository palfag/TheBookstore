-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:8889
-- Generation Time: Sep 13, 2020 at 03:05 PM
-- Server version: 5.7.26
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `bookstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `BookGenres`
--

CREATE TABLE `BookGenres` (
    `genre` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `BookGenres`
--

INSERT INTO `BookGenres` (`genre`) VALUES
('Classic'),
('Novel'),
('Tragic');

-- --------------------------------------------------------

--
-- Table structure for table `Books`
--

CREATE TABLE `Books` (
                         `book_id` int(32) NOT NULL,
                         `title` varchar(32) NOT NULL,
                         `genre` varchar(32) DEFAULT NULL,
                         `trama` text,
                         `author` varchar(32) NOT NULL,
                         `published_year` year(4) DEFAULT NULL,
                         `cover` varchar(255) NOT NULL,
                         `price` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Books`
--

INSERT INTO `Books` (`book_id`, `title`, `genre`, `trama`, `author`, `published_year`, `cover`, `price`) VALUES
(1, 'The Little Prince', 'Novel', ' A book to discover during childhood and re-read throughout your life. A must-read that highlights deep life topics like love, friendship, solitude, and the meaning of life. A young aviator crashes his plane in the middle of the Sahara Desert. In the isolation of the blistering sand dunes, he meets a strange little boy - the little prince. Over the next ten days, as the aviator tries to fix his plane on a fast depleting store of food and water, he also gradually learns the little prince\'s extraordinary story. The little prince talks of his own tiny planet, his beloved rose, the serious threat of baobabs, and of his travels to different planets. As the sad experiences of the little prince\'s life are unfurled, so grows the affection for him in the aviator\'s heart. Antoine de Saint-Exupery\'s classic text has enthralled its readers, adults and children alike, over decades. The story is reflective of notions of loyalty, friendship, love and hope, easy but intense. The little prince s simplicity throws the futility of endless human desires into a sharp relief, making it as profound as it is poetic.', 'Antoine de Saint-Exupéry', 1943, '../images/book_covers/the_little_prince.jpg', '10.07'),
(2, 'Frankenstein', 'Novel', 'I saw the pale student of unhallowed arts kneeling beside the thing he had put together. I saw the hideous phantasm of a man stretched out, and then, on the working of some powerful engine, show signs of life and stir with an uneasy, half-vital motion. \"A summer evening\"s ghost stories, lonely insomnia in a moonlit Alpines room, and a runaway imagination -- fired by philosophical discussions with Lord Byron and Percy Bysshe Shelley about science, galvanism, and the origins of life -- conspired to produce for Mary Shelley this haunting night specter. By morning, it had become the germ of her Romantic masterpiece, \"Frankenstein.\" Written in 1816 when she was only 19, Mary Shelley\'s novel of \'The Modern Prometheus\' chillingly dramatized the dangerous potential of life begotten upon a laboratory table. A frightening creation myth for our own time, \"Frankenstein\" remains one of the greatest horror stories ever written and is an undisputed classic of its kind.', 'Mary Shelley', 1994, '../images/book_covers/frankenstein.jpg', '6.00'),
(3, 'The Great Gatsby', 'Classic', 'The Great Gatsby, F. Scott Fitzgerald s third book, stands as the supreme achievement of his career. First published in 1925, this quintessential novel of the Jazz Age has been acclaimed by generations of readers. The story of the mysteriously wealthy Jay Gatsby and his love for the beautiful Daisy Buchanan, of lavish parties on Long Island at a time when The New York Times noted \"gin was the national drink and sex the national obsession,\" it is an exquisitely crafted tale of America in the 1920s.', 'F. Scott Fitzgerald ', 1925, '../images/book_covers/gatsby.jpg', '15.64'),
(4, 'Dr Jekyll & Mr Hyde', 'Classic', 'Jekyll And Hyde was an instant success and brought Stevenson his first taste of fame. Though sometimes dismissed as a mere mystery story, the book has evoked much literary admirations. Vladimir Nabokov likened it to Madame Bovary and Dead Souls as \"a fable that lies nearer to poetry than to ordinary prose fiction.', 'Robert Louis Stevenson', 1966, '../images/book_covers/jekill.jpg', '2.76'),
(5, 'Machbeth', 'Classic', 'Shakespeare s Macbeth is one of the greatest tragic dramas the world has known. Macbeth himself, a brave warrior, is fatally impelled by supernatural forces, by his proud wife, and by his own burgeoning ambition. As he embarks on his murderous course to gain and retain the crown of Scotland, we see the appalling emotional and psychological effects on both Lady Macbeth and himself. The cruel ironies of their destiny are conveyed in poetry of unsurpassed power. In the theatre, this tragedy remains perennially engrossing.', 'William Shakespeare', 1997, '../images/book_covers/machbeth.jpg', '8.58'),
(6, 'Don Quixotte', 'Classic', 'Cervantes tale of the deranged gentleman who turns knight-errant, tilts at windmills and battles with sheep in the service of the lady of his dreams, Dulcinea del Toboso, has fascinated generations of readers, and inspired other creative artists such as Flaubert, Picasso and Richard Strauss. The tall, thin knight and his short, fat squire, Sancho Panza, have found their way into films, cartoons and even computer games.', 'Miguel de Cervantes', 1992, '../images/book_covers/don_quixote.jpg', '6.80'),
(7, 'Moby Dick', 'Novel', 'At the heart of Moby-Dick is the powerful, unknowable sea--and Captain Ahab, a brooding, one-legged fanatic who has sworn vengeance on the mammoth white whale that crippled him. Narrated by Ishmael, a wayfarer who joins the crew of Ahab s whaling ship, this is the story of that hair-raising voyage, and of the men who embraced hardship and nameless horrors as they dared to challenge God s most dreaded creation and death itself for a chance at immortality.\r\n                        A novel that delves with astonishing vigor into the complex souls of men, Moby-Dick is an impassioned drama of the ultimate human struggle that the Atlantic Monthly called \"the greatest of American novels.\"', 'Herman Melville', 2013, '../images/book_covers/moby_dick.jpg', '5.47'),
(8, 'Romeo & Juliet', 'Tragic', 'In Romeo and Juliet, Shakespeare creates a violent world, in which two young people fall in love. It is not simply that their families disapprove; the Montagues and the Capulets are engaged in a blood feud.\r\n                        In this death-filled setting, the movement from love at first sight to the lovers final union in death seems almost inevitable. And yet, this play set in an extraordinary world has become the quintessential story of young love. In part because of its exquisite language, it is easy to respond as if it were about all young lovers.', 'William Shakespeare', 2004, '../images/book_covers/romeo_juliet.jpg', '6.43'),
(9, 'Ulysses', 'Classic', 'Stately- plump Buck Mulligan came from the stairhead- bearing a bowl of lather on which a mirror and a razor lay crossed.(Except)', 'James Joyce', 1990, '../images/book_covers/ulysses.jpg', '15.64');

-- --------------------------------------------------------

--
-- Table structure for table `Cart`
--

CREATE TABLE `Cart` (
                        `insertion_id` int(32) NOT NULL,
                        `user` varchar(32) DEFAULT NULL,
                        `item` int(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Comments`
--

CREATE TABLE `Comments` (
                            `id` int(32) NOT NULL,
                            `user` varchar(32) DEFAULT NULL,
                            `item` int(32) DEFAULT NULL,
                            `comment` text,
                            `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Comments`
--

INSERT INTO `Comments` (`id`, `user`, `item`, `comment`, `date`) VALUES
(13, 'cirtlavinia@yahoo.com', 5, ' easy to read... Good book!', '2020-08-24 12:57:43'),
(14, 'cirtlavinia@yahoo.com', 1, 'ciao\n', '2020-08-24 12:59:14'),
(15, 'cirtlavinia@yahoo.com', 5, 'prova', '2020-08-24 16:28:54'),
(30, 'cirtlavinia@yahoo.com', 6, 'good', '2020-08-25 10:51:32'),
(37, 'cirtlavinia@yahoo.com', 6, 'prova', '2020-08-27 09:00:33'),
(38, 'cirtlavinia@yahoo.com', 6, 'ora', '2020-08-27 09:01:08'),
(39, 'cirtlavinia@yahoo.com', 6, 'ciao', '2020-08-27 09:02:03'),
(40, 'cirtlavinia@yahoo.com', 6, 'ciao', '2020-08-27 09:03:37'),
(41, 'cirtlavinia@yahoo.com', 6, 'ciao', '2020-08-27 09:04:12'),
(42, 'cirtlavinia@yahoo.com', 6, 'riprovo', '2020-08-27 09:12:50'),
(43, 'cirtlavinia@yahoo.com', 6, 'ora deve funzionare', '2020-08-27 09:14:24'),
(44, 'cirtlavinia@yahoo.com', 6, 'dryhe', '2020-08-27 09:15:18'),
(47, 'cirtlavinia@yahoo.com', 6, 'sto pubblicando', '2020-08-27 09:17:42'),
(50, 'palfag@icloud.com', 5, 'mi piacerebbe tanto farlo leggere a mia figlia... ottimo libro baci', '2020-08-27 09:20:52'),
(51, 'cirtlavinia@yahoo.com', 6, 'wow', '2020-08-29 09:57:43'),
(67, 'palfag@icloud.com', 7, 'i love this book... ', '2020-09-09 13:18:21');

-- --------------------------------------------------------

--
-- Table structure for table `Payments`
--

CREATE TABLE `Payments` (
                            `user` varchar(32) NOT NULL,
                            `card_number` varchar(50) DEFAULT NULL,
                            `card_type` varchar(32) DEFAULT NULL,
                            `expiry_date` varchar(32) DEFAULT NULL,
                            `cvv` varchar(32) DEFAULT NULL,
                            `card_holder` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Payments`
--

INSERT INTO `Payments` (`user`, `card_number`, `card_type`, `expiry_date`, `cvv`, `card_holder`) VALUES
('palfag@icloud.com', 'MTQ1ODc2NTQzMjU2NjU0Mw==', 'visa', '12/23', 'MjM0', 'Paolo Fagioli');

-- --------------------------------------------------------

--
-- Table structure for table `Purchases`
--

CREATE TABLE `Purchases` (
                             `id` int(32) NOT NULL,
                             `user` varchar(32) DEFAULT NULL,
                             `item` int(32) NOT NULL,
                             `quantity` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Purchases`
--

INSERT INTO `Purchases` (`id`, `user`, `item`, `quantity`) VALUES
(8, 'cirtlavinia@yahoo.com', 9, 1),
(9, 'cirtlavinia@yahoo.com', 2, 1),
(9, 'cirtlavinia@yahoo.com', 4, 1),
(9, 'cirtlavinia@yahoo.com', 7, 1),
(9, 'cirtlavinia@yahoo.com', 9, 1),
(10, 'palfag@icloud.com', 4, 1),
(11, 'palfag@icloud.com', 4, 1),
(11, 'palfag@icloud.com', 5, 1),
(12, 'palfag@icloud.com', 2, 1),
(12, 'palfag@icloud.com', 4, 5),
(13, 'palfag@icloud.com', 3, 1),
(13, 'palfag@icloud.com', 4, 1),
(14, 'cirtlavinia@yahoo.com', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Rating`
--

CREATE TABLE `Rating` (
                          `item` int(32) NOT NULL,
                          `user` varchar(32) NOT NULL,
                          `rate` smallint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Rating`
--

INSERT INTO `Rating` (`item`, `user`, `rate`) VALUES
(2, 'cirtlavinia@yahoo.com', 5),
(4, 'cirtlavinia@yahoo.com', 3),
(6, 'cirtlavinia@yahoo.com', 3),
(2, 'palfag@icloud.com', 2),
(4, 'palfag@icloud.com', 4),
(7, 'palfag@icloud.com', 4),
(8, 'palfag@icloud.com', 3);

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
                         `email` varchar(32) NOT NULL,
                         `name` varchar(32) NOT NULL,
                         `surname` varchar(32) DEFAULT NULL,
                         `pwd` varchar(256) NOT NULL,
                         `image` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`email`, `name`, `surname`, `pwd`, `image`) VALUES
('cirtlavinia@yahoo.com', 'Lavinia', 'Cirt', '$2y$10$Vr5ICsLAatvhYWwiXKnO/.YugUMHrz5VwqgkTlytSym8Zj9SF4dc6', '../images/users/1597590937_IMG_4775.jpeg'),
('palfag@icloud.com', 'Paolo', 'Fagioli', '$2y$10$WUBUwRlYutoAcRcqNPILredOtAdosa77DcnFCs5juetA84Tm2Kcya', '../images/users/palfag@icloud.com.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `Wishlist`
--

CREATE TABLE `Wishlist` (
                            `user` varchar(32) NOT NULL,
                            `item` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Wishlist`
--

INSERT INTO `Wishlist` (`user`, `item`) VALUES
('cirtlavinia@yahoo.com', 2),
('palfag@icloud.com', 3),
('palfag@icloud.com', 4),
('palfag@icloud.com', 5),
('palfag@icloud.com', 7),
('cirtlavinia@yahoo.com', 8),
('palfag@icloud.com', 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `BookGenres`
--
ALTER TABLE `BookGenres`
    ADD PRIMARY KEY (`genre`);

--
-- Indexes for table `Books`
--
ALTER TABLE `Books`
    ADD PRIMARY KEY (`book_id`),
    ADD KEY `genre` (`genre`);

--
-- Indexes for table `Cart`
--
ALTER TABLE `Cart`
    ADD PRIMARY KEY (`insertion_id`),
    ADD KEY `user` (`user`),
    ADD KEY `item` (`item`);

--
-- Indexes for table `Comments`
--
ALTER TABLE `Comments`
    ADD PRIMARY KEY (`id`),
    ADD KEY `user` (`user`),
    ADD KEY `item` (`item`);

--
-- Indexes for table `Payments`
--
ALTER TABLE `Payments`
    ADD PRIMARY KEY (`user`);

--
-- Indexes for table `Purchases`
--
ALTER TABLE `Purchases`
    ADD PRIMARY KEY (`id`,`item`),
    ADD KEY `user` (`user`),
    ADD KEY `item` (`item`);

--
-- Indexes for table `Rating`
--
ALTER TABLE `Rating`
    ADD PRIMARY KEY (`user`,`item`),
    ADD KEY `item` (`item`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
    ADD PRIMARY KEY (`email`);

--
-- Indexes for table `Wishlist`
--
ALTER TABLE `Wishlist`
    ADD PRIMARY KEY (`user`,`item`),
    ADD KEY `item` (`item`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Books`
--
ALTER TABLE `Books`
    MODIFY `book_id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `Cart`
--
ALTER TABLE `Cart`
    MODIFY `insertion_id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=498;

--
-- AUTO_INCREMENT for table `Comments`
--
ALTER TABLE `Comments`
    MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Books`
--
ALTER TABLE `Books`
    ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`genre`) REFERENCES `BookGenres` (`genre`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `Cart`
--
ALTER TABLE `Cart`
    ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user`) REFERENCES `Users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`item`) REFERENCES `Books` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Comments`
--
ALTER TABLE `Comments`
    ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user`) REFERENCES `Users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`item`) REFERENCES `Books` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Payments`
--
ALTER TABLE `Payments`
    ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`user`) REFERENCES `Users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Purchases`
--
ALTER TABLE `Purchases`
    ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`user`) REFERENCES `Users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `purchases_ibfk_2` FOREIGN KEY (`item`) REFERENCES `Books` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Rating`
--
ALTER TABLE `Rating`
    ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`user`) REFERENCES `Users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`item`) REFERENCES `Books` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Wishlist`
--
ALTER TABLE `Wishlist`
    ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user`) REFERENCES `Users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`item`) REFERENCES `Books` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE;
