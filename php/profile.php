<?php
require_once "top.php";
require_once "db.inc.php";
require_once "navbar.php";

if(!isset($_SESSION['email'])){
    header("Location: index.php");
    die;
}

    $email = $_SESSION['email'];
    $usr_data = retrieve_usr_info($email);
    $wishlist = retrieve_wishlist($email);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/profile.css">
    <script src="../javascript/profile.js"></script>
    <link rel="icon" type="image/png" href="../images/icons/favicon.png"/>
    <title>Profile</title>
</head>
<body>
    <div class="row">
        <div class="column left">
                <div>
                    <?php
                    if($usr_data['image'] == null){
                        ?>
                        <img id="profile-img" src="../images/users/default_profile.png">
                        <?php
                    }
                    else {?>
                        <img id="profile-img" src="<?= $usr_data['image'] ?>">
                    <?php }?>
                    <h1 id="title"><?= $usr_data['name'] ?> <?= $usr_data['surname'] ?></h1>

                    <div id="settings">
                            <button class="settings-button"><a href="settings.php">Settings</a></button>
                    </div>


                </div>


        </div>
        <div class="column right">

            <div>
                <h2>Wallet: 30$</h2>
                <h2>Total Orders: 10</h2>
                <h2>Wishlist</h2>
                <?php
                if(count($wishlist) == 0){
                ?>
                    <div>There is no items in your wishlist</div>
                <?php
                }
                else{
                ?>
                    <div class="wishlist">
                        <?php
                            for($i = 0; $i < count($wishlist); $i++){
                                $book = $wishlist[$i];
                        ?>

                        <div class="book">
                            <div class="cover">
                                <a href='book.php?id_book=<?= $book["book_id"] ?>'><img src="<?= $book["cover"] ?>"></a></div>
                            <a href='book.php?id_book=<?= $book["book_id"] ?>'><h1 class="title"> <?= $book["title"] ?></h1></a>

                            <p class="author"><?= $book["author"]?></p>
                        </div>

                        <?php
                        }}
                        ?>
                    </div>
            </div>



        </div>
    </div>

    <?php

    function retrieve_usr_info($email){
        $db = database_connection();
        $rows = $db->query("SELECT name, surname, image FROM users WHERE email = '$email'");

        try{
            if($rows){
                foreach ($rows as $row){
                    return $row;
                } throw new Exception("user not found");
            }
            else throw new Exception("query error");
        } catch(Exception $e){
            ######### TODO: DA DEFINIRE COSA FARE IN CASO DI ECCEZIONI
        } finally {
            $db->close();
        }
    }


    function retrieve_wishlist($user){
        $db = database_connection();
        $rows = $db->query("SELECT * 
                                  FROM wishlist JOIN books ON book_id = item
                                  WHERE  user = '$user'
                                  ORDER BY title");
        $data = array();
        try{
            if($rows){
                foreach ($rows as $row){
                    $data[] = $row;
                }
                return $data;
            }
            else throw new Exception("query error");
        } catch(Exception $e){
            $e->getMessage();
            ######### TODO: DA DEFINIRE COSA FARE IN CASO DI ECCEZIONI
        } finally {
            $db->close();
        }
    }
    ?>
</body>
</html>
