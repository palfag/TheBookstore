<?php
/**
 * @author Paolo Fagioli
 *
 * File che si occupa della risposta AJAX
 * Permette di acquistare un prodotto
 */
    require_once "../resources.php";
    require_once "../../functions/common_cart.php";

    $email = $_SESSION['email'];

    if(isset($_POST['add_purchase'])){
        $hashmap = $_POST['add_purchase'];

           if(add_purchase($email, $hashmap)){
               if(remove_all_from_cart($email)){
                   $data = 0;
                   $_SESSION['badge'] = $data;
                   $response = array("success" => 1, "badge_num"=> $data);
               }
           }
           else $response = array("success" => 0, "error"=> "problem during the purchase");

            echo json_encode($response);
    }


/**
 * Aggiunge l'acquisto (consiste in un insieme di articoli e le loro rispettive quantità) nel database.
 * sfrutta la funzione ausiliare retreive_next_id
 * @param $user utente loggato
 * @param $items hashmap coppia (id_articolo; quantità)
 * @return bool Ritorna TRUE se l'acquisto è correttamente aggiunto nel db, FALSE altrimenti
 */
function add_purchase($user, $items){
    $db = database_connection();

    /**
     * Poiché dovrò effettuare tanti inserimenti quanti sono i prodotti nel carrello, e devo tenere lo stesso id,
     * per far capire che tutti i prodotti acquistati fanno parte della stessa vendita, non posso usare la proprietà
     * AUTO_INCREMENT del database, ma effettuo un modo diverso per raggiungere l'obiettivo
     *
     * @example vedere l'id come il numero dello scontrino/della ricevuta e
     * l'hashmap di articoli (articolo; quantità) come una linea di prodotto dello scontrino
     *
     * @strategy Recupero l'id massimo all'interno della tabella Purchases e aggiungo 1, in questo modo ottento l'id
     * della prossima vendita, tutti gli articoli che andrò ad aggiungere faranno riferimento a quel id
     */

    // RETRIEVE NEXT ID
    $next_id = retrieve_next_id($db);

    // ADDS ITEM ON PURCHASE
    try {
        foreach ($items as $item => $quantity){
            $sql2 = "INSERT INTO Purchases(id, user, item, quantity)
                     VALUES($next_id, '$user', $item, $quantity)";

            if (!$db->query($sql2)) {
                throw new Exception("query error");
            }
        }
        return true;
    } catch (Exception $e) {
        $e->getMessage(); # TODO: DA DEFINIRE COSA FARE IN CASO DI ECCEZIONI
        return false;
    } finally {
        $db->close();
    }
}

/**
 * Recupero l'id della prossima vendita.
 * @param $db database_connection il punto di accesso al database
 * @return int|mixed Ritorna il prossimo id di vendita
 *
 * @NB. All'inizio non ci saranno vendite, quindi $max['next'] sarà uguale a null, in questo caso
 * $next_id sarà uguale a 1 come prima vendita
 */
function retrieve_next_id($db){
    $sql1 = "SELECT MAX(id) + 1 as next FROM Purchases";
    $rows = $db->query($sql1);

    if($rows){
        foreach ($rows as $row){
            $max = $row;
        }
    }

    if($max['next'] == null){ // se uguale a null
        $next_id = 1;
    }
    else $next_id = $max['next'];

    return $next_id;
}
