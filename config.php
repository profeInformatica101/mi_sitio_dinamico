<?php
declare(strict_types=1);

/* ========== Rutas base ========== */
define('ROOT_PATH', dirname(__DIR__));

/* ========== Cargar .env (opcional) ========== */
$ENV = [];
$envFile = ROOT_PATH . '/.env';
if (is_readable($envFile)) {
  $ENV = parse_ini_file($envFile, false, INI_SCANNER_TYPED) ?: [];
}

/* ========== App ========== */
define('APP_ENV',  $ENV['APP_ENV']  ?? 'dev');
define('DEBUG',    (bool)($ENV['APP_DEBUG'] ?? (APP_ENV !== 'prod')));
define('APP_NAME', $ENV['APP_NAME'] ?? 'tienda_php');
define('NOMBRE_SITIO', APP_NAME);            // compat vistas
date_default_timezone_set($ENV['APP_TZ'] ?? 'Europe/Madrid');

/* ========== DB ========== */
define('DB_HOST',    $ENV['DB_HOST']    ?? 'localhost');
define('DB_NAME',    $ENV['DB_NAME']    ?? 'tienda_php');
define('DB_USER',    $ENV['DB_USER']    ?? 'root');
define('DB_PASS',    $ENV['DB_PASS']    ?? '');
define('DB_CHARSET', $ENV['DB_CHARSET'] ?? 'utf8mb4');

/* ========== URLs ========== */
if (!empty($ENV['BASE_URL'])) {
  define('BASE_URL', rtrim($ENV['BASE_URL'], '/'));
} else {
  $https  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
  $scheme = $https ? 'https' : 'http';
  $host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
  $base   = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/');
  define('BASE_URL', $scheme . '://' . $host . $base);
}
define('BASE_PATH', parse_url(BASE_URL, PHP_URL_PATH) ?: '');
define('INDEX',      BASE_PATH . '/../index.php');
define('ACTION_URL', BASE_PATH . '/controlador/procesar_acceso.php');

/* ========== Errores ========== */
if (DEBUG) {
  error_reporting(E_ALL);
  ini_set('display_errors', '1');
  ini_set('display_startup_errors', '1');
} else {
  error_reporting(0);
  ini_set('display_errors', '0');
}

