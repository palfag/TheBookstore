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
    $cover = $book['cover'];
    $title = $book['title'];
    $genre = $book['genre'];
    $author = $book['author'];
    $year = $book['published_year'];
    $price = $book['price'];
    $trama = $book['trama'];
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
</head>
<body>

    <div class="row">
        <div class="column left">
            <img id="cover" src="<?= $cover ?>">
        </div>
        <div class="column right">
                <h1 id="title"><?= $title ?></h1>
                <h3 id="author"> <?= $author ?></h3>
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
                <h2>Comments</h2>
        </div>
    </div>


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
    ?>
</body>
</html>
