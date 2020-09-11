<?php
/**
 * @author Paolo Fagioli
 *
 * Funzioni comuni relative alle categorie
 */

/**
 * Recupera tutte le categorie di libri presenti nel database
 * @return array Ritorna un array di categorie
 */
function retrieve_categories(){
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