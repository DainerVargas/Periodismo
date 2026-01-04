#!/bin/bash

# ============================================
# Script de Instalación de Base de Datos
# Plataforma de Periodismo Digital
# Bash Script para Linux/Mac
# ============================================

echo "========================================"
echo "  Instalación de Base de Datos"
echo "  Plataforma de Periodismo Digital"
echo "========================================"
echo ""

# Configuración
DB_NAME="periodismo"
DB_USER="root"
SQL_FILE="database/create_database.sql"

# Verificar si el archivo SQL existe
if [ ! -f "$SQL_FILE" ]; then
    echo "❌ Error: No se encuentra el archivo $SQL_FILE"
    exit 1
fi

echo "📋 Configuración:"
echo "   Base de datos: $DB_NAME"
echo "   Usuario: $DB_USER"
echo ""

# Solicitar contraseña
read -sp "🔑 Ingresa la contraseña de MySQL (Enter si no tiene): " DB_PASS
echo ""
echo ""

echo "🔄 Ejecutando script SQL..."

# Ejecutar el script SQL
if [ -z "$DB_PASS" ]; then
    # Sin contraseña
    mysql -u "$DB_USER" < "$SQL_FILE"
else
    # Con contraseña
    mysql -u "$DB_USER" -p"$DB_PASS" < "$SQL_FILE"
fi

if [ $? -eq 0 ]; then
    echo ""
    echo "✅ ¡Base de datos creada exitosamente!"
    echo ""
    echo "📊 Resumen:"
    echo "   ✓ Base de datos: $DB_NAME"
    echo "   ✓ 12 tablas creadas"
    echo "   ✓ Índices optimizados"
    echo "   ✓ Datos iniciales insertados"
    echo ""
    echo "👥 Usuarios de prueba creados:"
    echo "   Admin:  admin@periodismo.local  / password"
    echo "   Editor: editor@periodismo.local / password"
    echo "   User:   user@periodismo.local   / password"
    echo ""
    echo "📁 Datos iniciales:"
    echo "   ✓ 3 usuarios"
    echo "   ✓ 8 categorías"
    echo "   ✓ 20 etiquetas"
    echo ""
    echo "🚀 Próximos pasos:"
    echo "   1. Configura tu archivo .env"
    echo "   2. Ejecuta: php artisan key:generate"
    echo "   3. Ejecuta: composer dump-autoload"
    echo "   4. Ejecuta: php artisan serve"
    echo ""
else
    echo ""
    echo "❌ Error al crear la base de datos"
    exit 1
fi

echo "========================================"
echo ""
