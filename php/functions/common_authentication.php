<?php
/**
 * @author Paolo Fagioli
 *
 * Funzioni comuni relative all'autenticazione
 */


/**
 * Recupera l'hash della password dal database
 * @param string $email l'email della password che vogliamo recuperare
 * @return Ritorna l'hash della password contenuta nel database
 */
function retrieve_hash($email){
    $db = database_connection();
    $rows = $db->query("SELECT pwd FROM users WHERE email = '$email'");
    $res = null;

        if ($rows) {
            foreach ($rows as $row)
                $res = $row["pwd"];
            }

        $db->close();
        return $res;
}

/**
 * Controlla se l'email passata come parametro è contenuta all'interno del database
 * @param string $email l'email da verificare
 * @return bool Ritorna TRUE se l'email è contenuta nel databse, FALSE altrimenti.
 */
function is_contained($email){
    $db = database_connection();
    $rows = $db->query("SELECT email FROM users WHERE email = '$email'");
    $res = false;

    if($rows){
        if($rows->num_rows == 1)
            $res = true;
    }

    $db->close();
    return $res;
}
