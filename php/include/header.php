<?php
    session_start();
    ensure_logged_in();


function ensure_logged_in() {
    if (!isset($_SESSION["email"])) {
        redirect("../index.php", "You can see this page, but first you have to sign in");
    }
}

function redirect($url, $flash_message = NULL) { //parametro di default = NULL
    if ($flash_message)
        $_SESSION["flash"] = $flash_message; // messaggio di errore
    header("Location: $url");
    die;
}