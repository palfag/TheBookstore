<?php
require_once "top.php";
require_once "db.inc.php";

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
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../javascript/navbar.js"></script>
    <link rel="stylesheet" href="../css/navbar.css">
</head>
<body>
    <nav>

        <div class="logo">
            <h4><span>The</span>Bookstore</h4>
        </div>
        <ul class="nav-options">
            <li><a href="#">Home</a> </li>
            <li><a href="#">Categories</a> </li>
            <li><a href="#"><?= $name?></a> </li>
            <li><a href="logout.php">Logout</a> </li>
        </ul>

        <div id="burger-menu" class="burger-menu">
            <div></div>
            <div></div>
            <div></div>
        </div>

    </nav>

    <?php

    function retreive_name($email){
        $db = database_connection();
        $rows = $db->query("SELECT name FROM users WHERE email = '$email'");

        try{
            if($rows){
                foreach ($rows as $row){
                    return $row['name'];
                } throw new Exception("user not found");
            }
            else throw new Exception("query error");
        } catch(Exception $e){
            ######### TODO: DA DEFINIRE COSA FARE IN CASO DI ECCEZIONI
        } finally {
            $db->close();
        }
    }

    function search_book($book){
        $db = database_connection();
        # TODO
    }

    ?>
</body>
</html>