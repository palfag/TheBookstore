<?php
require_once "top.php";
require_once "db.inc.php";
require_once "navbar.php";

if(!isset($_SESSION['email'])){
    header("Location: index.php");
    die;
}

    $email = $_SESSION['email'];
    $usr_data = retreive_usr_info($email);

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
    <title>Profile</title>
</head>
<body>
    <div class="row">
        <div class="column left">
                <div>
                    <?php
                    if($usr_data['image'] == null){
                        ?>
                        <img id="cover" src="../images/users/default_profile.png">
                        <?php
                    }
                    else {?>
                        <img id="cover" src="<?= $usr_data['image'] ?>">
                    <?php }?>
                    <h1 id="title"><?= $usr_data['name'] ?> <?= $usr_data['surname'] ?></h1>

                    <div id="settings">
                        <div >
                            <button class="settings-button">Edit photo</button>
                        </div>
                        <div>
                            <button class="settings-button">Edit password</button>
                        </div>
                        <div>
                            <button class="settings-button">Unsubscribe</button>
                        </div>
                    </div>


                </div>
                   <!-- <input type="file" id="file" accept="image/*" required> -->


        </div>
        <div class="column right">


            <h2>Wishlist</h2>
            <h2>Orders (10)</h2>
        </div>
    </div>

    <?php

    function retreive_usr_info($email){
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
    ?>
</body>
</html>
