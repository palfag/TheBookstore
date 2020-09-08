<?php
require_once "include/header.php";
require_once "include/db.inc.php";
require_once "navbar.php";
require_once "functions/common_settings.php";

if(!isset($_SESSION['email'])){
    header("Location: index.php");
    die;
}

    $email = $_SESSION['email'];

    if(isset($_GET['user']) && strcmp($_GET['user'], $email) != 0){
        // entriamo nel profilo di un altro utente
        // dobbiamo nascondere gli ordini e il bottone impostazioni (poiché non possiamo cambiare le impostazioni di altri utenti)
        $user = $_GET['user'];
        $usr_data = retrieve_usr_info($user);
        $wishlist = retrieve_wishlist($user);
        $common = retrieve_common_books($user, $email);
        ?>

    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="../css/profile.css">
        <link rel="stylesheet" href="../css/footer.css">
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
                    </div>


            </div>
            <div class="column right">

                <div>
                    <h2><?= $usr_data['name']?>'s Wishlist</h2>
                    <?php
                    if(count($wishlist) == 0){
                    ?>
                        <div>There is no items in <?= $usr_data['name']?>'s wishlist</div>
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
                    <h2>Both you and <?= $usr_data['name']?></h2>
                    <?php
                    if(count($common) == 0){
                        ?>
                        <div>You and <?= $usr_data['name']?> don't have any book in common</div>
                        <?php
                    }
                    else{
                    ?>
                    <div class="common-books">
                        <?php
                        for($i = 0; $i < count($common); $i++){
                            $book = $common[$i];
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
        <?php require_once "include/footer.php";

    } else{
        // in questo caso non è settato  GET['user'] oppure coincide con $_SESSION['email'] (in questo caso la persona sta accedendo al proprio profilo)
        $usr_data = retrieve_usr_info($email);
        $wishlist = retrieve_wishlist($email);
        $purchased_items = retrieve_purchased_items($email);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="stylesheet" href="../css/footer.css">
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

                    <div id="payment">
                        <button class="payment-button"><a href="payment.php">Payments</a></button>
                    </div>
                    <div id="settings">
                            <button class="settings-button"><a href="settings.php">Settings</a></button>
                    </div>



                </div>


        </div>
        <div class="column right">

            <div>
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
                <h2>Purchased</h2>
                <?php
                if(count($purchased_items) == 0){
                    ?>
                    <p>you haven't bought any books yet</p>
                    <button id="shop-now"><a href="home.php">Shop now</a></button>
                    <?php
                }
                else{
                ?>
                <div class="common-books">
                    <?php
                    for($i = 0; $i < count($purchased_items); $i++){
                        $book = $purchased_items[$i];
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
    <?php require_once "include/footer.php";

    }?>


    <?php


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

    function retrieve_common_books($usr1, $usr2){
        $db = database_connection();
        $rows = $db->query("SELECT DISTINCT item, author, cover, title, book_id
                                  FROM wishlist JOIN books ON book_id = item
                                  WHERE item IN (SELECT item FROM Wishlist WHERE user ='$usr1') AND
                                        item IN (SELECT item FROM Wishlist WHERE user ='$usr2')
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


    function retrieve_purchased_items($user){
        $db = database_connection();
        $rows = $db->query("SELECT DISTINCT item, author, cover, title, book_id
                                    FROM Purchases JOIN books ON book_id = item
                                    WHERE user = '$user' ORDER BY title");
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
