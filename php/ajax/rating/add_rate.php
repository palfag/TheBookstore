<?php
    require_once "../resources.php";

    $email = $_SESSION['email'];


    if(isset($_POST['rate']) && isset($_POST['item'])){
        $item = filter_input(INPUT_POST, "item",
            FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $rate = filter_input(INPUT_POST, "rate",
            FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // vogliamo prendere il numero di stelle salvate nel db (se l'utente ha già votato è presente nel database / altrimenti verrà restituito zero e non ci saranno stelle)

        $done = add_rate($email,$item, $rate);

        if($done){
            $response = array("success" => 1, "rate"=> $rate);
        }
        else $response = array("success" => 0, "error"=> "Problem adding rate");

        echo json_encode($response);
    }


function add_rate($email, $item, $rate){
    $db = database_connection();
    $sql = "INSERT INTO Rating(item, user, rate)
                                VALUES($item, '$email', $rate)
                                ON DUPLICATE KEY UPDATE rate = $rate";
    try {
        if (!$db->query($sql)) {
            throw new Exception("query error");
        }
        return true;
    } catch (Exception $e) {
        $e->getMessage(); # TODO: DA DEFINIRE COSA FARE IN CASO DI ECCEZIONI
        return false;
    } finally {
        $db->close();
    }
}
