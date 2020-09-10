<?php
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

function has_card($user){
    $db = database_connection();

    $sql = "SELECT * FROM Payments where user='$user'";
    try {
        $rows = $db->query($sql);
        if ($rows) {
            if($rows->num_rows == 0)
                throw new Exception("no card connected to this account");
            return true;
        }
        else throw new Exception("query error");
    } catch (Exception $e) {
        $e->getMessage(); # TODO: DA DEFINIRE COSA FARE IN CASO DI ECCEZIONI
        return false;
    } finally {
        $db->close();
    }
}