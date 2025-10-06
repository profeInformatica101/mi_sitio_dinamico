#!/bin/bash
# ===========================================================
# Script para preparar permisos de desarrollo PHP
# Compatible con VS Code + Apache/XAMPP
# ===========================================================

# Ruta base del proyecto
BASE_DIR="$(cd "$(dirname "$0")" && pwd)"

# Detectar carpeta base (si el script está en raíz o subcarpeta)
if [ -d "$BASE_DIR/elementos" ]; then
  PROYECTO="$BASE_DIR"
elif [ -d "$BASE_DIR/mi_sitio_dinamico" ]; then
  PROYECTO="$BASE_DIR/mi_sitio_dinamico"
else
  echo "❌ No se encuentra la carpeta 'mi_sitio_dinamico' ni 'elementos'."
  exit 1
fi

echo "📁 Proyecto detectado: $PROYECTO"

# Usuario local (para VS Code)
USUARIO_LOCAL=$(whoami)

# Usuario del servidor web
if id www-data &>/dev/null; then
  USUARIO_WEB="www-data"
elif id daemon &>/dev/null; then
  USUARIO_WEB="daemon"
else
  USUARIO_WEB="$USUARIO_LOCAL"
fi

echo "👤 Usuario local: $USUARIO_LOCAL"
echo "🌐 Usuario web: $USUARIO_WEB"

# ===========================================================
# Asignar propietario y grupo
# ===========================================================
sudo chown -R "$USUARIO_LOCAL":"$USUARIO_WEB" "$PROYECTO"

# ===========================================================
# Establecer permisos seguros:
#   - Carpetas: 755 (lectura/ejecución para Apache)
#   - Archivos: 644 (lectura para Apache)
# ===========================================================
sudo find "$PROYECTO" -type d -exec chmod 755 {} \;
sudo find "$PROYECTO" -type f -exec chmod 644 {} \;

# ===========================================================
# Asegurar que los scripts sean ejecutables
# ===========================================================
sudo find "$PROYECTO" -type f -name "*.sh" -exec chmod +x {} \;

echo
echo "✅ Permisos aplicados correctamente:"
echo "   Propietario → $USUARIO_LOCAL (edita con VS Code)"
echo "   Grupo       → $USUARIO_WEB (lee Apache)"
echo "   Carpetas    → 755"
echo "   Archivos    → 644"
echo
echo "📂 Proyecto listo. Si Apache sigue dando error 403, ejecuta:"
echo "   sudo systemctl restart apache2"
echo
echo "💡 Consejo: si usas XAMPP, ejecuta:"
echo "   sudo /opt/lampp/lampp restart"
echo
echo "🚀 Ahora puedes abrir el proyecto en Visual Studio Code:"
echo "   code $PROYECTO"
