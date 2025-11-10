<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/config.php';

// Parámetro de vista (?p=)
$p = $_GET['p'] ?? 'inicio';

// Carga la vista principal
include __DIR__ . '/vistas/layout.php';