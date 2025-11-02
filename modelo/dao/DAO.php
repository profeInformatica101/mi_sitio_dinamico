<?php
// modelo/dao/DAO.php
require_once __DIR__ . '/DAOInterface.php';

abstract class DAO implements DAOInterface {
    protected readonly PDO $pdo;
    protected readonly string $tabla;

     public function __construct(PDO $pdo, string $tabla) {
        if (empty($tabla)) {
            throw new LogicException('Debe especificarse una tabla para el DAO.');
        }
        $this->pdo = $pdo;
        $this->tabla = $tabla;
    }


    // Implementación opcional de algunos métodos comunes
    public function eliminar(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->tabla} WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Los demás métodos pueden dejarse abstractos
    abstract public function guardar(object $entidad): bool;
    abstract public function buscarPorId(int $id): ?object;
    abstract public function listar(): array;
}
