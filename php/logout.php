<?php
    /**
     *  @author Paolo Fagioli
     *
     *  il file logout.php libera tutte le variabili di sessione #session_unset();
     *  e distrugge la sessione #session_destroy();
     */

    require_once "include/header.php";

    session_unset(); # flushes out session data
    session_destroy();

    header("Location: ../index.php");

