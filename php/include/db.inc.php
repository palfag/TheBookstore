<?php
    /**
     *  @author Paolo Fagioli
     *
     *  Funzione per la connessione al database
     */

function database_connection(){
        $server = "127.0.0.1";
        $username = "root";
        $password = "root";
        $database = "bookstore";
        $port = '8889';

        try{
            $conn = new mysqli($server, $username, $password, $database, $port);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
                exit();
            }
            return $conn;
        } catch(Exception $e){
           // TODO che torniamo in caso di eccezione ??
            return $e->getMessage();
        }
    }
