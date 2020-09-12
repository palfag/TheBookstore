<?php
/**
 * @author Paolo Fagioli
 *
 * File che si occupa della risposta AJAX
 * Permette di rimuovere il metodo di pagamento precedentemente definito
 */
    require_once "../resources.php";

    if (!isset($_SESSION['email'])) {
        header("Location: index.php");
        die;
    }

    $email = $_SESSION['email'];

    if (isset($_POST['remove_card'])) {

        try{
            if(remove_card($email)){
                $response = array("success" => 1, "message"=>"payment method deleted correctly");
            }
            else throw new Exception("error deleting card payments");
        } catch(Exception $e){
            $response = array("success" => 0, "error"=> $e->getMessage());
        } finally {
            echo json_encode($response);
        }
    }

/**
 * Rimuove la carta dal database
 * @param $user . utente loggato
 * @return bool Ritorna TRUE se la carta è rimossa correttamente, FALSE altrimenti
 */
function remove_card($user){
    $db = database_connection();
    $sql = "DELETE FROM Payments WHERE user='$user'";

    try {
        if (!$db->query($sql)) {
            throw new Exception("query error");
        }
        return true;
    } catch (Exception $e) {
        $e->getMessage();
        return false;
    } finally {
        $db->close();
    }
}
