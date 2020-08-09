<?php
require_once "top.php";
require_once "db.inc.php";
require_once "badge.php";
require_once "update_cart.php";

if(!isset($_SESSION['email']) || !isset($_POST['remove_all_from_cart'])){
    header("Location: index.php");
    die;
}

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


function remove_all_from_cart($user){
    $db = database_connection();
    $sql = "DELETE FROM Cart where user='$user'";
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
