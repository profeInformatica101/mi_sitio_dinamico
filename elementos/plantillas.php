<?php
/**
* Funciones de plantilla simples
*/

/**
 * Genera un menú de lectura tipo "patrón formulario" para navegar entre entidades
 *
 * @param string $entidad Nombre genérico de la entidad (ej: 'personaje', 'usuario')
 * @param array $elemento Datos del elemento actual (clave => valor)
 * @param int $indice Índice actual del elemento
 * @param int $total Número total de elementos
 * @param string $accionURL Ruta del script que procesa las peticiones (por ejemplo, $_SERVER['PHP_SELF'])
 * @return string HTML del menú completo
 */
function generarMenuLectura(string $entidad, array $elemento, int $indice, int $total, string $accionURL): string {
    $entidadMayus = ucfirst($entidad);
    $contenido = "<h2>Lectura de {$entidadMayus}</h2>\n";

    // Mostrar los datos de la entidad (clave: valor)
    $contenido .= "<div style='border:1px solid #ccc; border-radius:8px; padding:1rem; background:#fafafa;'>\n";
    foreach ($elemento as $clave => $valor) {
        $claveLimpia = htmlspecialchars($clave, ENT_QUOTES, 'UTF-8');
        $valorLimpio = htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
        $contenido .= "<p><strong>{$claveLimpia}:</strong> {$valorLimpio}</p>\n";
    }
    $contenido .= "</div>\n";

    // Navegación por formulario
    $contenido .= "<form method='GET' action='" . htmlspecialchars($accionURL, ENT_QUOTES, 'UTF-8') . "' style='text-align:center; margin-top:1rem;'>\n";
    $contenido .= "<input type='hidden' name='indice' value='{$indice}'>\n";

    // Botones Anterior / Siguiente
    if ($indice > 0) {
        $contenido .= "<button name='indice' value='" . ($indice - 1) . "'>&lt; Anterior</button>\n";
    } else {
        $contenido .= "<button disabled>&lt; Anterior</button>\n";
    }

    if ($indice < $total - 1) {
        $contenido .= "<button name='indice' value='" . ($indice + 1) . "'>Siguiente &gt;</button>\n";
    } else {
        $contenido .= "<button disabled>Siguiente &gt;</button>\n";
    }

    // Info de posición
    $contenido .= "<p style='margin-top:.5rem;'>Elemento " . ($indice + 1) . " de {$total}</p>\n";
    $contenido .= "</form>\n";

    return $contenido;
}

function generarPaginaHTML(string $titulo, string $contenido): string {
  $res = "<!DOCTYPE html>\n"
    . "<html lang=\"es\">\n"
    . "<head>\n"
    . "  <meta charset=\"UTF-8\">\n"
    . "  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n"
    . "  <title>" . htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8') . "</title>\n"
    . "  <style>\n"
    . "    body{font-family: system-ui, Segoe UI, Roboto, Arial; max-width:720px; margin:2rem auto; padding:0 1rem;}\n"
    . "    form{margin-top:1rem; padding:1rem; border:1px solid #ddd; border-radius:12px;}\n"
    . "    label{display:block; margin:.5rem 0 .25rem;}\n"
    . "    input[type=text], input[type=password]{width:100%; padding:.5rem;}\n"
    . "    input[type=submit]{margin-top:1rem; padding:.5rem 1rem; cursor:pointer;}\n"
    . "  </style>\n"
    . "</head>\n"
    . "<body>\n"
    . $contenido
    . "<hr>\n"
    . "</body>\n"
    . "</html>";
  return $res;
}

function generarFormularioLogin(): string {
  return "\n  <h1>Iniciar sesión</h1>\n"
    . '  <form method="POST" action="' . htmlspecialchars(ACTION_URL, ENT_QUOTES, 'UTF-8') . "\">\n"
    . "    <input type=\"hidden\" name=\"accion\" value=\"login\">\n"
    . "    <label for=\"usuario\">Usuario</label>\n"
    . "    <input id=\"usuario\" type=\"text\" name=\"usuario\" required>\n"
    . "    <label for=\"credencial\">Contraseña</label>\n"
    . "    <input id=\"credencial\" type=\"password\" name=\"credencial\" required>\n"
    . "    <input type=\"submit\" value=\"Iniciar sesión\">\n"
    . "  </form>\n"
    . "  <details style=\"margin-top:1rem;\"><summary>Credenciales de ejemplo</summary>\n"
    . "    <p>admin / admin &nbsp;·&nbsp; test / test</p>\n"
    . "  </details>";
}

function generarLogout(): string {
  return "\n  <form method=\"POST\" action=\"" . htmlspecialchars(ACTION_URL, ENT_QUOTES, 'UTF-8') . "\">\n"
    . "    <input type=\"hidden\" name=\"accion\" value=\"logout\">\n"
    . "    <input type=\"submit\" value=\"Cerrar sesión\">\n"
    . "  </form>";
}
?>
