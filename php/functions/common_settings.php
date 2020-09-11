<?php
/**
 * @author Paolo Fagioli
 *
 * Funzioni comuni relative alle impostazioni
 */

/**
 * Recupera le informazioni (nome, cognome, img) di un utente
 * @param $email utente loggato
 * @return mixed Ritorna le informazioni dell'utente
 */
function retrieve_usr_info($email){
    $db = database_connection();
    $rows = $db->query("SELECT name, surname, image FROM users WHERE email = '$email'");

    try{
        if($rows){
            foreach ($rows as $row){
                return $row;
            } throw new Exception("user not found");
        }
        else throw new Exception("query error");
    } catch(Exception $e){
        ######### TODO: DA DEFINIRE COSA FARE IN CASO DI ECCEZIONI
    } finally {
        $db->close();
    }
}
