<?php
/**
 * Función segura para escapar texto y prevenir ataques XSS
 * 
 * Esta función actúa como un "wrapper" (envoltorio) de htmlspecialchars(),
 * garantizando que todo el texto se convierta correctamente a entidades HTML,
 * utilizando la codificación UTF-8 por defecto.
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