<?php
    require_once "include/header.php";
    require_once "include/db.inc.php";
    require_once "navbar.php";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link rel="stylesheet" href="../css/home.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../javascript/navbar.js"></script>
    <script src="../javascript/home.js"></script>
    <script src="../javascript/addToCart.js"></script>
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="icon" type="image/png" href="../images/icons/favicon.png"/>
</head>
<body>

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

    <?php require_once "include/footer.php"; ?>

</body>
</html>

<?php
    function retrieve_categories(){
        $db = database_connection();
        $rows = $db->query("SELECT genre FROM BookGenres ORDER BY genre");
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