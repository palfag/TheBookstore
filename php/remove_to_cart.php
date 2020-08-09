<?php
require_once "top.php";
require_once "db.inc.php";
require_once "badge.php";
require_once "update_cart.php";

if(!isset($_SESSION['email']) || !isset($_POST['remove_to_cart'])){
    header("Location: index.php");
    die;
}

$email = $_SESSION['email'];

if(isset($_POST['remove_to_cart'])){
    $book_id = filter_input(INPUT_POST, "remove_to_cart",
        FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if(remove_to_cart($email, $book_id)){
        $data = retreive_number_cart_items($email);
        $total = get_total($email);

        $_SESSION['badge'] = $data;
        $response = array("success" => 1, "badge_num"=> $data, "total"=> $total);
    }
    else $response = array("success" => 0, "error"=> "No data found");

    echo json_encode($response);
}



function remove_to_cart($user, $item){
    $db = database_connection();
    $sql = "DELETE FROM Cart where user='$user' AND item='$item'";
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

function get_total($email){
    $items = update_cart($email);
    $total = 0;
    for ($i = 0; $i < count($items); $i++) {
        $item = $items[$i];
        $total += (double)$item['subtotal'];
    }
    /* non penso sia necessario... ma perché no ahah*/
    $total = sprintf('%0.2f', round($total, 2));
    return $total;
}
