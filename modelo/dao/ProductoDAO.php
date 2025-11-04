<?php
declare(strict_types=1);

require_once __DIR__ . '/DAO.php';
require_once __DIR__ . '/../Producto.php';

class ProductoDAO extends DAO
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo, 'productos');
    }

    protected function crearEntidad(array $fila): Entidad
    {
        $producto = new Producto($fila['nombre'], $fila['precio']);
        $producto->setId((int)$fila['id']);
        return $producto;
    } 
    /**
     * Inserta o actualiza un usuario.
     * - Solo actualiza la contraseña si hay hash presente en la entidad.
     */
    public function guardar(object $entidad): bool
    {
        if (!($entidad instanceof Producto)) {
            throw new InvalidArgumentException('Se esperaba un objeto de tipo Producto');
        }

        
        return true;
    }

    /**
     * Busca un usuario por su ID.
     */
    public function buscarPorId(int $id): ?Producto
    {
        $stmt = $this->pdo->prepare("SELECT id, nombre, precio
                                       FROM {$this->tabla}
                                      WHERE id = :id
                                      LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;
        $producto = $this->crearEntidad($row);
      
        return $producto;
    }

    /**
     * Devuelve todos los usuarios (sin exponer el hash).
     * @return Usuario[]
     */
    public function listar(): array
    {
        $stmt = $this->pdo->query("SELECT id, nombre, precio                                     FROM {$this->tabla}
                                 ORDER BY id ASC");
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $usuarios = [];
        while ($row = $stmt->fetch()) {
            $u = Producto::vacio();
            $u->setId((int)$row['id']);
            $u->nombre  = $row['nombre'];
            $u->precio     = $row['precio'];
            $usuarios[] = $u;
        }
        return $usuarios;
    }

   
}
