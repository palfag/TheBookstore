<?php
    require_once "top.php";
    require_once "db.inc.php";

    if (isset($_POST['submit'])) {
        $email = filter_input(INPUT_POST, "email",
            FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $password = filter_input(INPUT_POST, "password",
            FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        try {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                if (is_contained($email)) {
                    $hash = retreive_hash($email);

                    if (password_verify($password, $hash)) {
                        $_SESSION['email'] = $email;

                        // AJAX RESPONSE
                        $response = array("success" => 1);
                        echo json_encode($response);

                    } else throw new Exception("password is incorrect");
                } else throw new Exception("email does not exist in our databases");
            } else throw new Exception("email not valid");
        } catch (Exception $e) {
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
 * Checks if the given email is contained into the database.
 * @param string $email The email which the user would like to register with.
 * @return bool Returns TRUE if the email is contained into the database, or FALSE otherwise.
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