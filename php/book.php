<?php
/*
 *   Book page
 */
require_once "top.php";
require_once "db.inc.php";
require_once "navbar.php";

// prende le informazioni del libro
if(isset($_GET['id_book'])){
    $id_book = filter_input(INPUT_GET, "id_book",
        FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $book = retreive_book_by_id($id_book);
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
    <script src="../javascript/book.js"></script>
    <script src="../javascript/add_to_cart.js"></script>
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
    ?>
</body>
</html>
