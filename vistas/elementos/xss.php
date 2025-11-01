<?php
/**
 * ------------------------------------------------------------
 * 🔒 escaparHTML(string $texto)
 * ------------------------------------------------------------
 * Escapa caracteres especiales del texto para evitar ataques XSS.
 *
 * 💡 Ejemplo:
 *   echo escaparHTML("<script>alert('xss')</script>");
 *   → mostrará: &lt;script&gt;alert('xss')&lt;/script&gt;
 *
 * 🚀 Parámetros:
 *   - $texto: cadena original que podría contener HTML o JS.
 *
 * 🔐 Seguridad:
 *   - ENT_QUOTES → convierte comillas simples y dobles.
 *   - ENT_SUBSTITUTE → sustituye caracteres inválidos en UTF-8.
 *   - 'UTF-8' → garantiza codificación segura.
 *
 * 📘 Usar SIEMPRE al imprimir contenido no controlado por el programador.
 */

function escaparHTML(string $texto): string {
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * 🧠 Explicación:
 * 
 * La función escaparHTML() sirve para proteger tu aplicación web de ataques
 * de tipo XSS (Cross-Site Scripting), un tipo de vulnerabilidad muy común
 * en sitios que muestran datos introducidos por los usuarios sin sanitizarlos.
 * 
 * 📌 ¿Qué hace htmlspecialchars()?
 * Convierte caracteres especiales como:
 *   - <  → &lt;
 *   - >  → &gt;
 *   - "  → &quot;
 *   - '  → &#039;
 *   - &  → &amp;
 * 
 * De esta forma, si un usuario intenta inyectar código HTML o JavaScript
 * (por ejemplo: <script>alert('Hacked!')</script>),
 * el navegador mostrará el texto literalmente en lugar de ejecutarlo.
 * 
 * 🧾 Uso recomendado:
 *   echo escaparHTML($dato_usuario);
 * 
 * ⚙️ Parámetros usados:
 *   - ENT_QUOTES: convierte tanto comillas simples como dobles.
 *   - ENT_SUBSTITUTE: reemplaza caracteres inválidos en UTF-8.
 *   - 'UTF-8': asegura compatibilidad con caracteres internacionales.
 */
?>

<?php
$nombre = "<script>alert('Hola');</script>";
echo "<p>Nombre del usuario: " . escaparHTML($nombre) . "</p>";
echo "<p>Nombre del usuario: " . $nombre . "</p>";

?>