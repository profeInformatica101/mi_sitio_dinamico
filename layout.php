<?php
// Debug temporal
error_reporting(E_ALL);  //Es muy útil durante el desarrollo, porque te permite ver cualquier problema en el código.
ini_set('display_errors','1'); // '1' significa “activar” la visualización (mostrar los errores)

/** EN PRODUCCIÓN 
 * 
error_reporting(0);
ini_set('display_errors', '0');
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mi primer sitio modular con PHP</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <div class="container py-4">

    <!-- Encabezado -->
    <?php
      $hdr = __DIR__ . '/elementos/header.php';
      if (is_file($hdr) && is_readable($hdr)) {
        require_once $hdr;
      } else {
        echo '<div class="alert alert-danger">No se encuentra/lee header: ' . htmlspecialchars($hdr) . '</div>';
      }
    ?>

    <!-- Contenido principal -->
    <main class="mt-4">
      <?php
        //$cnt = __DIR__ . '/elementos/contenido.php';
        $cnt = __DIR__ . "/elementos/{$p}.php";
        if (is_file($cnt) && is_readable($cnt)) {
          require_once $cnt;
        } else {
          echo '<div class="alert alert-danger">No se encuentra/lee contenido: ' . htmlspecialchars($cnt) . '</div>';
        }
      ?>
    </main>

    <!-- Pie de página -->
    <?php
      $ftr = __DIR__ . '/elementos/footer.php';
      if (is_file($ftr) && is_readable($ftr)) {
        require_once $ftr;
      } else {
        echo '<div class="alert alert-danger">No se encuentra/lee footer: ' . htmlspecialchars($ftr) . '</div>';
      }
    ?>

  </div>
</body>
</html>
