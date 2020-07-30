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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../javascript/signup.js"  type="text/javascript"></script>
    <link rel="stylesheet" href="../style/check_input.css">
    <title>Signup</title>
</head>
<body>
    <h1>Sign up</h1>

    <form method="POST">
        <div>
            <input id="name" type="text" name="name" placeholder="Name" required>
            <input id="surname" type="text" name="surname" placeholder="Surname" required>
        </div>
        <div>
            <input id="email" type="text" name="email" placeholder="Email address" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,63}$" required >
        </div>
        <div>
            <input id="password" type="password" name="password" placeholder="New password" required>
        </div>
        <div>
            <input id="signup_btn" type="submit" name="submit" value="Sign up">
        </div>
    </form>

    <div>Already have an account? <a href="index.php">Login</a></div>

    <?php

        if(isset($_POST['submit'])){
            $email = filter_input(INPUT_POST,"email",
                FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $password = filter_input(INPUT_POST,"password",
                FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $name = filter_input(INPUT_POST,"name",
                FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $surname = filter_input(INPUT_POST,"surname",
                FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            try{
                if(!is_contained($email)){ // se l'email non è contenuta nel DB possiamo procedere alla registrazione

                    $hash = password_hash($password, PASSWORD_DEFAULT); //  BCRYPT algorithm

                    $done = register_user($email, $name, $surname, $hash);

                    if($done){
                        $_SESSION["email"] = $email;
                        $_SESSION["flash"] = "Hello".$name." !";
                        header("Location: home.php");
                    }

            } else throw new Exception("you may be already registered as $email");
            } catch(Exception $e){
                ?>
                <p> <?= $e->getMessage() . "<br>" . "try to log in" ?></p>
                <?php
                ####### # TODO: DA DEFINIRE COSA FARE IN CASO DI ECCEZIONI
            }

        }


        /**
         * Checks if the given email is contained in the database.
         * @param string $email The email which the user would like to register with.
         * @return bool Returns TRUE if the email is contained in the database, or FALSE otherwise.
         */
        function is_contained($email){
            $db = database_connection();
            $rows = $db->query("SELECT email FROM users WHERE email = '$email'");

            try{
                if($rows){
                    foreach ($rows as $row){
                        if($row["email"] == $email){
                            return true;
                        }
                    } return false;
                }
                else throw new Exception("query error");
            } catch(Exception $e){
                $e->getMessage();
                ######### TODO: DA DEFINIRE COSA FARE IN CASO DI ECCEZIONI
            } finally {
                $db->close();
            }
        }

        /**
         * Registers the new user, adds user's information into the database
         * @return bool Returns TRUE if the given information is added correctly, or FALSE otherwise.
         */
        function register_user($email, $name, $surname, $hash){

            $db = database_connection();
            $sql = "INSERT INTO users(email, name, surname, pwd, image) VALUES ('$email', '$name', '$surname', '$hash', null)";
            try{

                if(!$db->query($sql)){
                    throw new Exception("query error");
                }
                return true;
            } catch (Exception $e){
                $e->getMessage(); # TODO: DA DEFINIRE COSA FARE IN CASO DI ECCEZIONI
                return false;
            } finally {
                $db->close();
            }
        }
    ?>
</body>
</html>
