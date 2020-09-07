<?php

    require_once "include/header.php";

    session_unset(); # flushes out session data
    session_destroy();

    header("Location: ../index.php");

?>

