<?php
/**
 * @author Paolo Fagioli
 *
 * File che si occupa della risposta AJAX
 * Permette di eliminare un commento
 */
    require_once "../resources.php";

    $email = $_SESSION['email'];

    if(isset($_POST['delete_comment'])){
        $comment_id = filter_input(INPUT_POST, "delete_comment",
            FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if(delete_comment($comment_id)){
            $response = array("success" => 1);
        }
        else $response = array("success" => 0, "error"=> "Error deleting comment");

        echo json_encode($response);
    }

/**
 * Elimina, il commento specificato, dal database
 * @param $comment_id. id del commento da eliminare
 * @return bool Ritorna TRUE se il commento è stato correttamente eliminato, FALSE altrimenti
 */
function delete_comment($comment_id){
    $db = database_connection();
    $sql = "DELETE FROM Comments where id ='$comment_id'"; // in teoria se metto un id fasullo comunque ritorna true, quindi non saprei se gestire questo problema
    try{
        if(!$db->query($sql)){
            throw new Exception("query error");
        }
        return true;
    } catch (Exception $e){
        $e->getMessage(); # TODO: DA DEFINIRE COSA FARE IN CASO DI ECCEZIONI
        return false;
    } finally {
        $db->close();
    }
}
