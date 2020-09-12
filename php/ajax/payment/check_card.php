<?php
/**
 * @author Paolo Fagioli
 *
 * File che si occupa della risposta AJAX
 * Permette di controllare se l'utente ha definito precedentemente un metodo di pagamento,
 * in caso contrario non si potrà procedere con l'acquisto.
 */
    require_once "../resources.php";

    $email = $_SESSION['email'];

    if (isset($_POST['check_card'])) {

        try{
            if(has_card($email)){
                $response = array("success" => 1);
            }
            else throw new Exception("add a card in the payment area.");
        } catch(Exception $e){
            $response = array("success" => 0, "error"=> $e->getMessage());
        } finally {
            echo json_encode($response);
        }
    }

/**
 * Verifica se l'utente ha definito un metodo di pagamento
 * @param $user . Utente per cui si vuole controllare il metodo di pagamento
 * @return bool Ritorna TRUE se l'utente ha una carta salvata nel proprio account, FALSE altrimenti
 */
function has_card($user){
    $db = database_connection();
    $rows = $db->query("SELECT * FROM Payments where user='$user'");
    $res = false;

    if($rows){
        if($rows->num_rows == 1)
            $res = true;
    }

    $db->close();
    return $res;
}

