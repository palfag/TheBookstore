<?php

function retreive_number_cart_items($email){
    $db = database_connection();
    $rows = $db->query("SELECT COUNT(item) from cart where user = '$email'");
    try{
        if($rows){
            foreach ($rows as $row){
                return $row['COUNT(item)'];
            }
        }
        else throw new Exception("query error");
    } catch(Exception $e){
        $e->getMessage();
        ######### TODO: DA DEFINIRE COSA FARE IN CASO DI ECCEZIONI
    } finally {
        $db->close();
    }
}
