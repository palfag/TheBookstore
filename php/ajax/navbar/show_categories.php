<?php
/**
 * @author Paolo Fagioli
 *
 * File che si occupa della risposta AJAX
 * Ritorna tutte le categorie presenti nel database
 */
    require_once "../resources.php";
    require_once "../../functions/common_categories.php";

    // richiesta che arriva da nav.js se si passa sopra alle Categories appaiono le categorie prese tramite ajax dal db
    if (isset($_POST['categories'])) {

        $data = retrieve_categories();

        if(count($data) > 0){

            // AJAX RESPONSE
            $response = array("success" => 1, "data"=> $data);

        }
        else $response = array("success" => 0, "error"=> "No data found");

        echo json_encode($response);
    }

