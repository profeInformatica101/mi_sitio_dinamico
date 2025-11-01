
<div class="container my-5">
    <h1 class="text-center mb-4">Datos del Navegador y del Servidor</h1>

    <div class="card shadow-lg">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th colspan="2" class="text-center">Datos sobre el Navegador enviados en las Cabeceras HTTP</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Dirección IP del navegador</th>
                            <td><?php echo $_SERVER['REMOTE_ADDR']; ?></td>
                        </tr>
                        <tr>
                            <th>Tipo de navegador</th>
                            <td><?php echo $_SERVER['HTTP_USER_AGENT']; ?></td>
                        </tr>

                        <tr class="table-secondary text-center fw-bold">
                            <td colspan="2">Solicitud HTTP</td>
                        </tr>

                        <tr>
                            <th>Nombre del host</th>
                            <td><?php echo $_SERVER['HTTP_HOST']; ?></td>
                        </tr>
                        <tr>
                            <th>Cadena de consulta (query string)</th>
                            <td><?php echo $_SERVER['QUERY_STRING']; ?></td>
                        </tr>
                        <tr>
                            <th>Método de la solicitud HTTP</th>
                            <td><?php echo $_SERVER['REQUEST_METHOD']; ?></td>
                        </tr>

                        <tr class="table-secondary text-center fw-bold">
                            <td colspan="2">Ubicación del archivo que se está ejecutando</td>
                        </tr>

                        <tr>
                            <th>Raíz del documento</th>
                            <td><?php echo $_SERVER['DOCUMENT_ROOT']; ?></td>
                        </tr>
                        <tr>
                            <th>Ruta desde la raíz del documento</th>
                            <td><?php echo $_SERVER['SCRIPT_NAME']; ?></td>
                        </tr>
                        <tr>
                            <th>Ruta absoluta</th>
                            <td><?php echo $_SERVER['SCRIPT_FILENAME']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="alert alert-info mt-4" role="alert">
        <h4 class="alert-heading">💡 Explicación</h4>
        <p>
            En PHP, la variable <code>$_SERVER</code> es una <strong>variable superglobal</strong>,
            lo que significa que está disponible en cualquier parte del código sin necesidad de ser declarada.
            Contiene información sobre el entorno del servidor y la solicitud HTTP, como la dirección IP del cliente,
            el navegador, el método de la petición (<code>GET</code>, <code>POST</code>), la ruta del archivo actual, entre otros.
        </p>
        <p>
            Cada elemento de <code>$_SERVER</code> se accede mediante un índice entre corchetes.
            Por ejemplo: <code>$_SERVER['REMOTE_ADDR']</code> devuelve la IP del usuario,
            mientras que <code>$_SERVER['HTTP_USER_AGENT']</code> devuelve el tipo de navegador.
        </p>
        <hr>
        <p class="mb-0">
            📘 Puedes consultar la documentación oficial en:
            <a href="https://www.php.net/manual/es/reserved.variables.server.php" target="_blank" class="fw-bold text-decoration-none">
                Documentación de $_SERVER — PHP Manual
            </a>
        </p>
    </div>
</div>
