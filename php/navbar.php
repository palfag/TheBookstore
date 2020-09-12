<?php
    /**
     *  @author Paolo Fagioli
     *
     *  Barra dei menù
     *  La barra dei menù permette di navigare agevolmente all'interno del sito
     *  Contiene le sezioni:
     *          - TheBookstore (link alla homepage)
     *          - Categories
     *              (facendo un hoover appare una lista con tutte le categorie presenti nel sito)
     *          - Cart (dotato di @badge che indica quanti articoli sono presenti all'interno del carrello)
     *          - Profile (si accede alla pagina personale dell'utente)
     *          - Logout (permette di distruggere la sessione)
     */
    require_once "include/header.php";
    require_once "include/db.inc.php";
    require_once "functions/common_cart.php";


    if(!isset($_SESSION['badge'])){
        $_SESSION['badge'] = retrieve_number_cart_items($_SESSION['email']);
    }
    $badge_num = $_SESSION['badge'];

    $name = retrieve_name($_SESSION['email']);
?>

    <nav>

        <div class="logo">
            <h4><a href="home.php"><img id="logo-img" src="../images/icons/favicon.png" alt="logo"><span>The</span>Bookstore</a></h4>
        </div>
        <ul class="nav-options">
            <li>
                <div class="dropdown">
                    <button class="dropbtn">Categories</button>
                    <div class="dropdown-content"></div>
                </div>
            </li>
            <li>
                <a class="notification" href="cart.php">Cart</a> <span class="badge"><?= $badge_num ?></span>
            </li>
            <li><a href="profile.php"><?= $name ?></a> </li>
            <li><a href="logout.php">Logout</a> </li>
        </ul>

        <div id="burger-menu" class="burger-menu">
            <div></div>
            <div></div>
            <div></div>
        </div>

    </nav>

<?php

/**
 * Recupera il nome dell'utente loggato ($_SESSION['email'])
 * @param $email email dell'utente loggato
 * @return |null Ritorna il nome dell'utente loggato
 */
function retrieve_name($email){
    $db = database_connection();
    $rows = $db->query("SELECT name FROM users WHERE email = '$email'");
    $res = null;

        if($rows) {
            foreach ($rows as $row) {
                $res = $row['name'];
            }
        }
        $db->close();
        return $res;
}
?>
