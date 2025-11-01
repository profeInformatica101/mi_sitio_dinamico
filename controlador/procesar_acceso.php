<?php
/**
 * ========================================================
 * 🧠 CONTROLADOR: procesar_acceso.php
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

  // En procesar_acceso.php
$fail = function (string $msg) use ($user): void {
    $_SESSION['error'] = $msg;
    $_SESSION['old']   = ['usuario' => $user];
    header('Location: ' . INDEX);  
    exit;
};

    if ($user === '' || $pass === '') {
        $fail('Introduce usuario y contraseña.');
    }

    try {
        $stmt = $pdo->prepare("
            SELECT id, usuario, nombre, rol, password
              FROM usuarios
             WHERE usuario = :usuario
             LIMIT 1
        ");
        $stmt->execute([':usuario' => $user]);
        $u = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$u) {
            $fail('El usuario no existe.');
        }

    } catch (PDOException $e) {
        error_log('DB error (login): ' . $e->getMessage());
        $fail('Ha ocurrido un problema al conectar con la base de datos.');
    }

    // Contraseña incorrecta
    if (!password_verify($pass, $u['password'] ?? '')) {
        $fail('Contraseña incorrecta.');
    }

    // (Opcional) rehash si cambió el coste
    if (password_needs_rehash($u['password'], PASSWORD_DEFAULT)) {
        $new = password_hash($pass, PASSWORD_DEFAULT);
        $upd = $pdo->prepare("UPDATE usuarios SET password = :h WHERE id = :id");
        $upd->execute([':h' => $new, ':id' => (int)$u['id']]);
    }

    // Sesión segura
    session_regenerate_id(true);
    $_SESSION['auth'] = [
        'id'      => (int)$u['id'],
        'usuario' => $u['usuario'],
        'nombre'  => $u['nombre'],
        'rol'     => $u['rol'],
        'iat'     => time(),
    ];

    header('Location: ' . INDEX);
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
