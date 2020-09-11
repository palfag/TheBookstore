<?php
/**
 * @author Paolo Fagioli
 *
 * File che si occupa della risposta AJAX
 * Recupera la valutazione media di un libro ★★★★★
 *
 * @NB. Se il libro non è stato valutato da nessun utente, sarà restituito 0 (ZERO) e nessuna stella verrà illuminata
 */
    require_once "../resources.php";

    $email = $_SESSION['email'];

    if(isset($_POST['reset_stars']) && isset($_POST['item'])){
        $item = filter_input(INPUT_POST, "item",
            FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $rate = retrieve_rate($item);

        if($rate || $rate == 0){
            $response = array("success" => 1, "rate"=> $rate);
        }
        else $response = array("success" => 0, "error"=> "Problem retrieving rating");

        echo json_encode($response);
    }


/**
 * Recupera la valutazione di un libro media presente nel database
 * @param $item .. libro per cui si vuole recuperare la valutazione media
 * @return false|float|int|null Ritorna la valutazione media, 0 se non trova nessuna valutazione, null in caso di errore
 */
function retrieve_rate($item){
    $db = database_connection();
    $rows = $db->query("SELECT avg(rate) as average FROM Rating WHERE item = $item");

    try {
        if ($rows) {
            foreach ($rows as $row) {
                if($row["average"] == null)
                    return 0;
                return round($row["average"]);
            }
        } else throw new Exception("query error");
    } catch (Exception $e) {
        ######### TODO: DA DEFINIRE COSA FARE IN CASO DI ECCEZIONI
        return null;
    } finally {
        $db->close();
    }
}