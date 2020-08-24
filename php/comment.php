<?php
    require_once "top.php";
    require_once "db.inc.php";

    $email = $_SESSION['email'];

    if (isset($_POST['add_comment'])) {
        $item = filter_input(INPUT_POST, "add_comment",
            FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $text = filter_input(INPUT_POST, "comment",
            FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if(add_comment($email, $item, $text)){
            $response = array("success" => 1, "text" => $text);
        }
        else $response = array("success" => 0, "error"=> "Problem adding the comment");

        echo json_encode($response);
    }



    function add_comment($user, $item, $comment){
        $db = database_connection();
        $sql = "INSERT INTO Comments(user, item, comment, date) VALUES ('$user', '$item', '$comment', NOW())";
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