<?php

require_once "top.php";
require_once "db.inc.php";

if (isset($_POST['search'])) {
    $query = filter_input(INPUT_POST, "query",
        FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $sort_criteria = filter_input(INPUT_POST, "sort",
        FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $data = search_book($query, $sort_criteria);
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
 * @param $sort
 * @return array Returns conform books contained into the database.
 */
function search_book($query, $sort){
    $db = database_connection();
    $rows = $db->query("SELECT * FROM books WHERE title LIKE '$query%' OR author LIKE '$query%' ORDER BY $sort");

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
