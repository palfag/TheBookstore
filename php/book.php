<?php
/*
 *   Book page
 */
require_once "top.php";
require_once "db.inc.php";
require_once "navbar.php";

if(!isset($_SESSION['email'])){
    header("Location: index.php");
    die;
}

$email = $_SESSION['email'];

// prende le informazioni del libro
if(isset($_GET['id_book'])){
    $id_book = filter_input(INPUT_GET, "id_book",
        FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $book = retreive_book_by_id($id_book);
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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/book.css">
    <script src="../javascript/wishlist.js"></script>
    <script src="../javascript/addToCart.js"></script>
    <script src="../javascript/comment.js"></script>
    <script src="../javascript/rating.js"></script>
    <link rel="icon" type="image/png" href="../images/icons/favicon.png"/>
    <link rel="stylesheet" href="../css/footer.css">
</head>
<body>

    <div class="row">
        <div class="column left">
            <img id="cover" src="<?= $cover ?>">
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
                        <div id="add-rate-ajax-response"></div>
                    </ul>
                </div>
                <h2 id="price">Price: <?= $price ?> € </h2>
                    <button class ="add-to-cart" id="<?=$id_book?>">add to cart</button>
            <?php
                if($in_wishlist){
                    ?>
                    <button class="like-button liked"><img class="like-img" src="../images/icons/like.png"></button>
            <?php
                }
                else{
                    ?>
                    <button class="like-button not-liked"><img class="like-img" src="../images/icons/no_like.png"></button>
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
                                    <img src="<?= $comment['image'] ?>">
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
                <div id="similar">
                    <h2>Similars</h2>
                    <hr>
                    <?php
                        if($similars){
                            for($i = 0; $i < count($similars); $i++){
                                $sim = $similars[$i];
                                ?>

                                <div class="book">
                                    <div class="cover">
                                        <a href='book.php?id_book=<?= $sim["book_id"] ?>'><img src="<?= $sim["cover"] ?>"></a></div>
                                    <a href='book.php?id_book=<?= $sim["book_id"] ?>'><h3 class="title"> <?= $sim["title"] ?></h3></a>

                                    <p class="author"><?= $sim["author"]?></p>
                                </div>

                                <?php
                            }
                        }
                    ?>
                </div>
        </div>
    </div>
    <?php require_once "footer.php"; ?>


    <?php

        function retreive_book_by_id($id_book){
            $db = database_connection();
            $rows = $db->query("SELECT * FROM books WHERE  book_id = '$id_book'");
            try{
                if($rows){
                    foreach ($rows as $row){
                        return $row;
                    }
                }
                else throw new Exception("query error");
            } catch(Exception $e){
                $e->getMessage();
                ######### TODO: DA DEFINIRE COSA FARE IN CASO DI ECCEZIONI
            } finally {
                $db->close();
            }
        }

    function is_in_wishlist($id_book, $email){
        $db = database_connection();
        $rows = $db->query("SELECT * FROM Wishlist WHERE  user = '$email' AND item = '$id_book'");
        try{
            if($rows){
                foreach ($rows as $row){
                    return true;
                }
                return false;
            }
            else throw new Exception("query error");
        } catch(Exception $e){
            $e->getMessage();
            return false;
            ######### TODO: DA DEFINIRE COSA FARE IN CASO DI ECCEZIONI
        } finally {
            $db->close();
        }
    }


    // funzione per prendere tutti i commenti riguardo quel libro
    function retrieve_comments($id_book){
        $db = database_connection();
        $rows = $db->query("SELECT id,user, comment, name, surname, image, date 
                                  FROM Comments JOIN Users on email = user 
                                  WHERE item = '$id_book'
                                  ORDER BY date DESC");
        $data = array();
        try{
            if($rows){
                foreach ($rows as $row){
                    $data[] = $row;
                }
            }
            else throw new Exception("query error");
        } catch(Exception $e){
            $e->getMessage();
            ######### TODO: DA DEFINIRE COSA FARE IN CASO DI ECCEZIONI
        } finally {
            $db->close();
            return $data;
        }
    }

    function is_owner($id_book, $email){
        $db = database_connection();

        $sql = "SELECT * FROM Purchases where user='$email' AND item='$id_book'";
        try {
            $rows = $db->query($sql);
            if ($rows) {
                if($rows->num_rows == 0)
                    return false;
                return true;
            }
            else throw new Exception("query error");
        } catch (Exception $e) {
            $e->getMessage(); # TODO: DA DEFINIRE COSA FARE IN CASO DI ECCEZIONI
            return false;
        } finally {
            $db->close();
        }
    }

    function convert_date($timestamp){
            $date = date('d-m-y  H:i', strtotime($timestamp)); // H: 24h format - h: 12h format !
            return $date;

    }

    function retrieve_similar_books($id, $genre){
        $db = database_connection();
        $rows = $db->query("SELECT DISTINCT author, cover, title, book_id
                                    FROM Books
                                    WHERE book_id <> '$id' AND genre = '$genre' ORDER BY RAND() LIMIT 3");
        $data = array();
        try{
            if($rows){
                foreach ($rows as $row){
                    $data[] = $row;
                }
            }
            else throw new Exception("query error");
        } catch(Exception $e){
            $e->getMessage();
            $data = null;
            ######### TODO: DA DEFINIRE COSA FARE IN CASO DI ECCEZIONI
        } finally {
            $db->close();
            return $data;
        }
    }

    ?>
</body>
</html>
