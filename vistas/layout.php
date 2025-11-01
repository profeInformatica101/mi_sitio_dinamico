<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
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
    <?php
      $hdr = __DIR__ . '/elementos/header.php';
      if (is_file($hdr)) require_once $hdr;
    ?>

    <main class="mt-4">
      <?php
      switch ($p) {
        case 'contacto': $cnt = __DIR__ . '/elementos/contacto.php'; break;
        case 'contenido':   $cnt = __DIR__ . '/elementos/contenido.php';   break;
        case 'server':   $cnt = __DIR__ . '/elementos/server.php';   break;
        case 'session':   $cnt = __DIR__ . '/elementos/session.php';   break;
        case 'xss':      $cnt = __DIR__ . '/elementos/xss.php';      break;
        default:         $cnt = __DIR__ . '/elementos/inicio.php';   break;
      }

      if (is_file($cnt)) require_once $cnt;
      ?>
    </main>

    <?php
      $ftr = __DIR__ . '/elementos/footer.php';
      if (is_file($ftr)) require_once $ftr;
    ?>
  </div>
</body>
</html>
