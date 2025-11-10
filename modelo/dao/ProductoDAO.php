<?php
// modelo/dao/ProductoDAO.php
declare(strict_types=1);

require_once __DIR__ . '/DAO.php';
require_once __DIR__ . '/../Producto.php';

final class ProductoDAO extends DAO
{
    public function __construct(PDO $pdo) {
        parent::__construct($pdo, 'productos');
    }

    /** * @return Producto 
     * Crea la entidad Producto incluyendo stock y descripcion
     */
    protected function crearEntidad(array $fila): object {
        $p = new Producto(
            $fila['nombre'], 
            (float)$fila['precio'], 
            (int)$fila['stock'],        // Nuevo campo
            $fila['descripcion']        // Nuevo campo
        );
        if (isset($fila['id'])) { $p->setId((int)$fila['id']); }
        return $p;
    }

    /** * INSERT o UPDATE según tenga id 
     * Incluye stock y descripcion en ambas operaciones
     */
    public function guardar(object $entidad): bool {
        if (!($entidad instanceof Producto)) {
            throw new InvalidArgumentException('Se esperaba Producto');
        }

        $id = $entidad->getId();
        
        // --- INSERCIÓN (INSERT) ---
        if (empty($id)) {
            $sql = "INSERT INTO {$this->tabla} (nombre, precio, stock, descripcion) VALUES (:n, :p, :s, :d)";
            $st  = $this->pdo->prepare($sql);
            $ok  = $st->execute([
                ':n'=>$entidad->nombre, 
                ':p'=>$entidad->precio, 
                ':s'=>$entidad->stock,      // Nuevo parámetro
                ':d'=>$entidad->descripcion // Nuevo parámetro
            ]);
            if ($ok) { $entidad->setId((int)$this->pdo->lastInsertId()); }
            return $ok;
        }

        // --- ACTUALIZACIÓN (UPDATE) ---
        $sql = "UPDATE {$this->tabla} SET nombre=:n, precio=:p, stock=:s, descripcion=:d WHERE id=:id";
        $st  = $this->pdo->prepare($sql);
        return $st->execute([
            ':n'=>$entidad->nombre,
            ':p'=>$entidad->precio,
            ':s'=>$entidad->stock,
            ':d'=>$entidad->descripcion,
            ':id'=>$id
        ]);
    }

    /** * @return Producto[] 
     * La consulta SELECT trae todos los campos necesarios (id, nombre, precio, stock, descripcion)
     */
    public function listar(): array {
        $sql = "SELECT id, nombre, precio, stock, descripcion FROM {$this->tabla} ORDER BY id ASC";
        $st  = $this->pdo->query($sql);
        $st->setFetchMode(PDO::FETCH_ASSOC);

        $res = [];
        while ($row = $st->fetch()) {
            $p = $this->crearEntidad($row); // El método modificado ahora crea la entidad completa
            $res[] = $p;
        }
        return $res;
    }
}