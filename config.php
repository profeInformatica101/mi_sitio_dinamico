<?php
declare(strict_types=1);

/**
 * =========================================================
 * ⚙️ CONFIGURACIÓN GLOBAL — tienda_php
 * Autor: profeinformatica101
 * =========================================================
 * - Lee variables desde .env (si existe)
 * - Define constantes globales de entorno, BD y rutas
 * - Calcula correctamente BASE_URL (sin incluir /controlador)
 * - Compatible con NOMBRE_SITIO y APP_NAME
 * =========================================================
 */

// =========================================================
// 1. Ruta raíz del proyecto
// =========================================================
define('ROOT_PATH', dirname(__DIR__));

// =========================================================
// 2. Cargar .env (si existe)
// =========================================================
$ENV = [];
$envFile = ROOT_PATH . '/.env';
if (is_readable($envFile)) {
    $ENV = parse_ini_file($envFile, false, INI_SCANNER_TYPED) ?: [];
}

// =========================================================
// 3. Variables de entorno principales
// =========================================================
define('APP_ENV',  $ENV['APP_ENV']  ?? 'dev');      // dev | prod
define('DEBUG',    (bool)($ENV['APP_DEBUG'] ?? true));
define('APP_NAME', $ENV['APP_NAME'] ?? 'tienda_php');

// Alias de compatibilidad con vistas antiguas
define('NOMBRE_SITIO', APP_NAME);

// =========================================================
// 4. Configuración de base de datos
// =========================================================
define('DB_HOST',    $ENV['DB_HOST']    ?? 'localhost');
define('DB_NAME',    $ENV['DB_NAME']    ?? 'tienda_php');
define('DB_USER',    $ENV['DB_USER']    ?? 'root');
define('DB_PASS',    $ENV['DB_PASS']    ?? '');
define('DB_CHARSET', $ENV['DB_CHARSET'] ?? 'utf8mb4');

// =========================================================
// 5. Zona horaria
// =========================================================
date_default_timezone_set($ENV['APP_TZ'] ?? 'Europe/Madrid');

// =========================================================
// 6. Cálculo de BASE_URL (automático o desde .env)
// =========================================================
if (!empty($ENV['BASE_URL'])) {
    define('BASE_URL', rtrim($ENV['BASE_URL'], '/'));
} else {
    $https  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    $scheme = $https ? 'https' : 'http';
    $host   = $_SERVER['HTTP_HOST'] ?? 'localhost';

    // Detectar carpeta base (quita /controlador o /public)
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
    $base = preg_replace('#/(controlador|public)(/.*)?$#', '', $scriptDir);

    define('BASE_URL', $scheme . '://' . $host . rtrim($base, '/'));
}

// =========================================================
// 7. Rutas comunes
// =========================================================
define('BASE_PATH', parse_url(BASE_URL, PHP_URL_PATH) ?: '');
define('INDEX',      BASE_PATH . '/index.php');
define('ACTION_URL', BASE_PATH . '/controlador/procesar_acceso.php');

// =========================================================
// 8. Configuración de errores
// =========================================================
if (DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}

// =========================================================
// 9. Helpers globales
// =========================================================
if (!function_exists('url')) {
    function url(string $path = ''): string {
        return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
    }
}

if (!function_exists('asset')) {
    function asset(string $path): string {
        return url('assets/' . ltrim($path, '/'));
    }
}
