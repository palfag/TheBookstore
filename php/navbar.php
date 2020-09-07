<?php
    require_once "include/header.php";
    require_once "include/db.inc.php";
    require_once "functions/common_cart.php";

    if(!isset($_SESSION['email'])){
        header("Location: index.php");
        die;
    }

    if(!isset($_SESSION['badge'])){
        $_SESSION['badge'] = retrieve_number_cart_items($_SESSION['email']);
    }
    $badge_num = $_SESSION['badge'];

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
            <h4><a href="home.php"><img id="logo-img" src="../images/icons/favicon.png"><span>The</span>Bookstore</a></h4>
        </div>
        <ul class="nav-options">
            <li>
                <div class="dropdown">
                    <button class="dropbtn">Categories</button>
                    <div class="dropdown-content"></div>
                </div>
            </li>
            <li>
                <a class="notification" href="cart.php">Cart</a> <span class="badge"><?= $badge_num ?></span>
            </li>
            <li><a href="profile.php"><?= $name ?></a> </li>
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
    ?>
</body>
</html>
