<?php
require_once __DIR__ . '/Entidad.php';

class Usuario extends Entidad {
    private PDO $pdo;
    public string $usuario;
    public string $nombre;
    public string $rol;
    private string $password;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function guardar(): bool {
        if ($this->tieneId()) {
            $sql = "UPDATE usuarios SET usuario=?, nombre=?, rol=?, password=? WHERE id=?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$this->usuario, $this->nombre, $this->rol, $this->password, $this->id]);
        } else {
            $sql = "INSERT INTO usuarios (usuario, nombre, rol, password) VALUES (?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $ok = $stmt->execute([$this->usuario, $this->nombre, $this->rol, $this->password]);
            if ($ok) {
                $this->id = (int)$this->pdo->lastInsertId();
            }
            return $ok;
        }
    }

    public static function buscarPorUsuario(PDO $pdo, string $usuario): ?self {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
        $stmt->execute([$usuario]);
        $datos = $stmt->fetch();
        if ($datos) {
            $u = new self($pdo);
            $u->setId((int)$datos['id']);
            $u->usuario = $datos['usuario'];
            $u->nombre = $datos['nombre'];
            $u->rol = $datos['rol'];
            $u->password = $datos['password'];
            return $u;
        }
        return null;
    }
}
?>
