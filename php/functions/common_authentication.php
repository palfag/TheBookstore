<?php

/**
 * Retreives the password hashed from the database.
 * @param string $email The email of the password that we want to recover
 * @return bool Returns password hashed contained into the database.
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
 * Checks if the given email is contained into the database.
 * @param string $email The email which the user would like to register with.
 * @return bool Returns TRUE if the email is contained into the database, or FALSE otherwise.
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
