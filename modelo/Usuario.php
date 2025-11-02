<?php
//activar el modo estricto de tipos
declare(strict_types=1);

require_once __DIR__ . '/Entidad.php';

/**
 * ========================================================
 * 👤 Clase Usuario
 * Representa una fila de la tabla 'usuarios'
 * Hereda de Entidad (que contiene el id y utilidades comunes)
 * ========================================================
 */
class Usuario extends Entidad
{
    public string $usuario = '';
    public string $nombre  = '';
    public string $rol     = 'usuario';  // Valores típicos: 'usuario', 'admin'
    private string $passwordHash = '';

    /**
     * Asigna la contraseña en texto plano.
     * Se encarga de generar su hash seguro con password_hash().
     */
    public function setPassword(string $plainPassword): void
    {
        if (trim($plainPassword) !== '') {
            $this->passwordHash = password_hash($plainPassword, PASSWORD_DEFAULT);
        }
    }

    /**
     * Establece directamente el hash desde la base de datos.
     * (Evita volver a hashear contraseñas ya cifradas.)
     */
    public function setPasswordHash(string $hash): void
    {
        $this->passwordHash = $hash;
    }

    /**
     * Devuelve el hash de la contraseña (no la contraseña en texto plano).
     */
    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    /**
     * Verifica si una contraseña en texto plano coincide con el hash almacenado.
     */
    public function verificarPassword(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->passwordHash);
    }

    /**
     * Convierte el objeto en un array (útil para debug o JSON).
     */
    public function toArray(): array
    {
        return [
            'id'      => $this->getId(),
            'usuario' => $this->usuario,
            'nombre'  => $this->nombre,
            'rol'     => $this->rol,
            // Nunca se incluye el hash en respuestas visibles
        ];
    }
}
