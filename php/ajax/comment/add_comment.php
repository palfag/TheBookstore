<?php
    require_once "../resources.php";

    $email = $_SESSION['email'];

    if (isset($_POST['add_comment'])) {
        $item = filter_input(INPUT_POST, "add_comment",
            FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $text = filter_input(INPUT_POST, "comment",
            FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        try{
            if(add_comment($email, $item, $text)){
                $row = retrieve_comment_just_published($email, $item, $text);
                if($row != null)
                    $response = array("success" => 1, "comment" => $row);
                else throw new Exception("error retrieving comment just published");
            }
            else throw new Exception("error retrieving comment just published");
        } catch(Exception $e){
            $response = array("success" => 0, "error"=> $e->getMessage());
        } finally {
            echo json_encode($response);
        }
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

    function retrieve_comment_just_published($user, $item, $comment){
        $db = database_connection();
        $rows = $db->query("SELECT id, user, comment, name, surname, image
                                  FROM Comments JOIN Users on email = user 
                                  WHERE item = '$item' AND user='$user' AND comment='$comment'
                                  ORDER BY date DESC LIMIT 1");
        try{
            if($rows){
                foreach ($rows as $row){
                    return $row;
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