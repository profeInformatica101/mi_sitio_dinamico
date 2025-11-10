<?php

declare(strict_types=1);

require_once __DIR__ . '/DAO.php';
require_once __DIR__ . '/../Usuario.php';

class UsuarioDAO extends DAO
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo, 'usuarios');
    }

    /**
     * Inserta o actualiza un usuario.
     * - Solo actualiza la contraseña si hay hash presente en la entidad.
     */
    public function guardar(object $entidad): bool
    {
        if (!($entidad instanceof Usuario)) {
            throw new InvalidArgumentException('Se esperaba un objeto de tipo Usuario');
        }

        $tieneId = (int)$entidad->getId() > 0;
        $hash    = trim((string)$entidad->getPasswordHash());

        if ($tieneId) {
            if ($hash !== '') {
                // UPDATE con password
                $sql = "UPDATE {$this->tabla}
                           SET usuario = :usuario,
                               nombre  = :nombre,
                               rol     = :rol,
                               password= :password
                         WHERE id = :id";
                $stmt = $this->pdo->prepare($sql);
                return $stmt->execute([
                    ':usuario'  => $entidad->usuario,
                    ':nombre'   => $entidad->nombre,
                    ':rol'      => $entidad->rol,
                    ':password' => $hash,
                    ':id'       => $entidad->getId(),
                ]);
            } else {
                // UPDATE sin tocar password
                $sql = "UPDATE {$this->tabla}
                           SET usuario = :usuario,
                               nombre  = :nombre,
                               rol     = :rol
                         WHERE id = :id";
                $stmt = $this->pdo->prepare($sql);
                return $stmt->execute([
                    ':usuario' => $entidad->usuario,
                    ':nombre'  => $entidad->nombre,
                    ':rol'     => $entidad->rol,
                    ':id'      => $entidad->getId(),
                ]);
            }
        }

        // INSERT
        $sql = "INSERT INTO {$this->tabla} (usuario, nombre, rol, password)
                VALUES (:usuario, :nombre, :rol, :password)";
        $stmt = $this->pdo->prepare($sql);
        $ok = $stmt->execute([
            ':usuario'  => $entidad->usuario,
            ':nombre'   => $entidad->nombre,
            ':rol'      => $entidad->rol,
            ':password' => $hash, // ← debe venir ya hasheado desde la entidad
        ]);

        if ($ok) {
            $entidad->setId((int)$this->pdo->lastInsertId());
        }
        return $ok;
    }

    /**
     * Busca un usuario por su ID.
     */
    public function buscarPorId(int $id): ?Usuario
    {
        $stmt = $this->pdo->prepare("SELECT id, usuario, nombre, rol, password
                                       FROM {$this->tabla}
                                      WHERE id = :id
                                      LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        $u = new Usuario();
        $u->setId((int)$row['id']);
        $u->usuario = $row['usuario'];
        $u->nombre  = $row['nombre'];
        $u->rol     = $row['rol'];
        // ⚠️ IMPORTANTE: asignar hash directamente o con setPasswordHash()
        $u->setPasswordHash($row['password']);

        return $u;
    }

    /**
     * Devuelve todos los usuarios (sin exponer el hash).
     * @return Usuario[]
     */
    public function listar(): array
    {
        $stmt = $this->pdo->query("SELECT id, usuario, nombre, rol
                                     FROM {$this->tabla}
                                 ORDER BY id ASC");
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $usuarios = [];
        while ($row = $stmt->fetch()) {
            $u = new Usuario();
            $u->setId((int)$row['id']);
            $u->usuario = $row['usuario'];
            $u->nombre  = $row['nombre'];
            $u->rol     = $row['rol'];
            // No cargamos password aquí
            $usuarios[] = $u;
        }
        return $usuarios;
    }

    /**
     * Busca un usuario por su nombre de usuario (login).
     */
    public function buscarPorUsuario(string $usuario): ?Usuario
    {
        $stmt = $this->pdo->prepare("SELECT id, usuario, nombre, rol, password
                                       FROM {$this->tabla}
                                      WHERE usuario = :usuario
                                      LIMIT 1");
        $stmt->execute([':usuario' => $usuario]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        $u = new Usuario();
        $u->setId((int)$row['id']);
        $u->usuario = $row['usuario'];
        $u->nombre  = $row['nombre'];
        $u->rol     = $row['rol'];
        $u->setPasswordHash($row['password']); // ← importante

        return $u;
    }

    protected function crearEntidad(array $fila): object
    {
        $usuario = new Usuario($fila['nombre'], $fila['email']);
        $usuario->setId((int)$fila['id']);
        return $usuario;
    }
}
