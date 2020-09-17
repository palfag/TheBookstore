<?php
    /**
     *  @author Paolo Fagioli
     *
     *  Pagina personale di un libro,
     *  Per ogni libro viene visualizzata:
     *      - la valutazione da 1 a 5 (attraverso le stelline)
     *      - informazioni del libro
     *      - textarea per poter commentare + eventuali commenti già presenti
     *      - libri simili
     *
     * vi è la possibilità di aggiungere un libro al carrello o alla wishlist
     */
    require_once "include/header.php";
    require_once "include/db.inc.php";


    if(!isset($_GET['id_book'])){
        header("Location: ../index.php");
        die;
    }

    $email = $_SESSION['email'];

    // prende le informazioni del libro
    if(isset($_GET['id_book'])){
        $id_book = filter_input(INPUT_GET, "id_book",
            FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $book = retrieve_book_by_id($id_book);

        if(!$book){
            header("Location: home.php");
            die;
        }
        $in_wishlist = is_in_wishlist($id_book, $email);
        $comments = retrieve_comments($id_book);

        $cover = $book['cover'];
        $title = $book['title'];
        $genre = $book['genre'];
        $author = $book['author'];
        $year = $book['published_year'];
        $price = $book['price'];
        $trama = $book['trama'];
        $similars = retrieve_similar_books($id_book, $genre);
    }
?>

<!doctype html>
<html lang="en">
<head>
    <?php require_once "include/top.html"; ?>
    <link rel="stylesheet" href="../css/book.css">
    <script src="../javascript/wishlist.js"></script>
    <script src="../javascript/addToCart.js"></script>
    <script src="../javascript/comment.js"></script>
    <script src="../javascript/rating.js"></script>
    <title><?=$title?></title>
</head>
<body>

<?php require_once "navbar.php"; ?>

    <div class="row">
        <div class="column left">
            <img id="cover" src="<?= $cover ?>" alt="cover">
        </div>
        <div class="column right">
                <h1 id="title"><?= $title ?></h1>
                <h3 id="author"> <?= $author ?></h3>
                <div id="rating-system">
                    <ul>
                        <li class="star" data-index="0">★</li>
                        <li class="star" data-index="1">★</li>
                        <li class="star" data-index="2">★</li>
                        <li class="star" data-index="3">★</li>
                        <li class="star" data-index="4">★</li>
                    </ul>
                    <div id="add-rate-ajax-response"></div>
                </div>
                <h2 id="price">Price: <?= $price ?> € </h2>
                    <button class ="add-to-cart" id="<?=$id_book?>">add to cart</button>
            <?php
                if($in_wishlist){
                    ?>
                    <button class="like-button liked"><img class="like-img" src="../images/icons/like.png" alt="red heart"></button>
            <?php
                }
                else{
                    ?>
                    <button class="like-button not-liked"><img class="like-img" src="../images/icons/no_like.png" alt="grey heart"></button>
            <?php
                }
            ?>
                <h2>Trama</h2>
                <p><?= $trama ?></p>
                <h2>Product Details</h2>
                <p id="genre"><span>Genre:</span> <?= $genre ?></p>
                <p id="year"><span>Year:</span> <?= $year ?></p>
                <h2>Comment here</h2>
                <form id="comment-form" method="POST">
                    <textarea id="comment-text" name="comment"></textarea><br>
                    <input type="submit" value="submit">
                </form>

                <div id="comment-list">
                    <h2>Comments</h2>
                    <hr>
                    <div id="ajax-response"></div>
                    <div class="my-comment">

                    </div>
                    <?php
                        for($i = 0; $i < count($comments); $i++){
                            $comment = $comments[$i];
                    ?>
                            <div class="comment <?= $comment['user'] ?>" id="<?= $comment['id'] ?>">
                                <?php
                                if(strcmp($comment['user'], $email) == 0){
                                    ?>
                                    <button class="delete-comment-btn"><img src="../images/icons/bin.png"></button>
                                    <?php
                                }
                                ?>
                                <a href="profile.php?user=<?= $comment['user'] ?>">
                                    <?php
                                        if($comment['image'] == null){
                                    ?>
                                            <img src="../images/users/default_profile.png" alt="default profile photo">
                                    <?php
                                        }else{
                                    ?>
                                    <img src="<?= $comment['image'] ?>" alt="user's profile photo">
                                    <?php
                                        }
                                    ?>
                                </a>
                                <p class="user">
                                    <a href="profile.php?user=<?= $comment['user'] ?>">
                                        <span id="user-link"><?=$comment['name']?> <?=$comment['surname']?></span>
                                    </a>
                                </p>
                                <p><?= $comment['comment']?></p>
                                <p><span id="timestamp"><?= convert_date($comment['date'])?></span></p>
                            </div>
                    <?php
                        }
                    ?>

                </div>
                <h2>Similars</h2>
                <hr>
                <div id="similar">
                    <?php
                        for($i = 0; $i < count($similars); $i++){
                            $sim = $similars[$i];
                    ?>
                        <div class="book">
                            <div class="cover">
                                <a href='book.php?id_book=<?= $sim["book_id"] ?>'><img src="<?= $sim["cover"] ?>" alt="cover"></a>
                            </div>
                            <a href='book.php?id_book=<?= $sim["book_id"] ?>'><h3 class="title"> <?= $sim["title"] ?></h3></a>

                            <p class="author"><?= $sim["author"]?></p>
                        </div>
                    <?php
                        }
                    ?>
                </div>
        </div>
    </div>
    <?php require_once "include/footer.html"; ?>
</body>
</html>



<?php

/**
 * Recupera tutte le informazioni del libro dato l'id
 * @param $id_book id del libro che si vuole recuperare
 * @return |null Ritorna la row contenente tutte le informazioni su quel libro
 */
function retrieve_book_by_id($id_book){
    $db = database_connection();
    $rows = $db->query("SELECT * FROM books WHERE  book_id = '$id_book'");
    $res = null;
        if($rows){
            foreach ($rows as $row){
                $res = $row;
            }
        }
        $db->close();
        return $res;
}

/**
 * Verifica se un dato libro è presente nella wishlist dell'utente loggato
 * @param $id_book libro che si vuole verificare
 * @param $email email dell'utente loggato
 * @return bool Ritorna TRUE se il libro è in wishlist, FALSE altrimenti
 */
function is_in_wishlist($id_book, $email){
    $db = database_connection();
    $rows = $db->query("SELECT * FROM Wishlist WHERE  user = '$email' AND item = '$id_book'");
    $res = false;

        if($rows){
            if($rows->num_rows == 1)
                $res = true;
        }

        $db->close();
        return $res;
}


/**
 * Recupera tutti i commenti riferiti a quel libro
 * @param $id_book libro per cui i vogliono recuperare i commenti
 * @return array Ritorna un array di commenti
 */
function retrieve_comments($id_book){
    $db = database_connection();
    $rows = $db->query("SELECT id,user, comment, name, surname, image, date 
                                  FROM Comments JOIN Users on email = user 
                                  WHERE item = '$id_book'
                                  ORDER BY date DESC");
    $data = array();

        if($rows){
            foreach ($rows as $row){
                $data[] = $row;
            }
        }

        $db->close();
        return $data;
}


/**
 * Formatta la data in stringa
 * @param $timestamp datetime
 * @return false|string Ritorna la data formattata
 */
function convert_date($timestamp){
    return date('d-m-y  H:i', strtotime($timestamp)); // H: 24h format - h: 12h format !
}

/**
 * Recupera tre libri simili (stesso genere) al libro specificato come parametro
 * @param $id id del libro passato come parametro
 * @param $genre categoria del libro passato come parametro
 * @return array di libri simili che hanno la stessa categoria
 */
function retrieve_similar_books($id, $genre){
    $db = database_connection();
    $rows = $db->query("SELECT DISTINCT author, cover, title, book_id
                                    FROM Books
                                    WHERE book_id <> '$id' AND genre = '$genre' ORDER BY RAND() LIMIT 3");
    $data = array();

        if($rows){
            foreach ($rows as $row){
                $data[] = $row;
            }
        }

    $db->close();
    return $data;
}
?>
