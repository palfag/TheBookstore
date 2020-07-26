<?php

    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "prova";

    $conn = new mysqli($server, $username, $password, $database);

    if($conn == null){
        die("Connection error");
    }

?>
