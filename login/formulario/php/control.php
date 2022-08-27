<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $_SESSION['logged'] = false;

    if (!isset($_SESSION['CREATED'])) {
        $_SESSION['CREATED'] = time();
        $_SESSION['EXPIRE'] = $_SESSION['CREATED'] + (60 * 60);
    } 
    else if (time() - $_SESSION['CREATED'] >= $_SESSION['EXPIRE']) {
        session_destroy();
    }    
?>