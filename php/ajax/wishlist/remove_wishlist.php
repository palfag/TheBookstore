<?php
    require_once "../resources.php";

    if(!isset($_SESSION['email'])){
        header("Location: index.php");
        die;
    }

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

    function remove_wishlist($user, $item){
        $db = database_connection();
        $sql = "DELETE FROM Wishlist where user='$user' AND item='$item'";
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