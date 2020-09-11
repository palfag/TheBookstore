<?php
/**
 * @author Paolo Fagioli
 *
 * File che si occupa della risposta AJAX
 * Permette di aggiungere un articolo al carrello
 */
    require_once "../resources.php";
    require_once "../../functions/common_cart.php";


    $email = $_SESSION['email'];

    if(isset($_POST['add_to_cart'])){
        $book_id = filter_input(INPUT_POST, "add_to_cart",
            FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if(add_to_cart($email, $book_id)){
            $data = retrieve_number_cart_items($email);
            $_SESSION['badge'] = $data;
            $response = array("success" => 1, "badge_num"=> $data);
        }
        else $response = array("success" => 0, "error"=> "Problem adding item");

        echo json_encode($response);
    }