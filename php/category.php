<?php
/**
 *  @author Paolo Fagioli
 *
 *  Pagina di una categoria:
 *  vengono visualizzati tutti i libri che fanno parte di quella categoria/genere
 */

require_once "include/header.php";
require_once "include/db.inc.php";

if(!isset($_GET['category'])){
    header("Location: home.php");
    die;
}

// prende le informazioni del libro
if(isset($_GET['category'])){
    $category = filter_input(INPUT_GET, "category",
        FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $books = retrieve_books_by_category($category);

    if(!$books){
        header("Location: home.php");
        die;
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <?php require_once "include/top.html"; ?>
    <link rel="stylesheet" href="../css/category.css">
    <script src="../javascript/addToCart.js"></script>
    <title><?=$category?></title>
</head>
<body>

<?php require_once "navbar.php"; ?>

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
                        <div class="cover"><a href='book.php?id_book=<?= $book["book_id"] ?>'><img src="<?= $book["cover"] ?>" alt="cover"></a></div>
                        <h1 class="title"><a href='book.php?id_book=<?= $book["book_id"] ?>'> <?= $book["title"] ?></a></h1>
                        <p class="author"><?= $book["author"]?></p>
                        <h3 class = "price"><?= $book["price"] ?>€</h3>
                        <button class="add-to-cart" id="<?=$book["book_id"]?>">add to cart</button>
                    </div>
                <?php
            }
        ?>
    </div>

    <?php require_once "include/footer.html"; ?>

</body>
</html>



<?php

/**
 * Recupera tutti i libri che fanno parte della categoria specificata come parametro
 * @param $category. categoria per cui si vuole selezionare i libri
 * @return array Ritorna un array di libri che appartengono alla categoria scelta
 */
function retrieve_books_by_category($category){
    $db = database_connection();
    $rows = $db->query("SELECT * FROM books WHERE genre='$category'");

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