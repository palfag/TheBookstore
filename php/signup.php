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
    <title>Signup</title>
</head>
<body>
    <h1>Sign up</h1>
    <form method="post">
        <div>
            <input type="text" name="name" placeholder="Name" required>
            <input type="text" name="surname" placeholder="Surname" required>
        </div>
        <div>
            <input type="email" name="email" placeholder="Email address" required>
        </div>
        <div>
            <input type="password" name="password" placeholder="New password" required>
        </div>
        <div>
            <input type="submit" name="submit" value="Sign up">
        </div>
    </form>

    <div>Already have an account? <a href="login.php">Login</a></div>

    <?php

        if(isset($_POST["submit"])){
            $email = filter_input(INPUT_POST,"email",
                FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $password = filter_input(INPUT_POST,"password",
                FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $name = filter_input(INPUT_POST,"name",
                FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $surname = filter_input(INPUT_POST,"surname",
                FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            try{
                if(!is_contained($email)){ // se la email non è contenuta nel DB possiamo procedere alla registrazione

                    $hash = password_hash($password, PASSWORD_DEFAULT); //  BCRYPT algorithm

                    $done = register_user($email, $name, $surname, $hash);

                    if($done){
                        $_SESSION["email"] = $email;
                        $_SESSION["flash"] = "Hello".$name." !";
                        header("Location: home.php");
                    }

            }



            } catch(Exception $e){
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
