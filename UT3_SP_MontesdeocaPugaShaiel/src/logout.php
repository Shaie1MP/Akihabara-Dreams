<?php
    // Inicio la sesión
    session_start();

    // Borro todas las variables de la sesión
    session_unset();

    // Destruyo la sesión
    session_destroy();

    // Te redirige al login
    header('Location: login.php');
    exit;

