<?php
// Variables disponibles: $auth (array|null), $producto (objeto Producto)

if (!$producto) {
    echo '<div class="alert alert-danger text-center mt-4">Producto no encontrado.</div>';
    return;
}

$rol = $auth['rol'] ?? 'visitante';
$esManager = ($rol === 'manager');

// Valores con seguridad básica
$nombre = htmlspecialchars($producto->nombre);
$precio = number_format((float)$producto->precio, 2, ',', '.') . ' €';
$stock  = (int)$producto->stock;
$desc   = nl2br(htmlspecialchars($producto->descripcion));
$categoria = htmlspecialchars($producto->categoria ?? 'Sin categoría');

// Color del stock
$color = $stock <= 0 ? 'bg-dark' : ($stock <= 5 ? 'bg-danger' : ($stock <= 10 ? 'bg-warning text-dark' : 'bg-success'));
?>

<div class="container my-5">
  <div class="card shadow-sm mx-auto" style="max-width: 700px;">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0"><?= $nombre ?></h4>
    </div>
    <div class="card-body">
      <p><strong>Categoría:</strong> <?= $categoria ?></p>
      <p><strong>Precio:</strong> <?= $precio ?></p>
      <p><strong>Stock:</strong> 
        <span class="badge <?= $color ?>"><?= $stock ?> uds</span>
      </p>
      <p><strong>Descripción:</strong><br><?= $desc ?></p>
    </div>
    <div class="card-footer d-flex justify-content-between">
      <a href="index.php?p=productos" class="btn btn-secondary">Volver</a>
      <?php if ($esManager): ?>
        <a href="index.php?p=productos&action=editar&id=<?= (int)$producto->getId() ?>" class="btn btn-primary">Editar</a>
      <?php endif; ?>
    </div>
  </div>
</div>
