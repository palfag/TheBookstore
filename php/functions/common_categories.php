<?php
/**
 * @author Paolo Fagioli
 *
 * Funzioni comuni relative alle categorie
 */

/**
 * Recupera tutte le categorie di libri presenti nel database
 * @return  array Ritorna un array di categorie
 */
function retrieve_categories(){
    $db = database_connection();
    $rows = $db->query("SELECT genre FROM BookGenres ORDER BY genre");
    $data = array();

        if($rows){
            foreach ($rows as $row){
                $data[] = $row;
            }
        }

        $db->close();
        return $data;
}