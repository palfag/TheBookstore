<?php
/**
 * @author Paolo Fagioli
 *
 * File che si occupa della risposta AJAX
 * Permette l'inserimento di un articolo in wishlist
 */

    require_once "../resources.php";

    $email = $_SESSION['email'];

    if(isset($_POST['insert_wishlist'])){
        $book_id = filter_input(INPUT_POST, "insert_wishlist",
            FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if(insert_wishlist($email, $book_id)){
            $response = array("success" => 1);
        }
        else $response = array("success" => 0, "error"=> "Problem inserting item in wishlist");

        echo json_encode($response);
    }

/**
 * Inserisce un articolo nella wishlist dell'utente loggato
 * @param $user utente loggato
 * @param $item articolo da aggiungere
 * @return bool Ritorna TRUE se l'articolo è stato aggiunto, FALSE altrimenti
 */
function insert_wishlist($user, $item){
    $db = database_connection();
    $sql = "INSERT INTO Wishlist(user, item) VALUES ('$user', '$item')";
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