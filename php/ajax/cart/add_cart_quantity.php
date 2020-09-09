<?php
require_once "../resources.php";
require_once "../../functions/common_cart.php";

if(!isset($_SESSION['email']) || !isset($_POST['add_cart_quantity'])){
    header("Location: index.php");
    die;
}

$email = $_SESSION['email'];

if(isset($_POST['add_cart_quantity'])){
    $book_id = filter_input(INPUT_POST, "add_cart_quantity",
        FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if(add_to_cart($email, $book_id)){
        $data = retrieve_number_cart_items($email);
        $total = get_total($email);
        $subtotal = get_subtotal($email, $book_id);

        $_SESSION['badge'] = $data;

        $response = array("success" => 1, "badge_num"=> $data, "subtotal"=>$subtotal, "total"=> $total);
    }
    else $response = array("success" => 0, "error"=> "No data found");

    echo json_encode($response);
}