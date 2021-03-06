<?php
/**
 * @author Paolo Fagioli
 *
 * File che si occupa della risposta AJAX
 * Permette di modificare (-1) la quantità di un articolo nel carrello
 */
    require_once "../resources.php";
    require_once "../../functions/common_cart.php";

    $email = $_SESSION['email'];

    if(isset($_POST['reduce_cart_quantity'])){
        $book_id = filter_input(INPUT_POST, "reduce_cart_quantity",
            FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if(reduce_cart_quantity($email, $book_id)){
            $data = retrieve_number_cart_items($email);
            $total = get_total($email);
            $subtotal = get_subtotal($email, $book_id);

            $_SESSION['badge'] = $data;

            $response = array("success" => 1, "badge_num"=> $data, "subtotal"=>$subtotal, "total"=> $total);
        }
        else $response = array("success" => 0, "error"=> "error reducing quantity");

        echo json_encode($response);
    }


/**
 * Riduce la quantità di un articolo presente nel carrello dell'utente
 * @param $user. utente loggato
 * @param $item. articolo da ridurre in quantità
 * @return bool Ritorna TRUE se l'articolo viene ridotto in termini di quantità, FALSE altrimenti
 */
function reduce_cart_quantity($user, $item){
    $db = database_connection();
    $sql = "DELETE FROM Cart where user='$user' AND item='$item' LIMIT 1";
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