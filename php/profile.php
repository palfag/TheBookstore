<?php
    /**
     *  @author Paolo Fagioli
     *
     *  Pagina personale dell'utente
     *  Vi sono due possibilità,
     *  se l'utente visualizza il proprio profilo appariranno:
     *          - Wishlist (elenco di tutti i libri che ne fanno parte)
     *          - Purchased (elenco di tutti i libri comprati)
     *          - link per la pagina del metodo di pagamento
     *          - link per le impostazioni dell'utente
     *
     * Altrimenti (utente che visualizza la pagina di un altro utente):
     *          - Wishlist dell'utente cercato
     *          - Libri in comune (che entrambi gli utenti hanno aggiunto in wishlist)
     */
    require_once "include/header.php";
    require_once "include/db.inc.php";
    require_once "functions/common_settings.php";

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
        <?php require_once "include/top.html"; ?>
        <link rel="stylesheet" href="../css/profile.css">
        <title><?=$usr_data['name']?>'s Profile</title>
    </head>
    <body>
    <?php require_once "navbar.php"; ?>
        <div class="row">
            <div class="column left">
                    <div>
                        <?php
                        if($usr_data['image'] == null){
                            ?>
                            <img id="profile-img" src="../images/users/default_profile.png" alt="default profile photo">
                            <?php
                        }
                        else {?>
                            <img id="profile-img" src="<?= $usr_data['image'] ?>" alt="user's profile photo">
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
                                    <a href='book.php?id_book=<?= $book["book_id"] ?>'><img src="<?= $book["cover"] ?>" alt="cover"></a></div>
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
                                    <a href='book.php?id_book=<?= $book["book_id"] ?>'><img src="<?= $book["cover"] ?>" alt="cover"></a></div>
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
        <?php require_once "include/footer.html";

    } else{
        // in questo caso non è settato  GET['user'] oppure coincide con $_SESSION['email'] (in questo caso la persona sta accedendo al proprio profilo)
        $usr_data = retrieve_usr_info($email);
        $wishlist = retrieve_wishlist($email);
        $purchased_items = retrieve_purchased_items($email);
?>

<!doctype html>
<html lang="en">
<head>
    <?php require_once "include/top.html"; ?>
    <link rel="stylesheet" href="../css/profile.css">
    <title>Profile</title>
</head>
<body>

<?php require_once "navbar.php"; ?>

    <div class="row">
        <div class="column left">
                <div>
                    <?php
                    if($usr_data['image'] == null){
                        ?>
                        <img id="profile-img" src="../images/users/default_profile.png" alt="default profile photo">
                        <?php
                    }
                    else {?>
                        <img id="profile-img" src="<?= $usr_data['image'] ?>" alt="user's profile photo">
                    <?php }?>
                    <h1 id="title"><?= $usr_data['name'] ?> <?= $usr_data['surname'] ?></h1>

                    <div id="payment">
                        <a class="payment-button" href="payment.php">Payments</a>
                    </div>
                    <div id="settings">
                        <a class="payment-button" href="settings.php">Settings</a>
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
                                <a href='book.php?id_book=<?= $book["book_id"] ?>'><img src="<?= $book["cover"] ?>" alt="cover"></a></div>
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
                                <a href='book.php?id_book=<?= $book["book_id"] ?>'><img src="<?= $book["cover"] ?>" alt="cover"></a></div>
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
    <?php require_once "include/footer.html";

    }?>


    <?php


    function retrieve_wishlist($user){
        $db = database_connection();
        $rows = $db->query("SELECT * 
                                  FROM wishlist JOIN books ON book_id = item
                                  WHERE  user = '$user'
                                  ORDER BY title");
        $data = array();

            if($rows){
                foreach ($rows as $row){
                    $data[] = $row;
                }
            }
            $db->close();
            return $data;
    }

    function retrieve_common_books($usr1, $usr2){
        $db = database_connection();
        $rows = $db->query("SELECT DISTINCT item, author, cover, title, book_id
                                  FROM wishlist JOIN books ON book_id = item
                                  WHERE item IN (SELECT item FROM Wishlist WHERE user ='$usr1') AND
                                        item IN (SELECT item FROM Wishlist WHERE user ='$usr2')
                                  ORDER BY title");
        $data = array();

            if($rows){
                foreach ($rows as $row){
                    $data[] = $row;
                }
            }

            $db->close();
            return $data;
    }


    function retrieve_purchased_items($user){
        $db = database_connection();
        $rows = $db->query("SELECT DISTINCT item, author, cover, title, book_id
                                    FROM Purchases JOIN books ON book_id = item
                                    WHERE user = '$user' ORDER BY title");
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
</body>
</html>
