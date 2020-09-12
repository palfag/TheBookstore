<?php
/**
 * @author Paolo Fagioli
 *
 * File che si occupa della risposta AJAX
 * Rimuove un articolo dal carrello dell'utente autenticato
 */

    require_once "../resources.php";
    require_once "../../functions/common_cart.php";


    $email = $_SESSION['email'];

    if(isset($_POST['remove_from_cart'])){
        $book_id = filter_input(INPUT_POST, "remove_from_cart",
            FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if(remove_from_cart($email, $book_id)){
            $data = retrieve_number_cart_items($email);
            $total = get_total($email);

            $_SESSION['badge'] = $data;
            $response = array("success" => 1, "badge_num"=> $data, "total"=> $total);
        }
        else $response = array("success" => 0, "error"=> "No data found");

        echo json_encode($response);
    }


/**
 * Rimuove l'articolo specificato dal carrello dell'utente
 * @param $user. utente loggato
 * @param $item. articolo da rimuovere
 * @return bool Ritorna TRUE se l'articolo è correttamente eliminato, FALSE altrimenti
 */
function remove_from_cart($user, $item){
    $db = database_connection();
    $sql = "DELETE FROM Cart where user='$user' AND item='$item'";
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
