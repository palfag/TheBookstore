<?php

    function update_cart($email){
        $db = database_connection();
        $sql = "SELECT book_id, cover, title, author, price, COUNT(insertion_id) as quantity, SUM(price) as subtotal
                    FROM Cart JOIN Books on item = book_id
                    WHERE user = '$email'
                    GROUP BY user, book_id, cover, title, author, price";

        $rows = $db->query($sql);
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