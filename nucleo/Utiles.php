<?php
/**
 * ========================================================
 * 🧩 Utilidades generales (helpers)
 * Autor: profeinformatica101
 * ========================================================
 */

declare(strict_types=1);

require_once __DIR__ . '/../config.php';  // sube a la raíz

final class Utiles
{
    private function __construct() {}

    /**
     * 🔒 Escapa HTML para evitar XSS
     */
    public static function e(string $texto): string
    {
        return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    /**
     * 🐛 Dump bonito (no detiene la ejecución)
     * Usa dd() si quieres parar.
     */
    public static function dump(...$args): void
    {
        if (!defined('DEBUG') || DEBUG !== true) return;
        echo '<pre style="background:#111;color:#0f0;padding:1rem;border-radius:8px;">';
        foreach ($args as $i => $valor) {
            echo "📦 [{$i}] ";
            var_dump($valor);
            echo "\n";
        }
        echo '</pre>';
    }

    /**
     * 🛑 Dump & Die (detiene la ejecución)
     */
    public static function dd(...$args): void
    {
        self::dump(...$args);
        if (defined('DEBUG') && DEBUG === true) {
            exit;
        }
    }

    /**
     * 🔁 Redirección segura
     */
   public static function redirect(string $to = INDEX): void {
    header("Location: {$to}");
    exit;
}

    /**
     * 📮 Atajos de request
     */
    public static function isPost(): bool
    {
        return ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST';
    }

    public static function post(string $key, mixed $default = ''): mixed
    {
        return $_POST[$key] ?? $default;
    }

    public static function get(string $key, mixed $default = ''): mixed
    {
        return $_GET[$key] ?? $default;
    }


}
