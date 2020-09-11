<?php
/**
 *  header comune a quasi tutti i file (esclusi index.php, login_ajax e signup_ajax)
 *  permette di avviare o di recuperare la sessione, in questo modo è possibile mantenere
 *  un utente loggato, cosa che altrimenti non sarebbe possibile perché HTTP è un protocollo
 *  stateless.
 *
 */
    session_start();
    ensure_logged_in();

/**
 * Reindirizza l'utente alla pagina di accesso (index.php) se non è autenticato
 * sfrutta la funzione ausiliaria redirect()
 */
function ensure_logged_in() {
    if (!isset($_SESSION["email"])) {
        redirect("../index.php", "You can see this page, but first you have to sign in");
    }
}

/**
 * Permette di effettuare un reindirizzamento nella pagina specificata accompagnata da un
 * eventuale messaggio
 * @param $url: URL della pagina destinazione del reidirizzamento
 * @param null $flash_message: messaggio di accompagnamento (se diverso da null)
 */
function redirect($url, $flash_message = NULL) { //parametro di default = NULL
    if ($flash_message)
        $_SESSION["flash"] = $flash_message;
    header("Location: $url");
    die;
}