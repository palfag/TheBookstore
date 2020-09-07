<?php
require_once "../resources.php";
require_once "../../functions/common_cart.php";

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    die;
}

$email = $_SESSION['email'];


if(isset($_POST['add_purchase'])){
    $hashmap = $_POST['add_purchase'];

       if(add_purchase($email, $hashmap)){
           if(remove_all_from_cart($email)){
               $data = 0;
               $_SESSION['badge'] = $data;
               $response = array("success" => 1, "badge_num"=> $data);
           }
       }
       else $response = array("success" => 0, "error"=> "problem during the purchase");

        echo json_encode($response);
}

function add_purchase($user, $items){
    $db = database_connection();

    // RETRIEVE NEXT ID
        $sql1 = "SELECT MAX(id) + 1 as next FROM Purchases";

        $rows = $db->query($sql1);

        if($rows){
            foreach ($rows as $row){
                $max = $row;
            }
        }

        if($max['next'] == null){ // se uguale a null
            $next_id = 1;
        }

        else $next_id = $max['next'];
    // RETRIEVE NEXT ID ENDS

    // ADDS ITEM ON PURCHASE
    try {
        foreach ($items as $item => $quantity){
            $sql2 = "INSERT INTO Purchases(id, user, item, quantity)
                     VALUES($next_id, '$user', $item, $quantity)";

            if (!$db->query($sql2)) {
                throw new Exception("query error");
            }
        }
        return true;
    } catch (Exception $e) {
        $e->getMessage(); # TODO: DA DEFINIRE COSA FARE IN CASO DI ECCEZIONI
        return false;
    } finally {
        $db->close();
    }
}
