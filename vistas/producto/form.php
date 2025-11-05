<?php
// Variables disponibles: $auth (array|null)
$rol = $auth['rol'] ?? 'visitante';
$esManager = ($rol === 'manager');
?>
<h2 class="text-success text-center mt-4">Nuevo producto</h2>

<?php if (!$esManager): ?>
  <div class="alert alert-danger w-75 mx-auto">No tienes permisos para crear productos.</div>
  <?php return; ?>
<?php endif; ?>

<form class="w-75 mx-auto mt-4" method="post" action="index.php?p=productos&action=crear">
  <div class="mb-3">
    <label class="form-label">Nombre</label>
    <input class="form-control" name="nombre" maxlength="120" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Precio (€)</label>
    <input class="form-control" name="precio" type="number" step="0.01" min="0" required>
  </div>

  <div class="d-flex gap-2">
    <button class="btn btn-primary" type="submit">Crear producto</button>
    <a class="btn btn-secondary" href="index.php?p=contenido">Cancelar</a>
  </div>
</form>
