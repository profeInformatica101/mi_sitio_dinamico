<?php
// No crear sesión nueva si no existe (solo abrir si hay cookie de sesión previa)
$session_name = session_name();
$tieneSesionPrevia = !empty($_COOKIE[$session_name]);

if ($tieneSesionPrevia && session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

?>

<?php if ($tieneSesionPrevia && session_status() === PHP_SESSION_ACTIVE): ?>
<div class="container my-5">
    <h1 class="text-center mb-4"><mark>Variable $_SESSION</mark></h1>

    <!-- ID de sesión -->
    <div class="card shadow-lg mb-4">
        <div class="card-body text-center">
            <h5 class="fw-bold">Identificador de la Sesión</h5>
            <p class="fs-5 mb-0"><?= htmlspecialchars(session_id()) ?></p>
        </div>
    </div>

    <!-- Atributos de configuración -->
    <div class="card shadow-lg mb-5">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Atributo</th>
                            <th>Valor actual</th>
                            <th>Descripción / Para qué sirve</th>
                            <th>Cómo modificar o mostrar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $params = session_get_cookie_params();

                            $explicaciones = [
                                'lifetime' => [
                                    'describe' => 'Duración en segundos de la cookie de sesión. Si es 0, expira al cerrar el navegador.',
                                    'modificar' => "session_set_cookie_params(['lifetime' => 3600]);"
                                ],
                                'path' => [
                                    'describe' => 'Ruta del servidor donde la cookie es válida. Normalmente "/".',
                                    'modificar' => "session_set_cookie_params(['path' => '/miapp']);"
                                ],
                                'domain' => [
                                    'describe' => 'Dominio en el que se envía la cookie. Útil para subdominios.',
                                    'modificar' => "session_set_cookie_params(['domain' => '.midominio.com']);"
                                ],
                                'secure' => [
                                    'describe' => 'Indica si la cookie solo se envía por HTTPS.',
                                    'modificar' => "session_set_cookie_params(['secure' => true]);"
                                ],
                                'httponly' => [
                                    'describe' => 'Evita que JavaScript acceda a la cookie (protege contra XSS).',
                                    'modificar' => "session_set_cookie_params(['httponly' => true]);"
                                ],
                                'samesite' => [
                                    'describe' => 'Controla el envío de cookies entre sitios. Evita ataques CSRF.',
                                    'modificar' => "session_set_cookie_params(['samesite' => 'Strict']);"
                                ]
                            ];

                            foreach ($params as $clave => $valor):
                                $valorMostrado = htmlspecialchars(is_bool($valor) ? ($valor ? 'true' : 'false') : (string)$valor);
                                $info = $explicaciones[$clave] ?? ['describe' => '—', 'modificar' => '—'];
                        ?>
                        <tr>
                            <th><?= ucfirst(htmlspecialchars($clave)) ?></th>
                            <td><?= $valorMostrado ?></td>
                            <td><?= htmlspecialchars($info['describe']) ?></td>
                            <td><code><?= htmlspecialchars($info['modificar']) ?></code></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Variables almacenadas -->
    <?php if (!empty($_SESSION)): ?>
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-secondary text-center">
                        <tr>
                            <th>Nombre de la variable</th>
                            <th>Valor almacenado</th>
                            <th>Cómo mostrar o modificar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION as $clave => $valor): ?>
                        <tr>
                            <th><?= htmlspecialchars($clave) ?></th>
                            <td>
                                <?php
                                    if (is_array($valor) || is_object($valor)) {
                                        echo '<pre class="mb-0">'.print_r($valor, true).'</pre>';
                                    } else {
                                        echo htmlspecialchars((string)$valor);
                                    }
                                ?>
                            </td>
                            <td>
                                <code>
                                    <?= '$' ?>_SESSION['<?= htmlspecialchars($clave) ?>']
                                    <?= isset($valor) ? ' = ' . var_export($valor, true) . ';' : '' ?>
                                </code>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>
