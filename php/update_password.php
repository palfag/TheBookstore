<?php

    require_once "top.php";
    require_once "db.inc.php";

    if (!isset($_SESSION['email'])) {
        header("Location: home.php");
        die;
    }

    $email = $_SESSION['email'];


    if(isset($_POST['old_password']) && isset($_POST['new_password'])){

        $old = filter_input(INPUT_POST, "old_password",
            FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $new = filter_input(INPUT_POST, "new_password",
            FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    try{
        $hash = retreive_hash($email);
        if (password_verify($old, $hash)) {
            // possiamo procedere ad aggiornare la password
            $new_hash = password_hash($new, PASSWORD_DEFAULT); //  BCRYPT algorithm
            if(update_password($email,$new_hash)){
                $response = array("success" => 1, "flash_message" => "password updated correctly");
                echo json_encode($response);
            }
            else throw new Exception("error updating password");
        }
        else throw new Exception("old password is wrong");
    } catch (Exception $e){
        $response = array("success" => 0, "flash_message" => $e->getMessage());
        echo json_encode($response);
    }
}

    /**
     * Retreives the password hashed from the database.
     * @param string $email The email of the password that we want to recover
     * @return bool Returns password hashed contained into the database.
     */
    function retreive_hash($email){
        $db = database_connection();
        $rows = $db->query("SELECT pwd FROM users WHERE email = '$email'");

        try {
            if ($rows) {
                foreach ($rows as $row) {
                    return $row["pwd"];
                }
                throw new Exception("user is not registered");
            } else throw new Exception("query error");
        } catch (Exception $e) {
            ######### TODO: DA DEFINIRE COSA FARE IN CASO DI ECCEZIONI
        } finally {
            $db->close();
        }
    }



    /**
     * Updates the user's password, adds new hashed password into the database
     * @return bool Returns TRUE if the password is updated correctly, or FALSE otherwise.
     */
    function update_password($email, $new_hash){
        $db = database_connection();
        $sql = "UPDATE Users
                SET pwd = '$new_hash'
                WHERE email='$email'";
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



