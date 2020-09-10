<?php

/**
 * Retreives genre from the database.
 * returns genres contained into the database.
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