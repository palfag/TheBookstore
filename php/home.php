<?php
    require_once "top.php";
    require_once "db.inc.php";

    if(!isset($_SESSION['email'])){
        header("Location: index.php");
        die;
    }

    $name = retreive_name($_SESSION['email']);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
</head>
<body>
    <h1>BENVENUTO <?= $name ?></h1>
    <h1><?= $_SESSION['flash'] ?></h1>

    <a href="logout.php">logout</a>

<?php

    function retreive_name($email){
        $db = database_connection();
        $rows = $db->query("SELECT name FROM users WHERE email = '$email'");

        try{
            if($rows){
                foreach ($rows as $row){
                        return $row['name'];
                    } throw new Exception("user not found");
                }
            else throw new Exception("query error");
        } catch(Exception $e){
            ######### TODO: DA DEFINIRE COSA FARE IN CASO DI ECCEZIONI
        } finally {
            $db->close();
        }
    }

?>

</body>
</html>
