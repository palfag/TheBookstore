<?php
    require_once "top.php";
    require_once "db.inc.php";
    require_once "badge.php";

    if(!isset($_SESSION['email']) || !isset($_POST['add_to_cart'])){
        header("Location: index.php");
        die;
    }

    $email = $_SESSION['email'];

    if(isset($_POST['add_to_cart'])){
        $book_id = filter_input(INPUT_POST, "add_to_cart",
            FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if(add_to_cart($email, $book_id)){
            $data = retreive_number_cart_items($email);
            $_SESSION['badge'] = $data;
            $response = array("success" => 1, "badge_num"=> $data);
        }
        else $response = array("success" => 0, "error"=> "No data found");

        echo json_encode($response);
    }



    function add_to_cart($user, $item){
        $db = database_connection();
        $sql = "INSERT INTO Cart(user, item) VALUES ('$user', '$item')";
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
