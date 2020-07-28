<?php


    function database_connection(){
        $server = "127.0.0.1";
        $username = "root";
        $password = "root";
        $database = "prova";
        $port = '8889';

        $conn = new mysqli($server, $username, $password, $database, $port);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            exit();
        }
        return $conn;
    }

?>
