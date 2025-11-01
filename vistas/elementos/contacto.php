<?php
/**
 * ========================================================
 * 📬 Vista: contacto.php
 * Propósito: ejecutar el seeding de usuarios de prueba.
 * Autor: profeinformatica101
 * ========================================================
 */

// Ruta correcta al seeder
require_once __DIR__ . '/../../nucleo/Datos.php';

// Ejecutar silenciosamente el seeding
ob_start();
$filas = seedUsuariosDatos();   // o Utiles::seedUsuarios();
ob_end_clean();

// Mostrar resultado simple (en texto o HTML)
echo "<div style='font-family:monospace; background:#111; color:#0f0; padding:1rem; border-radius:8px;'>";
echo "🌱 Ejecutado <strong>seedUsuariosDatos()</strong><br>";
echo "✅ Usuarios insertados/actualizados: <strong>{$filas}</strong><br>";
echo "📂 Archivo origen: <em>nucleo/Datos.php</em>";
echo "</div>";

exit;
