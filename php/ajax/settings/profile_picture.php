<?php
/**
 * @author Paolo Fagioli
 *
 * File che si occupa della risposta AJAX
 * Permette l'aggiornamento/rimozione della foto del profilo
 *
 * @NB. Si parla di aggiornamento e non inserimento perché all'inizio viene data una foto di default ad ogni utente
 */

    require_once "../resources.php";

    $email = $_SESSION['email'];


    // se è settato $_FILES['file'], l'utente ha caricato una foto e si deve aggiornare la foto profilo

    if(isset($_FILES['file'])){
        $profile_img = time() . '_' . $_FILES['file']['name']; // <----- questo va inserito nel database ... uso la funzione time() per avere id unici
        $path = "../../../images/users/";
        $target = $path . $profile_img;
        $final_path = "../images/users/" . $profile_img;

        try{
            $uploaded =  move_uploaded_file($_FILES['file']['tmp_name'], $target);

            if($uploaded){
                if(update_profile_picture($email, $final_path)){

                    $response = array("success" => 1, "flash_message" => "image updated correctly", "path" => $final_path);
                    echo json_encode($response);

                } else throw new Exception("error database");
            } else throw new Exception("img is not uploaded correctly");
        } catch (Exception $e){
            $response = array("success" => 0, "flash_message" => $e->getMessage());
            echo json_encode($response);
        }
    }

    // se è settato $_POST['remove_photo'], l'utente ha chiesto la rimozione della foto

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


/**
 * Aggiorna la foto profilo dell'utente loggato
 * @param $email utente loggato
 * @param $profile_img foto profilo da aggiornare
 * @return bool Ritorna TRUE se la foto è correttamente aggiornata, FALSE altrimenti
 */
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

/** Rimuove la foto del profilo dell'utente loggato (ritorna quella di default)
 * @param $email utente loggato
 * @return bool Ritorna TRUE se la foto è correttamente rimossa, FALSE altrimenti
 */
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
