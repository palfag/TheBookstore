<?php
/*
 *  THE LOGIN PAGE
 */
    require_once "top.php";
    require_once "db.inc.php";

    // if user already logged will redirect to home.php
    if(isset($_SESSION['email'])){
        header("Location: home.php");
    }
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
            <input type="email" name="email" placeholder="Email address" required>
        </div>
        <div>
            <input type="password" name="password" placeholder="password" required>
        </div>
        <div>
            <input type="submit" name="submit" value="Log in">
        </div>
    </form>

    <div>Not a member yet? <a href="signup.php">Sign up</a></div>


    <?php
        if(isset($_POST["submit"])){
            $email = filter_input(INPUT_POST,"email",
                FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $password = filter_input(INPUT_POST,"password",
                FILTER_SANITIZE_FULL_SPECIAL_CHARS);


            $hash = retreive_hash($email);

            if(password_verify($password,$hash)){
                $_SESSION['email'] = $email;
                header('Location: home.php');
                exit();
            }
            else{
                echo "credentials not valid";
            }
        }



        function retreive_hash($email){
            $db = database_connection();
            $rows = $db->query("SELECT pwd FROM users WHERE email = '$email'");

            try{
                if($rows){
                    foreach ($rows as $row){
                        return $row["pwd"];
                    }
                    throw new Exception("user is not registered");
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
