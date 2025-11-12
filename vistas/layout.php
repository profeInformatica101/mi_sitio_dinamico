<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mi primer sitio modular con PHP</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
  <div class="container py-4">
    <?php
      $hdr = __DIR__ . '/elementos/header.php';
      if (is_file($hdr)) require_once $hdr;
    ?>

    <main class="mt-4">
      <?php
      // valor por defecto (inicio) por si algo falla
      $cnt = __DIR__ . '/elementos/inicio.php';

      switch ($p) {
        case 'contacto':
          $cnt = __DIR__ . '/elementos/contacto.php';
          break;

        case 'contenido':
          // controlador está en ../controlador (carpetas hermanas)
          require_once __DIR__ . '/../controlador/ProductoController.php';
          $action = $_GET['action'] ?? 'index';

          if ($action === 'nuevo') {
            [$auth] = ProductoController::datosFormNuevo();
            $cnt = __DIR__ . '/producto/form.php';

          } elseif ($action === 'crear' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            ProductoController::crear(); exit;

          } elseif ($action === 'editar') {
            [$auth, $producto] = ProductoController::datosFormEditar();
            // si aún no tienes form_editar.php, apunta temporalmente a form.php
            $cnt = __DIR__ . '/producto/form_editar.php';

          } elseif ($action === 'actualizar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            ProductoController::actualizar(); exit;

          } elseif ($action === 'eliminar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            ProductoController::eliminar(); exit;

          } else {
            [$auth, $productos] = ProductoController::datosListado();
            $cnt = __DIR__ . '/producto/lista.php';
          }
          break;

        case 'productos': // si usas p=productos en los enlaces
          require_once __DIR__ . '/../controlador/ProductoController.php';
          $action = $_GET['action'] ?? 'index';

          if ($action === 'nuevo') {
            [$auth] = ProductoController::datosFormNuevo();
            $cnt = __DIR__ . '/producto/form.php';

          } elseif ($action === 'crear' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            ProductoController::crear(); exit;

          } elseif ($action === 'editar') {
            [$auth, $producto] = ProductoController::datosFormEditar();
            $cnt = __DIR__ . '/producto/form.php';

          } elseif ($action === 'actualizar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            ProductoController::actualizar(); exit;

          } elseif ($action === 'eliminar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            ProductoController::eliminar(); exit;

          }  elseif ($action === 'ver') {
              [$auth, $producto] = ProductoController::ver();
              $cnt = __DIR__ . '/producto/detalle.php';
              
          }else {
            [$auth, $productos] = ProductoController::datosListado();
            $cnt = __DIR__ . '/producto/lista.php';
          }
          break;

        case 'server':
          $cnt = __DIR__ . '/elementos/server.php';
          break;

        case 'session':
          $cnt = __DIR__ . '/elementos/session.php';
          break;

        case 'xss':
          $cnt = __DIR__ . '/elementos/xss.php';
          break;

        default:
          $cnt = __DIR__ . '/elementos/inicio.php';
          break;
      }

      if (!is_file($cnt)) {
        // Debug amable si la ruta calculada no existe
        echo '<div class="alert alert-warning">Vista no encontrada: ' . htmlspecialchars($cnt) . '</div>';
      } else {
        require_once $cnt;
      }
      ?>
    </main>

    <?php
      $ftr = __DIR__ . '/elementos/footer.php';
      if (is_file($ftr)) require_once $ftr;
    ?>
  </div>
</body>
</html>
