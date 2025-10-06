    <header class="text-center bg-white p-3 rounded shadow-sm">
  <h1 class="text-primary">🌟 Bienvenido a mi primer sitio PHP 🌟</h1>
  <!-- agrega una barra de navegación Bootstrap  -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="http://localhost/dashboard/mi_sitio_dinamico-main">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="producto.php">Productos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contacto.php">Contacto</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <p class="text-muted">Usando include() por primera vez</p>
</header>
    <!--Crear una tabla de contactos-->
    <table border="1">
      <thead class="table-primary">
        <tr>
          <th>Nombre</th>
          <th>Email</th>
          <th>Teléfono</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>John Doe</td>
          <td>johndoe@example.com</td>
          <td>666-123-4567</td>
        </tr>
        <tr>
          <td>Jane Smith</td>
          <td>janesmith@example.com</td>
          <td>777-987-6543</td>
        </tr>
        <tr>
          <td>Mike Johnson</td>
          <td>mikejohnson@example.com</td>
          <td>888-555-1111</td>
        </tr>
      </tbody>
    </table>