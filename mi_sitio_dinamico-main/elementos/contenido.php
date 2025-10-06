<?php
$productos = ["Pan de Camas", "Aceitunas aliñadas", "Tortas de aceite"];
foreach ($productos as $p) {
  echo "<li class='list-group-item'>" . htmlspecialchars($p) . "</li>";
}
?>

<h2 class="text-success text-center mt-4">Productos locales de Camas</h2>

<table class="table table-bordered table-striped w-75 mx-auto mt-4 text-center align-middle">
  <thead class="table-primary">
    <tr>
      <th>Producto</th>
      <th>Precio (€)</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($productos as $nombre => $precio): ?>
      <tr>
        <td><?= htmlspecialchars($nombre) ?></td>
        <td><?= number_format($precio, 2, ',', '.') ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
