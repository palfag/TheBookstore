<?php
/**
 * @author Paolo Fagioli
 *
 * File che si occupa della risposta AJAX
 * Permette la rimozione di un articolo dalla wishlist
 */

    require_once "../resources.php";

    $email = $_SESSION['email'];

    if(isset($_POST['remove_wishlist'])){
        $book_id = filter_input(INPUT_POST, "remove_wishlist",
            FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if(remove_wishlist($email, $book_id)){
            $response = array("success" => 1,);
        }
        else $response = array("success" => 0, "error"=> "Problem deleting item from wishlist");

        echo json_encode($response);
    }


/**
 * Rimuove un articolo dalla wishlist dell'utente loggato
 * @param $user utente loggato
 * @param $item articolo da rimuovere
 * @return bool Ritorna TRUE se l'articolo è stato rimosso, FALSE altrimenti
 */
function remove_wishlist($user, $item){
    $db = database_connection();
    $sql = "DELETE FROM Wishlist where user='$user' AND item='$item'";
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