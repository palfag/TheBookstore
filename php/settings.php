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
    <link rel="stylesheet" href="../css/settings.css">
    <link rel="icon" type="image/png" href="../images/icons/favicon.png"/>
    <script src="../javascript/settings.js"></script>
    <title>Document</title>
</head>
<body>
    <h1 id="settings-title">Settings</h1>

    <div class="container">

        <h2>Edit profile photo</h2>
        <div class="form-container invisible">
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
            </div>
            <form id="photo-form" method="POST" enctype='multipart/form-data'>
                <div>
                    <input type="file" id="file" name="file" accept="image/*" required>
                </div>
                <div>
                    <input class="submit" id="submit-1" type="submit" name="upload_photo" value="Update">
                </div>
            </form>
            <div id="ajax-response"></div>
        </div>


        <h2>Edit password</h2>
        <div class="form-container invisible">
            <form id="password-form" method="POST">
                <div>
                    <input id="old-password" type="password" name="old_password" placeholder="Old address" required >
                </div>
                <div>
                    <input id="new-password" type="password" name="new_password" placeholder="New password" required>
                </div>
                <div>
                    <input class="submit" id="submit-2" type="submit" name="submit" value="Update">
                </div>
            </form>
        </div>


        <button>Unsubscribe</button>
        <h2></h2>
        <div class="form-container invisible">
            <form id="unsubscribe-form" method="POST">
                <div>
                    <h3>Are you sure you want unsubscribe?</h3>
                </div>
                <div>
                    <input class="submit" id="submit-3" type="submit" name="submit" value="Unsubscribe">
                </div>
            </form>
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
