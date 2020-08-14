<?php


    require_once "top.php";
    require_once "db.inc.php";

    if (!isset($_SESSION['email'])) {
        header("Location: home.php");
        die;
    }

    $email = $_SESSION['email'];

    if(isset($_POST['unsubscribe'])){
        // elimino user dal db
        try{
            if(delete_user($email)){
                session_unset(); # flushes out session data
                session_destroy();
                $response = array("success" => 1, "flash_message" => "user correctly deleted");
                echo json_encode($response);
            }
            else throw new Exception("error deleting user from db");
            // effettuo il logout
        }catch (Exception $e){
            $response = array("success" => 0, "flash_message" => $e->getMessage());
            echo json_encode($response);
        }
    }


/**
 * Deletes user, remove user row from the database
 * @param $email
 * @return bool Returns TRUE if user is deleted correctly, or FALSE otherwise.
 */
function delete_user($email){
    $db = database_connection();
    $sql = "DELETE FROM Users where email='$email'";
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
