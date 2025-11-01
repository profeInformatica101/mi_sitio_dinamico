<?php

function escaparHTML(string $texto): string {
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function escaparAttr(string $texto): string {
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
 * 🔔 Alerta Bootstrap
 */
function alerta(string $tipo, string $msg): string {
    $permitidos = ['primary','secondary','success','danger','warning','info','light','dark'];
    if (!in_array($tipo, $permitidos, true)) $tipo = 'info';
    return '<div class="alert alert-' . $tipo . '" role="alert">' . escaparHTML($msg) . '</div>';
}

/**
 * 🔐 Formulario de inicio de sesión
 *
 * - Lee automáticamente $_SESSION['error'] y $_SESSION['old']['usuario'] si existen.
 * - Puedes pasar error/oldUser/csrf por parámetros si prefieres (prioridad a parámetros).
 *
 * @param string      $actionURL URL del script que procesará el login
 * @param string|null $error     Mensaje de error a mostrar (opcional)
 * @param string      $oldUser   Usuario tecleado previamente (opcional)
 * @param string|null $csrf      Token CSRF (opcional)
 */
function generarFormularioLogin(string $actionURL, ?string $error = null, string $oldUser = '', ?string $csrf = null): string {
    // Soporte "flash" automático si no se pasan parámetros
    if ($error === null && isset($_SESSION['error'])) {
        $error = (string)$_SESSION['error'];
        unset($_SESSION['error']);
    }
    if ($oldUser === '' && isset($_SESSION['old']['usuario'])) {
        $oldUser = (string)$_SESSION['old']['usuario'];
        unset($_SESSION['old']);
    }

    $url = escaparAttr($actionURL);
    $old = escaparAttr($oldUser);

    $html  = '<h1 class="mb-3 text-center">Iniciar sesión</h1>';

    if ($error) {
        $html .= alerta('danger', $error);
    }

    $html .= <<<HTML
  <form method="POST" action="{$url}" class="p-4 border rounded bg-white shadow-sm mx-auto" style="max-width:420px;">
    <input type="hidden" name="accion" value="login">
HTML;

    if ($csrf) {
        $html .= '    <input type="hidden" name="csrf_token" value="' . escaparAttr($csrf) . '">' . PHP_EOL;
    }

    $html .= <<<HTML
    <div class="mb-3">
      <label for="usuario" class="form-label">Usuario</label>
      <input id="usuario" type="text" name="usuario" class="form-control" value="{$old}" required autocomplete="username">
    </div>
    <div class="mb-3">
      <label for="credencial" class="form-label">Contraseña</label>
      <input id="credencial" type="password" name="credencial" class="form-control" required autocomplete="current-password">
    </div>
    <button type="submit" class="btn btn-primary w-100">Iniciar sesión</button>
  </form>
  <div class="alert alert-info mt-3 text-center" role="alert">
    <strong>Credenciales de ejemplo:</strong> <mark>En ./nucleo/Datos.php</mark>
  </div>
HTML;

    return $html;
}

/**
 * 🚪 Formulario para cerrar sesión
 *
 * @param string      $actionURL URL del script que procesará el logout
 * @param string|null $csrf      Token CSRF (opcional)
 */
function generarLogout(string $actionURL, ?string $csrf = null): string {
    $url = escaparAttr($actionURL);

    $html  = '<form method="POST" action="' . $url . '" class="text-center mt-3">';
    $html .= '  <input type="hidden" name="accion" value="logout">' . PHP_EOL;

    if ($csrf) {
        $html .= '  <input type="hidden" name="csrf_token" value="' . escaparAttr($csrf) . '">' . PHP_EOL;
    }

    $html .= '  <button type="submit" class="btn btn-danger">Cerrar sesión</button>';
    $html .= '</form>';

    return $html;
}
