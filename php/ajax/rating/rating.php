<?php

require_once "../resources.php";

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    die;
}

$email = $_SESSION['email'];

if(isset($_POST['reset_stars']) && isset($_POST['item'])){
    $item = filter_input(INPUT_POST, "item",
        FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    // vogliamo prendere il numero di stelle salvate nel db (se l'utente ha già votato è presente nel database / altrimenti verrà restituito zero e non ci saranno stelle)

    $rate = retrieve_rate($item);

    if($rate || $rate == 0){
        $response = array("success" => 1, "rate"=> $rate);
    }
    else $response = array("success" => 0, "error"=> "Problem retrieving rating");

    echo json_encode($response);
}



function retrieve_rate($item){
    $db = database_connection();
    //$rows = $db->query("SELECT rate FROM Rating WHERE user = '$email' AND item ='$item'");
    $rows = $db->query("SELECT avg(rate) as average FROM Rating WHERE item = $item");

    try {
        if ($rows) {
            foreach ($rows as $row) {
                if($row["average"] == null)
                    return 0;
                return round($row["average"]);
            }
        } else throw new Exception("query error");
    } catch (Exception $e) {
        ######### TODO: DA DEFINIRE COSA FARE IN CASO DI ECCEZIONI
        return null;
    } finally {
        $db->close();
    }
}