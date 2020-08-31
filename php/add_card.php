<?php
    require_once "top.php";
    require_once "db.inc.php";

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    die;
}

$email = $_SESSION['email'];

if (isset($_POST['add_card']) || isset($_POST['update_card'])) {
    $card_holder = filter_input(INPUT_POST, "card_holder",
        FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $card_number = filter_input(INPUT_POST, "card_number",
        FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $expiry_date = filter_input(INPUT_POST, "expiry_date",
        FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $cvc = filter_input(INPUT_POST, "cvc",
        FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $type = filter_input(INPUT_POST, "type",
        FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    try{
        if(add_card($email, $card_holder, $card_number, $expiry_date, $cvc, $type)){
                $response = array("success" => 1, "message"=>"payment method update correctly");
        }
        else throw new Exception("error updating card payments");
    } catch(Exception $e){
        $response = array("success" => 0, "error"=> $e->getMessage());
    } finally {
        echo json_encode($response);
    }
}

function add_card($user, $card_holder, $card_number, $expiry_date, $cvc, $type){
    $db = database_connection();

    $sql = "INSERT INTO Payments(user, card_number, card_type, expiry_date, cvv, card_holder)
                values('$user', '$card_number', '$type', '$expiry_date', $cvc, '$card_holder')
                ON DUPLICATE KEY UPDATE card_number='$card_number', card_holder = '$card_holder', expiry_date='$expiry_date',
                                        cvv='$cvc', card_type='$type'";
    try {
        if (!$db->query($sql)) {
            throw new Exception("query error");
        }
        return true;
    } catch (Exception $e) {
        $e->getMessage(); # TODO: DA DEFINIRE COSA FARE IN CASO DI ECCEZIONI
        return false;
    } finally {
        $db->close();
    }
}