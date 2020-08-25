<?php
require_once "top.php";
require_once "db.inc.php";


if(!isset($_SESSION['email']) || !isset($_POST['delete_comment'])){
    header("Location: index.php");
    die;
}

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
