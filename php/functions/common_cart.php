<?php
/**
 * @author Paolo Fagioli
 *
 * Funzioni comuni relative al carrello
 */


/**
 * Aggiunge un articolo al carrello
 * @param $user l'utente che vuole aggiungere al carrello
 * @param $item l'articolo che dev'essere aggiunto
 * @return bool Ritorna TRUE se l'articolo è stato aggiunto al carrello, FALSE altrimenti
 */
function add_to_cart($user, $item){
    $db = database_connection();
    $sql = "INSERT INTO Cart(user, item) VALUES ('$user', '$item')";
    try{

        if(!$db->query($sql)){
            throw new Exception("query error");
        }
        return true;
    } catch (Exception $e){
        $e->getMessage();
        return false;
    } finally {
        $db->close();
    }
}

/**
 * Svuota il carrello
 * @param $user utente per il quale si deve svuotare il carrello
 * @return bool Ritorna TRUE il carrello è stato svuotato, FALSE altrimenti
 */
function remove_all_from_cart($user){
    $db = database_connection();
    $sql = "DELETE FROM Cart where user='$user'";
    try{

        if(!$db->query($sql)){
            throw new Exception("query error");
        }
        return true;
    } catch (Exception $e){
        $e->getMessage();
        return false;
    } finally {
        $db->close();
    }
}


/**
 * Ritorna il subtotale per una linea di articolo [prezzo(articolo) * quantità]
 * @param $email utente loggato
 * @param $item articolo per cui si deve calcolare il subtotale
 * @return  Ritorna il subtotale
 */
function get_subtotal($email, $item){
    $db = database_connection();
    $sql = "SELECT SUM(price) as subtotal
            FROM Cart JOIN Books on item = book_id
            WHERE user = '$email' and item = '$item'
            Group by user, item";

    $res = null;

    $rows = $db->query($sql);

    if($rows){
        foreach ($rows as $row){
            $res = $row['subtotal'];
        }
    }

    $db->close();
    return $res;
}

/**
 * Ritorna la somma totale degli articoli presenti nel carrello
 * @param $email utente loggato
 * @return string totale
 */
function get_total($email){
    $items = update_cart($email);
    $total = 0;
    for ($i = 0; $i < count($items); $i++) {
        $item = $items[$i];
        $total += (double)$item['subtotal'];
    }
    /* non penso sia necessario... ma perché no ?*/
    $total = sprintf('%0.2f', round($total, 2));
    return $total;
}

/**
 * Preleva/Aggiorna il carrello
 * @param $email utente loggato
 * @return array ritorna tutti gli articoli presenti nel carrello con quatità e subtotale
 */
function update_cart($email){
    $db = database_connection();
    $sql = "SELECT book_id, cover, title, author, price, COUNT(insertion_id) as quantity, SUM(price) as subtotal
                    FROM Cart JOIN Books on item = book_id
                    WHERE user = '$email'
                    GROUP BY user, book_id, cover, title, author, price";

    $rows = $db->query($sql);
    $data = array();

    if($rows) {
        foreach ($rows as $row) {
            $data[] = $row;
        }
    }
    $db->close();
    return $data;

}

/**
 * Recupera il numero di elementi presenti nel carrello
 * IMPORTANTE per poter aggiornare il @badge della navbar
 * @param $email utente loggato
 * @return Ritorna il numero di elementi presenti nel carrello
 */
function retrieve_number_cart_items($email){
    $db = database_connection();
    $rows = $db->query("SELECT COUNT(item) from cart where user = '$email'");
    $res = null;


        if($rows){
            foreach ($rows as $row){
                $res = $row['COUNT(item)'];
            }
        }

        $db->close();
        return $res;
}
