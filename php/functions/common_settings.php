<?php
/**
 * @author Paolo Fagioli
 *
 * Funzioni comuni relative alle impostazioni
 */

/**
 * Recupera le informazioni (nome, cognome, img) di un utente
 * @param $email utente loggato
 * @return array Ritorna le informazioni dell'utente
 */
function retrieve_usr_info($email){
    $db = database_connection();
    $rows = $db->query("SELECT name, surname, image FROM users WHERE email = '$email'");
    $res = null;

    if($rows){
        foreach ($rows as $row){
            $res = $row;
        }
    }

    $db->close();
    return $res;
}
