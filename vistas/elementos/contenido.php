<?php
require_once __DIR__ . '/plantillas.php';

// Inicia la sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Comprueba si el usuario está autenticado
$auth = $_SESSION['auth'] ?? null;

// Muestra la tabla (si no hay sesión, la función mostrará productos sin CRUD)
echo mostrarListadoProductos($auth);