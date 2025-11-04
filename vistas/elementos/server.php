<?php
/**
 * Devuelve la IP del visitante.
 * - Intenta primero obtener una IP pública desde cabeceras como X-Forwarded-For.
 * - Si no encuentra una pública, devuelve la primera IP válida disponible.
 * - Si no hay ninguna, devuelve null.
 *
 * Nota: las cabeceras tipo X-Forwarded-For pueden ser falsificadas. Si estás detrás de
 * un reverse proxy (nginx, Cloudflare, etc.) configura el proxy para pasar la IP real
 * y marca en tu app qué proxies son de confianza.
 */
function getUserIp(array $server = null): ?string {
    $s = $server ?? $_SERVER;

    // Cabeceras que a menudo contienen la IP original
    $candidates = [
        'HTTP_X_FORWARDED_FOR', // lista CSV: cliente, proxy1, proxy2...
        'HTTP_CLIENT_IP',
        'HTTP_X_REAL_IP',
        'HTTP_CF_CONNECTING_IP', // Cloudflare
        'REMOTE_ADDR'
    ];

    // 1) Intentar obtener una IP *pública* válida (no privada/reservada)
    foreach ($candidates as $key) {
        if (empty($s[$key])) continue;

        if ($key === 'HTTP_X_FORWARDED_FOR') {
            $list = explode(',', $s[$key]);
            foreach ($list as $ip) {
                $ip = trim($ip);
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
        } else {
            $ip = trim($s[$key]);
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                return $ip;
            }
        }
    }

    // 2) Si no hay pública, devolver la primera IP válida (incluso privada/local)
    foreach ($candidates as $key) {
        if (empty($s[$key])) continue;

        if ($key === 'HTTP_X_FORWARDED_FOR') {
            $list = explode(',', $s[$key]);
            foreach ($list as $ip) {
                $ip = trim($ip);
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        } else {
            $ip = trim($s[$key]);
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }
    }

    return null;
}
?>

<div class="container my-5">
    <h1><mark>Variable $_SERVER</mark></h1>
    <h2 class="text-center mb-4">Datos del Navegador y del Servidor</h2>

    <div class="card shadow-lg">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Descripción</th>
                            <th>Valor</th>
                            <th>Código PHP</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Dirección IP del navegador</th>
                            <td><?= htmlspecialchars($_SERVER['REMOTE_ADDR'] ?? 'No disponible') ?></td>
                            <td><code>$_SERVER['REMOTE_ADDR']</code></td>
                        </tr>
                        <tr>
                            <th>Tipo de navegador</th>
                            <td><?= htmlspecialchars($_SERVER['HTTP_USER_AGENT'] ?? 'Desconocido') ?></td>
                            <td><code>$_SERVER['HTTP_USER_AGENT']</code></td>
                        </tr>
                        <tr>
                            <th>Página de referencia</th>
                            <td><?= htmlspecialchars($_SERVER['HTTP_REFERER'] ?? 'No especificada') ?></td>
                            <td><code>$_SERVER['HTTP_REFERER']</code></td>
                        </tr>

                        <tr class="table-secondary text-center fw-bold">
                            <td colspan="3">Solicitud HTTP</td>
                        </tr>

                        <tr>
                            <th>Nombre del host</th>
                            <td><?= htmlspecialchars($_SERVER['HTTP_HOST'] ?? 'No disponible') ?></td>
                            <td><code>$_SERVER['HTTP_HOST']</code></td>
                        </tr>
                        <tr>
                            <th>Ruta solicitada (URI)</th>
                            <td><?= htmlspecialchars($_SERVER['REQUEST_URI'] ?? '') ?></td>
                            <td><code>$_SERVER['REQUEST_URI']</code></td>
                        </tr>
                        <tr>
                            <th>Cadena de consulta (query string)</th>
                            <td><?= htmlspecialchars($_SERVER['QUERY_STRING'] ?? '') ?></td>
                            <td><code>$_SERVER['QUERY_STRING']</code></td>
                        </tr>
                        <tr>
                            <th>Método de la solicitud HTTP</th>
                            <td><?= htmlspecialchars($_SERVER['REQUEST_METHOD'] ?? '') ?></td>
                            <td><code>$_SERVER['REQUEST_METHOD']</code></td>
                        </tr>

                        <tr class="table-secondary text-center fw-bold">
                            <td colspan="3">Información del Servidor</td>
                        </tr>

                        <tr>
                            <th>Nombre del servidor</th>
                            <td><?= htmlspecialchars($_SERVER['SERVER_NAME'] ?? '') ?></td>
                            <td><code>$_SERVER['SERVER_NAME']</code></td>
                        </tr>
                        <tr>
                            <th>Software del servidor</th>
                            <td><?= htmlspecialchars($_SERVER['SERVER_SOFTWARE'] ?? '') ?></td>
                            <td><code>$_SERVER['SERVER_SOFTWARE']</code></td>
                        </tr>
                        <tr>
                            <th>Puerto del servidor</th>
                            <td><?= htmlspecialchars($_SERVER['SERVER_PORT'] ?? '') ?></td>
                            <td><code>$_SERVER['SERVER_PORT']</code></td>
                        </tr>

                        <tr class="table-secondary text-center fw-bold">
                            <td colspan="3">Ubicación del archivo que se está ejecutando</td>
                        </tr>

                        <tr>
                            <th>Raíz del documento</th>
                            <td><?= htmlspecialchars($_SERVER['DOCUMENT_ROOT'] ?? '') ?></td>
                            <td><code>$_SERVER['DOCUMENT_ROOT']</code></td>
                        </tr>
                        <tr>
                            <th>Ruta desde la raíz del documento</th>
                            <td><?= htmlspecialchars($_SERVER['SCRIPT_NAME'] ?? '') ?></td>
                            <td><code>$_SERVER['SCRIPT_NAME']</code></td>
                        </tr>
                        <tr>
                            <th>Ruta absoluta</th>
                            <td><?= htmlspecialchars($_SERVER['SCRIPT_FILENAME'] ?? '') ?></td>
                            <td><code>$_SERVER['SCRIPT_FILENAME']</code></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$auth = $_SESSION['auth'] ?? null;

// Guardar IP en la sesión (opcional)
$_SESSION['ip'] = getUserIp();
?>
    <div class="alert alert-info mt-4" role="alert">
        <h4 class="alert-heading">💡 Explicación</h4>
        <p>
            La variable <code>$_SERVER</code> en PHP es una <strong>superglobal</strong> que contiene información
            sobre el servidor web y la solicitud HTTP actual, como la IP del cliente, el navegador,
            el método de petición (<code>GET</code>, <code>POST</code>), y las rutas de los archivos ejecutados.
        </p>
        <p>
            Cada elemento se accede mediante un índice. Por ejemplo:
            <code>$_SERVER['REMOTE_ADDR']</code> devuelve la IP del usuario,
            mientras que <code>$_SERVER['HTTP_USER_AGENT']</code> devuelve el tipo de navegador.
        </p>
        <hr>
        <p class="mb-0">
            📘 Documentación oficial:
            <a href="https://www.php.net/manual/es/reserved.variables.server.php" target="_blank" class="fw-bold text-decoration-none">
                Documentación de $_SERVER — PHP Manual
            </a>
        </p>
    </div>
</div>
