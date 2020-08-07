<?php
/*
 *   Category page
 */
require_once "top.php";
require_once "db.inc.php";
require_once "navbar.php";



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
    <script src="../javascript/add_to_cart.js"></script>
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
                        <div class="cover"><img src="<?= $book["cover"] ?>"></div>
                        <h1 class="title"><a href='book.php?id_book=<?= $book["book_id"] ?>'> <?= $book["title"] ?></a></h1>
                        <p class="author"><?= $book["author"]?></p>
                        <h3 class = "price"><?= $book["price"] ?>€</h3>
                        <button class="add-to-cart" id="<?=$book["book_id"]?>">add to cart</button>
                    </div>
                <?php
            }
        ?>
    </div>

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