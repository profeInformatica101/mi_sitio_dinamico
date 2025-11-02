<?php
declare(strict_types=1);

/**
 * Clase base Entidad
 * -------------------
 * Define un identificador común (id) para todas las entidades del sistema.
 * Permite garantizar que cada entidad tenga un campo 'id' y métodos uniformes.
 */
abstract class Entidad {
    protected ?int $id = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function tieneId(): bool {
        return $this->id !== null;
    }
}
?>
