<?php

function escaparHTML(string $texto): string {
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * ------------------------------------------------------------
 * 🏗️ Genera una página HTML con Bootstrap
 * ------------------------------------------------------------
 */
function generarPaginaHTML(string $titulo, string $contenido): string {
    $tituloLimpio = escaparHTML($titulo);

    return <<<HTML
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{$tituloLimpio}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-4">
    {$contenido}
  </div>
  <hr>
  <footer class="text-center text-muted mb-4">
    <small>Desarrollado con ❤️</small>
  </footer>
</body>
</html>
HTML;
}

/**
 * 🔐 Formulario de inicio de sesión
 *
 * @param string $actionURL URL del script que procesará el login
 */
function generarFormularioLogin(string $actionURL): string {
    $url = escaparHTML($actionURL);
    return <<<HTML
  <h1 class="mb-3 text-center">Iniciar sesión</h1>
  <form method="POST" action="{$url}" class="p-4 border rounded bg-white shadow-sm mx-auto" style="max-width:420px;">
    <input type="hidden" name="accion" value="login">
    <div class="mb-3">
      <label for="usuario" class="form-label">Usuario</label>
      <input id="usuario" type="text" name="usuario" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="credencial" class="form-label">Contraseña</label>
      <input id="credencial" type="password" name="credencial" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">Iniciar sesión</button>
  </form>
  <div class="alert alert-info mt-3 text-center" role="alert">
    <strong>Credenciales de ejemplo:</strong> <mark>En ./nucleo/Datos.php</mark></div>
HTML;
}

/**
 * 🚪 Formulario para cerrar sesión
 *
 * @param string $actionURL URL del script que procesará el logout
 */
function generarLogout(string $actionURL): string {
    $url = escaparHTML($actionURL);
    return <<<HTML
  <form method="POST" action="{$url}" class="text-center mt-3">
    <input type="hidden" name="accion" value="logout">
    <button type="submit" class="btn btn-danger">Cerrar sesión</button>
  </form>
HTML;
}
?>
