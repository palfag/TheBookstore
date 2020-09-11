<?php
/**
 * @author Paolo Fagioli
 *
 * Funzioni comuni relative all'autenticazione
 */


/**
 * Recupera l'hash della password dal database
 * @param string $email l'email della password che vogliamo recuperare
 * @return bool Ritorna l'hash della password contenuta nel database
 */
function retrieve_hash($email){
    $db = database_connection();
    $rows = $db->query("SELECT pwd FROM users WHERE email = '$email'");

    try {
        if ($rows) {
            foreach ($rows as $row) {
                return $row["pwd"];
            }
            throw new Exception("user is not registered");
        } else throw new Exception("query error");
    } catch (Exception $e) {
        ######### TODO: DA DEFINIRE COSA FARE IN CASO DI ECCEZIONI
    } finally {
        $db->close();
    }
}

/**
 * Controlla se l'email passata come parametro è contenuta all'interno del database
 * @param string $email l'email da verificare
 * @return bool Ritorna TRUE se l'email è contenuta nel databse, FALSE altrimenti.
 */
function is_contained($email){
    $db = database_connection();
    $rows = $db->query("SELECT email FROM users WHERE email = '$email'");

    try{
        if($rows){
            foreach ($rows as $row){
                if($row["email"] == $email){
                    return true;
                }
            } return false;
        }
        else throw new Exception("query error");
    } catch(Exception $e){
        $e->getMessage();
        ######### TODO: DA DEFINIRE COSA FARE IN CASO DI ECCEZIONI
    } finally {
        $db->close();
    }
}
