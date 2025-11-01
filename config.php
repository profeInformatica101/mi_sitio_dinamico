<?php
define('ROOT_PATH', dirname(__DIR__));
define('NOMBRE_SITIO', 'Web dinámica PHP');
//$titulo = "Mi primer sitio modular con PHP";
$contenido = "elementos/contenido.php";

// URL base del proyecto (ajústala si cambias de entorno)
const BASE_PATH  = '/mi_sitio_dinamico';
const INDEX      = BASE_PATH . '/index.php';
const ACTION_URL = BASE_PATH . '/controlador/procesar_acceso.php';


define('DEBUG', true);

if (DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
}