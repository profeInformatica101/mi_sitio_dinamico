
<header class="text-center bg-white p-3 rounded shadow-sm">
  <h1 class="text-primary">🌟 Bienvenido a mi primer sitio PHP 🌟</h1>
  <!-- agrega una barra de navegación Bootstrap y que se relacione con contenido.php -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="http://localhost/dashboard/mi_sitio_dinamico-main">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="producto.php">Productos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contacto.php">Contacto</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <p class="text-muted">Usando include() por primera vez</p>
</header>
<?php
// Estructura asociativa: producto => precio
$productos = [
  "Pan de Camas"        => 1.20,
  "Aceitunas aliñadas"  => 2.50,
  "Tortas de aceite"    => 3.00,
  "Tarta de queso" => 2.00
];
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
    <?php for ($i = 0; $i < count($productos); $i++): ?>
      <tr>
        <td><?= htmlspecialchars(array_keys($productos)[$i]) ?></td>
        <td><?= number_format(array_values($productos)[$i], 2, ',', '.') ?></td>
      </tr>
    <?php endfor; ?>
  </tbody>
</table>