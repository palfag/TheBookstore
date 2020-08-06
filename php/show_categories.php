

<?php

    require_once "top.php";
    require_once "db.inc.php";

    // richiesta che arriva da nav.js se si passa sopra alla categories appaiono le categorie prese tramite ajax dal db
    if (isset($_POST['categories'])) {
     // devo recuperare le categorie dal database e rimandarle indietro

        $data = retreive_categories();

        if(count($data) > 0){

            // AJAX RESPONSE
            $response = array("success" => 1, "data"=> $data);

        }
        else $response = array("success" => 0, "error"=> "No data found");

        echo json_encode($response);
    }


/**
 * Retreives genre from the database.
 * returns genres contained into the database.
 */
function retreive_categories(){
    $db = database_connection();
    $rows = $db->query("SELECT genre FROM BookGenres ORDER BY genre");
    $data = array();
    try{
        if($rows){
            foreach ($rows as $row){
                $data[] = $row;
            }
        }
        else throw new Exception("query error");
    } catch(Exception $e){
        $e->getMessage();
        ######### TODO: DA DEFINIRE COSA FARE IN CASO DI ECCEZIONI
    } finally {
        $db->close();
        return $data;
    }
}
