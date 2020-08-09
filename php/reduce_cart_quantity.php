<?php
require_once "top.php";
require_once "db.inc.php";
require_once "badge.php";
require_once "update_cart.php";

if(!isset($_SESSION['email']) || !isset($_POST['reduce_cart_quantity'])){
    header("Location: index.php");
    die;
}

$email = $_SESSION['email'];

if(isset($_POST['reduce_cart_quantity'])){
    $book_id = filter_input(INPUT_POST, "reduce_cart_quantity",
        FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if(reduce_cart_quantity($email, $book_id)){
        $data = retreive_number_cart_items($email);
        $total = get_total($email);
        $subtotal = get_subtotal($email, $book_id);

        $_SESSION['badge'] = $data;

        $response = array("success" => 1, "badge_num"=> $data, "subtotal"=>$subtotal, "total"=> $total);
    }
    else $response = array("success" => 0, "error"=> "No data found");

    echo json_encode($response);
}



function reduce_cart_quantity($user, $item){
    $db = database_connection();
    $sql = "DELETE FROM Cart where user='$user' AND item='$item' LIMIT 1";
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

function get_subtotal($email, $item){
    $db = database_connection();
    $sql = "SELECT SUM(price) as subtotal
            FROM Cart JOIN Books on item = book_id
            WHERE user = '$email' and item = '$item'
            Group by user, item";

    $rows = $db->query($sql);

    try{
        if($rows){
            foreach ($rows as $row){
                return $row['subtotal'];
            }
        }
        else throw new Exception("query error");
    } catch(Exception $e){
        $e->getMessage();
        return null;
        ######### TODO: DA DEFINIRE COSA FARE IN CASO DI ECCEZIONI
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
