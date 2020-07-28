<?php
    require_once "top.php";
    require_once "db.inc.php";
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="../javascript/signup.js"  type="text/javascript"></script>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form method="post">
        <div>
            <input type="text" name="email" placeholder="Email address">
        </div>
        <div>
            <input type="password" name="password" placeholder="password">
        </div>
        <div>
            <input type="submit" value="Log in">
        </div>
    </form>

    <div>Not a member yet? <a href="signup.php">Sign up</a></div>


    <?php
        if(isset($_POST["email"]) && isset($_POST["password"])){
            $email = filter_input(INPUT_POST,"email",
                FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $password = filter_input(INPUT_POST,"password",
                FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if(verify_password($email, $password)){
                $_SESSION["email"] = $email;
                echo "perfetto";
                header('Location: home.php');
                exit();
            }
            else{
                echo "Credenziali Errate.";
            }
        }

        # TODO: DA CONTINUARE
        function verify_password($email, $password){
            $db = database_connection();
            $rows = $db->query("SELECT codice FROM nomi WHERE nome = '$email'");

            if($rows){
                ## TROVA QUALCHE RIGA
                foreach ($rows as $row){
                    $real_password = $row["codice"];
                    return $real_password === $password;
                }

            }
            else{
                ## NON HA TROVATO NESSUN UTENTE
                return FALSE;
            }
        }

    ?>

</body>
</html>
