<?php
    /**
     *  @author Paolo Fagioli
     *
     *  Pagina principale
     *  permette di:
     *          - ricercare i libri attraverso la searchbar
     *          - scegliere l'ordine in cui vengono visualizzati
     *            per: {titolo, autore, dal prezzo più basso, dal prezzo più alto}
     *          - filtrare la categoria di ricerca (per avere nei risultati solo libri
     *            appartenenti a quella categoria)
     */
    require_once "include/header.php";
    require_once "include/db.inc.php";
    require_once "functions/common_categories.php"
?>

<!doctype html>
<html lang="en">
<head>

    <?php require_once "include/top.html"; ?>
    <link rel="stylesheet" href="../css/home.css">
    <script src="../javascript/home.js"></script>
    <script src="../javascript/addToCart.js"></script>
    <title>Home</title>
</head>
<body>

<?php require_once "navbar.php"; ?>

    <div id="search-box">
        <h1>Search a book</h1>
        <form method="POST">
            <input id="search-bar" type="text" placeholder="There is no friend as loyal as a book.">
            <input id="submit" type="submit" value="Search">

            <label> Sort By:
                <select id="sort-by" name="order">
                    <option value="title" selected>title</option>
                    <option value="author">author</option>
                    <option value="price">Price: Low to High</option>
                    <option value="price DESC">Price: High to Low</option>
                </select>
            </label>
            <br>
            <label> Genres:
                <select id="category" name="order">
                    <option value="all" selected>all</option>
                    <?php
                        $categories = retrieve_categories();
                        if($categories){
                            for($i = 0; $i < count($categories); $i++){
                                $category = $categories[$i];
                                ?>
                                <option value="<?=$category['genre']?>"><?=$category['genre']?></option>
                                <?php
                            }
                        }
                    ?>
                </select>
            </label>
        </form>
    </div>



    <div id="products">
    </div>

    <?php require_once "include/footer.html"; ?>

</body>
</html>