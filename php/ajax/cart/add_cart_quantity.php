<?php
/**
 * @author Paolo Fagioli
 *
 * File che si occupa della risposta AJAX
 * Permette di modificare (+1) la quantità di un articolo nel carrello
 */
    require_once "../resources.php";
    require_once "../../functions/common_cart.php";


    $email = $_SESSION['email'];

    if(isset($_POST['add_cart_quantity'])){
        $book_id = filter_input(INPUT_POST, "add_cart_quantity",
            FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if(add_to_cart($email, $book_id)){
            $data = retrieve_number_cart_items($email);
            $total = get_total($email);
            $subtotal = get_subtotal($email, $book_id);

            $_SESSION['badge'] = $data;

            $response = array("success" => 1, "badge_num"=> $data, "subtotal"=>$subtotal, "total"=> $total);
        }
        else $response = array("success" => 0, "error"=> "error adding quantity");

        echo json_encode($response);
    }