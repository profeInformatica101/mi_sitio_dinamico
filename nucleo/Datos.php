<?php
declare(strict_types=1);

// RUTAS: este archivo vive en /nucleo
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/../config.php';

/**
 * 🌱 Inserta/actualiza usuarios de prueba.
 * - En CLI: imprime progreso.
 * - En web: no imprime (evita romper cabeceras).
 *
 * @return int Número de filas afectadas (aprox).
 */
function seedUsuariosDatos(): int
{
    $pdo = Database::getConnection();

    $usuarios = [
        ['admin',   'admin123', 'Administrador General', 'admin'],
        ['manager1','manager1',  'Laura Gestora',        'manager'],
        ['manager2','manager2',  'Carlos Supervisor',    'manager'],
        ['user1',   'user1',     'María Compradora',     'usuario'],
        ['user2',   'user2',     'Pedro Cliente',        'usuario'],
        ['user3',   'user3',     'Lucía Compradora',     'usuario'],
         ['user4',   'user4',     'Manuel Perez',     'usuario'],
    ];

    $sql = <<<SQL
    INSERT INTO usuarios (usuario, password, nombre, rol)
    VALUES (:usuario, :password, :nombre, :rol)
    ON DUPLICATE KEY UPDATE
        password = VALUES(password),
        nombre   = VALUES(nombre),
        rol      = VALUES(rol)
    SQL;

    $stmt = $pdo->prepare($sql);
    $afectadas = 0;
    $esCLI = (PHP_SAPI === 'cli');

    foreach ($usuarios as [$usuario, $clave, $nombre, $rol]) {
        $hash = password_hash($clave, PASSWORD_DEFAULT);
        $stmt->execute([
            ':usuario'  => $usuario,
            ':password' => $hash,
            ':nombre'   => $nombre,
            ':rol'      => $rol,
        ]);
        $afectadas += $stmt->rowCount();
        if ($esCLI) {
            echo "✅ {$usuario} ({$rol})\n";
        }
    }

    if ($esCLI) {
        echo "🌱 Seeding completado. Filas afectadas ~ {$afectadas}\n";
    }

    return $afectadas;
}

/* ─────────────────────────────────────────────────────────
   Si ejecutas este archivo directamente (no incluido), corre el seed.
   En CLI: imprime y sale 0. En web: silencioso y redirige a INDEX.
   ───────────────────────────────────────────────────────── */
if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    $esCLI = (PHP_SAPI === 'cli');

    // Seguridad mínima: permitir en web solo con DEBUG=true
    if (!$esCLI && (!defined('DEBUG') || DEBUG !== true)) {
        http_response_code(403);
        exit('Prohibido en producción');
    }

    if ($esCLI) {
        seedUsuariosDatos();
        exit(0);
    } else {
        ob_start();
        seedUsuariosDatos();
        ob_end_clean();
        header('Location: ' . (defined('INDEX') ? INDEX : '/'));
        exit;
    }
}
