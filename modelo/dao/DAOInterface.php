<?php
// modelo/dao/DAOInterface.php
interface DAOInterface {
    public function guardar(object $entidad): bool;
    public function eliminar(int $id): bool;
    public function buscarPorId(int $id): ?object;
    public function listar(): array;
}
