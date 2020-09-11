<?php
/**
 * @author Paolo Fagioli
 *
 * File che si occupa della risposta AJAX
 * Recupera tutti i libri che sono conformi alla @query della richiesta AJAX
 */
    require_once "../resources.php";

    if (isset($_POST['search'])) {
        $query = filter_input(INPUT_POST, "query",
            FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $sort_criteria = filter_input(INPUT_POST, "sort",
            FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $genre = filter_input(INPUT_POST, "genre",
            FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $data = search_book($query, $sort_criteria, $genre);
        if(count($data) > 0){

            // AJAX RESPONSE
            $response = array("success" => 1, "data"=> $data);

        }
        else $response = array("success" => 0, "error"=> "No data found");

        echo json_encode($response);
    }


/**
 * Recupera tutti i libri che sono conformi allo standard definito dalla @query
 * @param string $query
 * @param $sort . eventuale criterio di ordinamento DEFAULT = title
 * @param $genre. eventuale filtro in base al genere DEFAULT = all
 * @return array Ritorna i libri conformi contenuti nel database
 */
function search_book($query, $sort, $genre){
    $db = database_connection();
    if(strcmp($genre, "all") == 0){
        $rows = $db->query("SELECT * FROM books WHERE title LIKE '$query%' OR author LIKE '$query%' ORDER BY $sort");
    }
    else  $rows = $db->query("SELECT * FROM books WHERE (title LIKE '$query%' OR author LIKE '$query%') and genre='$genre' ORDER BY $sort");

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
