<?php
/**
 * ========================================================
 * 🧠 vistas/elementos/xss.php
 * --------------------------------------------------------
 * Demostración XSS — 2 formularios (Seguro/Inseguro)
 * - Form A: usa htmlspecialchars (seguro)
 * - Form B: sin escapar (inseguro) → SOLO con ?p=xss&unsafe=1
 * - Ejemplos listos para copiar
 * - Panel de parámetros GET / POST (escapado)
 *
 * ⚠️ EJEMPLO DOCENTE — ELIMINAR DESPUÉS DE LA PRÁCTICA
 * ========================================================
 */

/* --------------------------------------------------------
 * Helper para escapar contenido HTML
 * -------------------------------------------------------- */
function escaparHTML(string $t): string {
    return htmlspecialchars($t, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/* --------------------------------------------------------
 * Ejemplo base
 * -------------------------------------------------------- */
$nombre = "<script>alert('Hola');</script>";
echo "<p>Nombre del usuario (seguro): " . escaparHTML($nombre) . "</p>";
echo "<p>Nombre del usuario (inseguro): " . $nombre . "</p>";

/* --------------------------------------------------------
 * Estado inseguro desde la query
 * -------------------------------------------------------- */
$p = $_GET['p'] ?? 'xss';
$unsafeEnabled = (isset($_GET['unsafe']) && $_GET['unsafe'] === '1');

/* Acción del formulario conservando los parámetros */
$action = '?p=' . urlencode((string)$p) . ($unsafeEnabled ? '&unsafe=1' : '');

/* --------------------------------------------------------
 * Lectura de formularios
 * -------------------------------------------------------- */
$form          = $_POST['form'] ?? '';
$textoSeguro   = '';
$textoInseguro = '';

if ($form === 'seguro') {
    $textoSeguro = trim((string)($_POST['texto_seguro'] ?? ''));
}
if ($form === 'inseguro' && ($unsafeEnabled || ($_POST['unsafe'] ?? '') === '1')) {
    // Intencional: sin escapar para evidenciar XSS (solo en modo inseguro)
    $textoInseguro = trim((string)($_POST['texto_inseguro'] ?? ''));
}

/* --------------------------------------------------------
 * Ejemplos de payloads listos para copiar
 * -------------------------------------------------------- */
$payloads = [
    'Alert clásico' => "<script>alert('XSS')</script>",
    'Banner visual' => <<<'PAY'
<script>
(function(){
  const banner = document.createElement('div');
  banner.textContent = '⚠️ DEMO: banner insertado vía XSS (solo laboratorio)';
  banner.style = 'position:fixed;top:0;left:0;right:0;background:#fff3cd;color:#856404;padding:.6rem;text-align:center;z-index:99999;border-bottom:1px solid #ffe8a1;';
  document.body.prepend(banner);
})();
</script>
PAY
,
    'Modal simple' => <<<'PAY'
<script>
(function(){
  const wrap = document.createElement('div');
  wrap.innerHTML =
    '<div style="position:fixed;inset:0;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,.5);z-index:99999;">' +
      '<div style="background:#fff;padding:1rem;border-radius:8px;max-width:90%">' +
        '<h3>Demo XSS — Modal</h3><p>Solo visual (demo).</p>' +
        '<div style="text-align:right"><button id="cerrarDemo" style="padding:.35rem .7rem;border:1px solid #ccc;border-radius:6px;background:#f8f9fa">Cerrar</button></div>' +
      '</div></div>';
  document.body.append(wrap);
  wrap.querySelector('#cerrarDemo')?.addEventListener('click', () => wrap.remove());
})();
</script>
PAY
,
    'Cambio de fondo' => <<<'PAY'
<script>
(function(){
  const old = document.body.style.backgroundColor;
  document.body.style.transition = 'background .3s';
  document.body.style.backgroundColor = '#fee';
  setTimeout(()=> document.body.style.backgroundColor = old, 2000);
})();
</script>
PAY
];

/* --------------------------------------------------------
 * Panel de parámetros escapados
 * -------------------------------------------------------- */
$verGET  = escaparHTML(json_encode($_GET,  JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
$verPOST = escaparHTML(json_encode($_POST, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Demo XSS — Seguro vs. Inseguro</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    pre.snip{white-space:pre-wrap;word-break:break-word;background:#f8f9fa;padding:.8rem;border-radius:6px;border:1px solid #e9ecef}
    .muted-small{font-size:.85rem;color:#6c757d}
    .code-pill{font-family:ui-monospace,SFMono-Regular,Menlo,Consolas,monospace}
  </style>
</head>
<body class="bg-light">
<div class="container py-4">

  <div class="alert alert-secondary" role="alert">
    <strong>⚠️ Página de ejemplo docente.</strong> Úsala solo en laboratorio y elimínala después.
  </div>

  <header class="mb-3 d-flex align-items-center gap-3">
    <h1 class="h4 mb-0">Demostración XSS — 2 formularios</h1>
    <small class="text-muted">
      Form B (inseguro):
      <?php if ($unsafeEnabled): ?>
        <span class="badge bg-danger">Activo</span>
        <a href="?p=xss" class="ms-1">Desactivar</a>
      <?php else: ?>
        <a href="?p=xss&unsafe=1" class="btn btn-sm btn-outline-danger ms-1">Activar (solo laboratorio)</a>
      <?php endif; ?>
    </small>
  </header>

  <!-- Panel de parámetros de entrada -->
  <div class="card mb-4">
    <div class="card-header bg-light"><strong>Parámetros de entrada recibidos</strong></div>
    <div class="card-body">
      <div class="row g-3">
        <div class="col-md-6">
          <h6>GET</h6>
          <pre class="snip"><?= $verGET ?></pre>
        </div>
        <div class="col-md-6">
          <h6>POST</h6>
          <pre class="snip"><?= $verPOST ?></pre>
        </div>
      </div>
      <p class="muted-small mb-0">Se muestran escapados para evitar ejecución de HTML o JavaScript.</p>
    </div>
  </div>

  <div class="row g-4">
    <!-- A: Seguro -->
    <div class="col-lg-6">
      <div class="card shadow-sm">
        <div class="card-header bg-success text-white">Formulario A — Seguro (usa htmlspecialchars)</div>
        <div class="card-body">
          <form method="post" action="<?= escaparHTML($action) ?>" novalidate>
            <input type="hidden" name="form" value="seguro">
            <div class="mb-3">
              <label for="texto_seguro" class="form-label">Texto (se mostrará escapado)</label>
              <input id="texto_seguro" name="texto_seguro" type="text" class="form-control"
                     placeholder="<script>alert('XSS')</script>"
                     value="<?= escaparHTML($textoSeguro) ?>">
            </div>
            <button class="btn btn-success" type="submit">Mostrar (seguro)</button>
          </form>

          <?php if ($textoSeguro !== ''): ?>
            <hr>
            <p class="mb-1"><strong>Salida segura:</strong></p>
            <div class="p-2 border rounded bg-white"><?= escaparHTML($textoSeguro) ?></div>
            <p class="muted-small mt-2">✅ Convertido a texto con htmlspecialchars(). No se ejecuta HTML ni JS.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- B: Inseguro -->
    <div class="col-lg-6">
      <div class="card shadow-sm">
        <div class="card-header bg-danger text-white">Formulario B — Inseguro (sin escapar)</div>
        <div class="card-body">
          <div class="alert alert-warning">
            <strong>Advertencia:</strong> este formulario puede ejecutar código. Úsalo solo en entornos controlados.
          </div>

          <?php if (!$unsafeEnabled): ?>
            <p class="muted-small">Desactivado. Actívalo con <span class="code-pill">?p=xss&unsafe=1</span>.</p>
          <?php endif; ?>

          <form method="post" action="<?= escaparHTML($action) ?>" novalidate>
            <input type="hidden" name="form" value="inseguro">
            <input type="hidden" name="unsafe" value="<?= $unsafeEnabled ? '1' : '0' ?>">
            <div class="mb-3">
              <label for="texto_inseguro" class="form-label">Texto (se mostrará sin escapar)</label>
              <textarea id="texto_inseguro" name="texto_inseguro" class="form-control" rows="5"
                        placeholder="<script>alert('XSS')</script>" <?= $unsafeEnabled ? '' : 'disabled' ?>><?= escaparHTML($textoInseguro) ?></textarea>
            </div>
            <button class="btn btn-outline-danger" type="submit" <?= $unsafeEnabled ? '' : 'disabled' ?>>Mostrar (inseguro)</button>
          </form>

          <?php if ($textoInseguro !== '' && $unsafeEnabled): ?>
            <hr>
            <p class="mb-1"><strong>Salida insegura (puede ejecutar JS):</strong></p>
            <div class="p-3 border rounded bg-white">
              <?php
                // INTENCIONAL: sin escapar para demostrar XSS
                echo $textoInseguro;
              ?>
            </div>
            <p class="muted-small mt-2">⚠️ Si incluyes <code>&lt;script&gt;</code>, el navegador lo ejecutará.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Ejemplos listos para copiar -->
  <section class="mt-4">
    <div class="card shadow-sm">
      <div class="card-header bg-secondary text-white">Ejemplos listos para copiar y pegar</div>
      <div class="card-body">
        <p class="muted-small">Usa el botón <strong>Copiar</strong> y pega el contenido en el formulario que quieras.</p>

        <?php foreach ($payloads as $titulo => $code): ?>
          <?php $b64 = base64_encode($code); ?>
          <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
              <strong><?= escaparHTML($titulo) ?></strong>
              <button type="button"
                      class="btn btn-sm btn-outline-primary btn-copiar"
                      data-b64="<?= escaparHTML($b64) ?>">
                Copiar
              </button>
            </div>
            <pre class="snip mt-2"><?= escaparHTML($code) ?></pre>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <div class="alert alert-info mt-4" role="alert">
    <h4 class="alert-heading">💡 ¿Qué hace htmlspecialchars()?</h4>
    <p>Convierte los caracteres especiales <code>&lt; &gt; " ' &amp;</code> en entidades HTML para que el navegador los muestre como texto y no los ejecute.</p>
    <p class="mb-0">Más info: 
      <a href="https://www.php.net/manual/es/function.htmlspecialchars.php" target="_blank">Manual de PHP</a>
    </p>
  </div>

  <footer class="mt-3 text-muted small">
    Ejemplo docente — eliminar después de la práctica.
  </footer>
</div>

<script>
function b64DecodeUnicode(str) {
  try {
    return decodeURIComponent(Array.prototype.map.call(atob(str), function(c) {
      return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));
  } catch (e) {
    try { return atob(str); } catch (_) { return ''; }
  }
}

document.addEventListener('click', (e) => {
  const btn = e.target.closest('.btn-copiar');
  if (!btn) return;
  const b64 = btn.getAttribute('data-b64') || '';
  const text = b64DecodeUnicode(b64);
  if (!text) {
    alert('No se pudo decodificar el ejemplo.');
    return;
  }
  navigator.clipboard.writeText(text).then(() => {
    const old = btn.textContent;
    btn.textContent = 'Copiado ✓';
    setTimeout(()=> btn.textContent = old, 1000);
  }).catch(()=> alert('No se pudo copiar — revisa permisos del portapapeles.'));
});
</script>
</body>
</html>
