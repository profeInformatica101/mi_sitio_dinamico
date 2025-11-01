<?php
// No crear sesión nueva si no existe.
// Comprobar si hay cookie de sesión previa.
$session_name = session_name(); // disponible sin iniciar sesión
$tieneSesionPrevia = !empty($_COOKIE[$session_name]);

if ($tieneSesionPrevia && session_status() !== PHP_SESSION_ACTIVE) {
    session_start(); // solo abrimos si ya existe
}
?>

<?php if ($tieneSesionPrevia && session_status() === PHP_SESSION_ACTIVE): ?>
<div class="container my-5">
    <h1 class="text-center mb-4">Datos de la Sesión</h1>

    <!-- ID de sesión -->
    <div class="card shadow-lg mb-4">
        <div class="card-body">
            <h5 class="card-title text-center fw-bold">Identificador de la Sesión</h5>
            <p class="text-center fs-5 mb-0">
                <?php echo htmlspecialchars(session_id()); ?>
            </p>
        </div>
    </div>

    <!-- Atributos (cookie params) -->
    <div class="card shadow-lg mb-5">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-secondary text-center">
                        <tr>
                            <th colspan="2">Atributos de Configuración de la Sesión</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $params = session_get_cookie_params();
                            foreach ($params as $k => $v):
                        ?>
                            <tr>
                                <th><?php echo htmlspecialchars(ucfirst($k)); ?></th>
                                <td><?php echo htmlspecialchars(is_bool($v) ? ($v ? 'true' : 'false') : (string)$v); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Variables de $_SESSION (si hay) -->
    <?php if (!empty($_SESSION)): ?>
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th colspan="2" class="text-center">Variables almacenadas en $_SESSION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION as $clave => $valor): ?>
                            <tr>
                                <th><?php echo htmlspecialchars($clave); ?></th>
                                <td>
                                    <?php
                                        if (is_array($valor) || is_object($valor)) {
                                            echo '<pre class="mb-0">'.print_r($valor, true).'</pre>';
                                        } else {
                                            echo htmlspecialchars((string)$valor);
                                        }
                                    ?>
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
