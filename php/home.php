<?php
    require_once "top.php";
    require_once "db.inc.php";
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
    <link rel="icon" type="image/png" href="../images/icons/favicon.png"/>
</head>
<body>

    <div id="search-box">
        <h1>Search a book</h1>
        <form method="POST">
            <input id="search-bar" type="text" placeholder="There is no friend as loyal as a book.">
            <input id="submit" type="submit" value="Search">
        </form>
    </div>



    <div id="products">
    </div>

</body>
</html>
