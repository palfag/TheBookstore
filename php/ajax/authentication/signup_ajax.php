<?php

require_once "../resources.php";
require_once "../../functions/common_authentication.php";

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
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                if(!is_contained($email)){ // se l'email non è contenuta nel DB possiamo procedere alla registrazione

                    $hash = password_hash($password, PASSWORD_DEFAULT); //  BCRYPT algorithm

                    $done = register_user($email, $name, $surname, $hash);

                    if($done){
                        $_SESSION['email'] = $email;
                        //$_SESSION['flash'] = "Hello, ".$name."!";

                        // AJAX RESPONSE
                        $response = array("success" => 1);
                        echo json_encode($response);


                    } else throw new Exception("Server: query error");
                } else throw new Exception("you may be already registered as $email");
            } else throw new Exception("email not valid");
        } catch(Exception $e){
            $response = array("success" => 0, "flash_message" => $e->getMessage());
            echo json_encode($response);
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