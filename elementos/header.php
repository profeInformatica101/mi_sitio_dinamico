<header class="text-center bg-white p-3 rounded shadow-sm">
  <h1 class="text-primary">🌟 Bienvenido a mi primer sitio PHP 🌟</h1>
  <p class="text-muted">Usando include() por primera vez</p>
</header>
<nav>
  <ul class="nav nav-pills">
    <?php foreach ($menu as $clave => $texto): ?>
      <li class="nav-item">
        <a class="nav-link <?= ($p === $clave) ? 'active' : '' ?>"
          href="index.php?p=<?= $clave ?>">
          <?= htmlspecialchars($texto) ?>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</nav>