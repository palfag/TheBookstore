<?php

require_once "top.php";
require_once "db.inc.php";

if (isset($_POST['search'])) {
    $query = filter_input(INPUT_POST, "query",
        FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $data = search_book($query);
    if(count($data) > 0){

        // AJAX RESPONSE
        $response = array("success" => 1, "data"=> $data);

    }
    else $response = array("success" => 0, "error"=> "No data found");

    echo json_encode($response);
}



/**
 * Retreives books that conform to the standard defined by the query (from the database).
 * @param string $query
 * @return bool Returns conform books contained into the database.
 */
function search_book($query){
    $db = database_connection();
    $rows = $db->query("SELECT * FROM books WHERE title LIKE '$query%' OR author LIKE '$query%' ORDER BY title");
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
