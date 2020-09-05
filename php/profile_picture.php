<?php
    require_once "top.php";
    require_once "db.inc.php";

    if(!isset($_SESSION['email'])){
        header("Location: home.php");
        die;
    }

    $email = $_SESSION['email'];

    if(isset($_FILES['file'])){
        $profile_img = time() . '_' . $_FILES['file']['name']; // <----- questo va inserito nel database
        $path = "../images/users/";
        $target = $path . $profile_img;

        try{
            $uploaded =  move_uploaded_file($_FILES['file']['tmp_name'], $target);

            if($uploaded){
                if(update_profile_picture($email, $target)){
                    $response = array("success" => 1, "flash_message" => "image updated correctly", "path" => $target);
                    echo json_encode($response);

                } else throw new Exception("error database");
            } else throw new Exception("img is not uploaded correctly");
        } catch (Exception $e){
            $response = array("success" => 0, "flash_message" => $e->getMessage());
            echo json_encode($response);
        }
    }

    if(isset($_POST['remove_photo'])){
        $path_default_photo = "../images/users/default_profile.png";
        try{
            if(remove_profile_picture($email)){
                $response = array("success" => 1, "flash_message" => "image removed correctly", "path" => $path_default_photo);
                echo json_encode($response);
            }
            else throw new Exception("database error");
        } catch (Exception $e){
            $response = array("success" => 0, "flash_message" => $e->getMessage());
            echo json_encode($response);
        }
    }

function update_profile_picture($email, $profile_img){
    $db = database_connection();
    $sql = "UPDATE Users
            SET image = '$profile_img'
            WHERE email='$email'";

    try{
        if(!$db->query($sql)){
            throw new Exception("query error");
        }
        return true;
    } catch (Exception $e){
        return false;
    } finally {
        $db->close();
    }
}

function remove_profile_picture($email){
    $db = database_connection();
    $sql = "UPDATE Users
            SET image = NULL
            WHERE email='$email'";

    try{
        if(!$db->query($sql)){
            throw new Exception("query error");
        }
        return true;
    } catch (Exception $e){
        return false;
    } finally {
        $db->close();
    }
}
