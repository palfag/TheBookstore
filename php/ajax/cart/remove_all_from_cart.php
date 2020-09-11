<?php
/**
 * @author Paolo Fagioli
 *
 * File che si occupa della risposta AJAX
 * Permette di svuotare il carrello
 */
    require_once "../resources.php";
    require_once "../../functions/common_cart.php";

    $email = $_SESSION['email'];

    if(isset($_POST['remove_all_from_cart'])){

        if(remove_all_from_cart($email)){
            $data = 0;
            $total = 0.00;

            $_SESSION['badge'] = $data;
            $response = array("success" => 1, "badge_num"=> $data, "total"=> $total);
        }
        else $response = array("success" => 0, "error"=> "No data found");

        echo json_encode($response);
    }
