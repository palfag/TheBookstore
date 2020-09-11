<?php
/**
 * @author Paolo Fagioli
 *
 * File che si occupa della risposta AJAX
 * Permette la valutazione di un libro ★★★★★
 */
    require_once "../resources.php";

    $email = $_SESSION['email'];


    if(isset($_POST['rate']) && isset($_POST['item'])){
        $item = filter_input(INPUT_POST, "item",
            FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $rate = filter_input(INPUT_POST, "rate",
            FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $done = add_rate($email, $item, $rate);

        if($done){
            $response = array("success" => 1, "rate"=> $rate);
        }
        else $response = array("success" => 0, "error"=> "Problem adding rate");

        echo json_encode($response);
    }

/**
 * Salva la valutazione dell'utente per un certo libro nel database
 * @return bool Ritorna TRUE se la valutazione è stata salvata correttamente, FALSE altrimenti
 */
function add_rate($email, $item, $rate){
    $db = database_connection();
    $sql = "INSERT INTO Rating(item, user, rate)
                                VALUES($item, '$email', $rate)
                                ON DUPLICATE KEY UPDATE rate = $rate";
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
