<?php
    require_once "navbar.php";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <script src="../javascript/home.js"></script>
    <link rel="stylesheet" href="../css/home.css">
    <script src="../javascript/navbar.js"></script>
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
