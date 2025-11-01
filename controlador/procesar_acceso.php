<?php
/**
 * ========================================================
 * 🧠 CONTROLADOR: procesar_acceso.php
 * Proyecto: tienda_php
 * Autor: profeinformatica101
 * ========================================================
 * - Procesa login/logout usando base de datos MySQL (PDO)
 * - Ejemplo educativo (no apto para producción sin CSRF)
 * ========================================================
 */

session_start();
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../nucleo/Database.php';

// Mostrar errores (solo entorno de desarrollo)
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');


/**
 * --------------------------------------------------------
 *  CONFIGURACIÓN DE CONEXIÓN
 * --------------------------------------------------------
 */
function getPDO(): PDO {
    $host = 'localhost';
    $db   = 'tienda_php';
    $user = 'root';
    $pass = ''; // 🔧 Ajusta según tu entorno

    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    return new PDO($dsn, $user, $pass, $options);
}

/**
 * --------------------------------------------------------
 *  HELPERS
 * --------------------------------------------------------
 */
function redirect(string $to = INDEX): void {
    header("Location: {$to}");
    exit;
}


/**
 * --------------------------------------------------------
 *  LOGIN
 * --------------------------------------------------------
 */
function login(): void {
    $pdo  = Database::getConnection();
    $user = trim((string)($_POST['usuario'] ?? ''));
    $pass = trim((string)($_POST['credencial'] ?? ''));

    if ($user === '' || $pass === '') {
        Utils::dd('⛔ POST incompleto', $_POST);
    }

    $stmt = $pdo->prepare("SELECT id, usuario, nombre, rol, password FROM usuarios WHERE usuario = :usuario LIMIT 1");
    $stmt->execute([':usuario' => $user]);
    $u = $stmt->fetch();

    if (!$u) {
        Utils::dd('🔎 Usuario no encontrado', $user);
    }

    if (!password_verify($pass, $u['password'])) {
        Utils::dd('❌ Contraseña incorrecta', [
          'input' => $pass,
          'len'   => strlen($pass),
          'hex'   => bin2hex($pass),
          'hash'  => $u['password']
        ]);
    }

    session_regenerate_id(true);
    $_SESSION['auth'] = ['usuario'=>$u['usuario'], 'nombre'=>$u['nombre'], 'rol'=>$u['rol']];
    header("Location: " . INDEX);
    exit;
}
/**
 * --------------------------------------------------------
 *  LOGOUT
 * --------------------------------------------------------
 */
function logout(): void {
    session_destroy();
    redirect();
}

/**
 * --------------------------------------------------------
 *  CONTROLADOR PRINCIPAL
 * --------------------------------------------------------
 */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect();
}

$accion = $_POST['accion'] ?? '';

switch ($accion) {
    case 'login':
        login();
        break;

    case 'logout':
        logout();
        break;

    default:
        redirect();
}



?>
