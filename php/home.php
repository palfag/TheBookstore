<?php
    require_once "top.php";
    require_once "db.inc.php";
    require_once "navbar.php";

    if(!isset($_SESSION['email'])){
        header("Location: index.php");
        die;
    }

    $name = retreive_name($_SESSION['email']);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
</head>
<body>
    <h1>Hello,  <?= $name ?> !</h1>

    <form>
        <input id="search-box" type="text" placeholder="Search a book...">
    </form>

</body>
</html>
