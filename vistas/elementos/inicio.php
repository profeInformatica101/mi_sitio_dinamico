<?php
require_once __DIR__ . '/plantillas.php';
require_once __DIR__ . '/../../config.php';

$auth = $_SESSION['auth'] ?? null;

if ($auth) {
    $contenido  = '<h1>Hola, ' . escaparHTML($auth['nombre']) . ' 👋</h1>';
    $contenido .= '<p>Estás dentro de la sesión.</p>';
    $contenido .= generarLogout(ACTION_URL);
} else {
    $contenido = generarFormularioLogin(ACTION_URL);
}

echo generarPaginaHTML('Inicio de sesión', $contenido);