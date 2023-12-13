<?php
session_start();
if (isset($_SESSION['tiempo'])) {

    $inactivo = 600;
    $vida_session = time() - $_SESSION['tiempo'];

    if ($vida_session > $inactivo) {
        session_unset();
        session_destroy();
        header("Location: ../index.php");
        exit();

    } else {
        $_SESSION['tiempo'] = time();
    }


} else {
    $_SESSION['tiempo'] = time();
}