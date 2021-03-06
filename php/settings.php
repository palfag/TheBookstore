<?php
    /**
     *  @author Paolo Fagioli
     *
     *  Pagina delle impostazioni relative ad un utente
     *  permette di:
     *          - cambiare/rimuovere la foto del profilo
     *          - aggiornare la password
     *          - disiscriversi dal sito
     */
    require_once "include/header.php";
    require_once "include/db.inc.php";
    require_once "functions/common_settings.php";

    $email = $_SESSION['email'];
    $usr_data = retrieve_usr_info($email);
?>

<!doctype html>
<html lang="en">
<head>
    <?php require_once "include/top.html"; ?>
    <link rel="stylesheet" href="../css/settings.css">
    <script src="../javascript/settings.js"></script>
    <title>Settings</title>
</head>
<body>

<?php require_once "navbar.php"; ?>


    <div class="container">

        <div class="column left">
            <h1 id="settings-title">Settings</h1>

            <div class="vertical-menu">
                <div id="picture"><a href="#">change profile picture</a></div>
                <a id="password" href="#">change password</a>
                <a id="unsubscribe" href="#">unsubscribe</a>
            </div>
        </div>

        <div class="column right">
            <div id="user">
                <?php
                if($usr_data['image'] == null){
                    ?>
                    <img id="profile-img" src="../images/users/default_profile.png" alt="default profile photo">
                    <?php
                }
                else {?>
                    <img id="profile-img" src="<?= $usr_data['image'] ?>" alt="user's profile photo">
                <?php }?>
                <h2><?=$usr_data['name'] ?> <?= $usr_data['surname']?></h2>
            </div>



            <div class="form-container hidden" id="photo-form">
                <h2>Change profile picture</h2>
                <hr>
                <form   method="POST" enctype='multipart/form-data'>
                    <div>
                        <label for="file">Choose a Photo</label>
                        <input type="file" id="file" name="file" accept="image/*" required>
                    </div>
                    <div>
                        <input class="submit" id="submit-1" type="submit" name="upload_photo" value="Update">
                    </div>
                </form>
                <button id="remove-photo">remove</button>

                <div id="ajax-photo-response"></div>
            </div>


            <div class="form-container hidden" id="password-form">
                <h2>Change password</h2>
                <hr>
                <form  method="POST">
                    <div>
                        <input class="password" id="old-password" type="password" name="old_password" placeholder="Type your current password..." required >
                    </div>
                    <div>
                        <input class="password" id="new-password" type="password" name="new_password" placeholder="Type the new password..." required>
                    </div>
                    <div>
                        <input class="submit" id="submit-2" type="submit" name="submit" value="Update">
                    </div>
                </form>
                <div id="ajax-password-response"></div>
            </div>


            <div class="form-container hidden" id="unsubscribe-form">
                <form  method="POST">
                    <h2>Unsubscribe</h2>
                    <hr>
                    <div>
                        <h3>Are you sure you want unsubscribe?</h3>
                    </div>

                    <div>
                        <input class="submit" id="unsubscribe-button" type="submit" name="submit" value="Unsubscribe">
                    </div>
                </form>
                <div id="ajax-unsubscribe-response"></div>
            </div>

        </div>
    </div>

    <?php require_once "include/footer.html"; ?>

</body>
</html>
