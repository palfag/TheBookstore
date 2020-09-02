<?php

    require_once "top.php";

    session_unset(); # flushes out session data
    session_destroy();

    header("Location: ../index.php");

?>

