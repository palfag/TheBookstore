<?php
/*
 *   Category page
 */
require_once "include/header.php";
require_once "include/db.inc.php";
require_once "navbar.php";

if(!isset($_GET['category'])){
    header("Location: index.php");
    die;
}

// prende le informazioni del libro
if(isset($_GET['category'])){
    $category = filter_input(INPUT_GET, "category",
        FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $books = retreive_books_by_category($category);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/category.css">
    <script src="../javascript/wishlist.js"></script>
    <script src="../javascript/addToCart.js"></script>
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="icon" type="image/png" href="../images/icons/favicon.png"/>
    <title>category</title>
</head>
<body>

<h1 id="category-title"><?= $category ?></h1>

    <div id="products">
        <?php
            for($i = 0; $i < count($books); $i++){
                $book = $books[$i];

                if($i % 3 == 0){
                    ?>
                    <br>
                    <?php
                }

                ?>
                    <div class="book">
                        <div class="cover"><a href='book.php?id_book=<?= $book["book_id"] ?>'><img src="<?= $book["cover"] ?>"></a></div>
                        <h1 class="title"><a href='book.php?id_book=<?= $book["book_id"] ?>'> <?= $book["title"] ?></a></h1>
                        <p class="author"><?= $book["author"]?></p>
                        <h3 class = "price"><?= $book["price"] ?>€</h3>
                        <button class="add-to-cart" id="<?=$book["book_id"]?>">add to cart</button>
                    </div>
                <?php
            }
        ?>
    </div>

    <?php require_once "include/footer.php"; ?>

</body>
</html>



<?php

    function retreive_books_by_category($category){
        $db = database_connection();
        $rows = $db->query("SELECT * FROM books WHERE genre='$category'");

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
?>