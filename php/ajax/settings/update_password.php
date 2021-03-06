<?php
/**
 * @author Paolo Fagioli
 *
 * File che si occupa della risposta AJAX
 * Permette l'aggiornamento della password
 */

    require_once "../resources.php";
    require_once "../../functions/common_authentication.php";

    $email = $_SESSION['email'];

    if(isset($_POST['old_password']) && isset($_POST['new_password'])){

        $old = filter_input(INPUT_POST, "old_password",
            FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $new = filter_input(INPUT_POST, "new_password",
            FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    try{
        $hash = retrieve_hash($email);
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
 * Aggiorna la password dell'utente, aggiunge l'hash della password nel database
 * @return bool Ritorna TRUE se la password è aggiornata correttamente, FALSE altrimenti.
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
        $e->getMessage();
        return false;
    } finally {
        $db->close();
    }
}




