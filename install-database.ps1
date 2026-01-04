# ============================================
# Script de Instalación de Base de Datos
# Plataforma de Periodismo Digital
# PowerShell Script para Windows/Laragon
# ============================================

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  Instalación de Base de Datos" -ForegroundColor Cyan
Write-Host "  Plataforma de Periodismo Digital" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Configuración
$DB_NAME = "periodismo"
$DB_USER = "root"
$SQL_FILE = "database\create_database.sql"

# Verificar si el archivo SQL existe
if (-not (Test-Path $SQL_FILE)) {
    Write-Host "❌ Error: No se encuentra el archivo $SQL_FILE" -ForegroundColor Red
    exit 1
}

Write-Host "📋 Configuración:" -ForegroundColor Yellow
Write-Host "   Base de datos: $DB_NAME" -ForegroundColor White
Write-Host "   Usuario: $DB_USER" -ForegroundColor White
Write-Host ""

# Solicitar contraseña
$DB_PASS = Read-Host "🔑 Ingresa la contraseña de MySQL (Enter si no tiene)" -AsSecureString
$DB_PASS_Plain = [Runtime.InteropServices.Marshal]::PtrToStringAuto([Runtime.InteropServices.Marshal]::SecureStringToBSTR($DB_PASS))

Write-Host ""
Write-Host "🔄 Ejecutando script SQL..." -ForegroundColor Yellow

# Ejecutar el script SQL
try {
    if ($DB_PASS_Plain -eq "") {
        # Sin contraseña
        $result = mysql -u $DB_USER < $SQL_FILE 2>&1
    } else {
        # Con contraseña
        $result = mysql -u $DB_USER -p"$DB_PASS_Plain" < $SQL_FILE 2>&1
    }
    
    if ($LASTEXITCODE -eq 0) {
        Write-Host ""
        Write-Host "✅ ¡Base de datos creada exitosamente!" -ForegroundColor Green
        Write-Host ""
        Write-Host "📊 Resumen:" -ForegroundColor Cyan
        Write-Host "   ✓ Base de datos: $DB_NAME" -ForegroundColor Green
        Write-Host "   ✓ 12 tablas creadas" -ForegroundColor Green
        Write-Host "   ✓ Índices optimizados" -ForegroundColor Green
        Write-Host "   ✓ Datos iniciales insertados" -ForegroundColor Green
        Write-Host ""
        Write-Host "👥 Usuarios de prueba creados:" -ForegroundColor Cyan
        Write-Host "   Admin:  admin@periodismo.local  / password" -ForegroundColor White
        Write-Host "   Editor: editor@periodismo.local / password" -ForegroundColor White
        Write-Host "   User:   user@periodismo.local   / password" -ForegroundColor White
        Write-Host ""
        Write-Host "📁 Datos iniciales:" -ForegroundColor Cyan
        Write-Host "   ✓ 3 usuarios" -ForegroundColor Green
        Write-Host "   ✓ 8 categorías" -ForegroundColor Green
        Write-Host "   ✓ 20 etiquetas" -ForegroundColor Green
        Write-Host ""
        Write-Host "🚀 Próximos pasos:" -ForegroundColor Yellow
        Write-Host "   1. Configura tu archivo .env" -ForegroundColor White
        Write-Host "   2. Ejecuta: php artisan key:generate" -ForegroundColor White
        Write-Host "   3. Ejecuta: composer dump-autoload" -ForegroundColor White
        Write-Host "   4. Ejecuta: php artisan serve" -ForegroundColor White
        Write-Host ""
    } else {
        Write-Host ""
        Write-Host "❌ Error al crear la base de datos" -ForegroundColor Red
        Write-Host $result -ForegroundColor Red
        exit 1
    }
} catch {
    Write-Host ""
    Write-Host "❌ Error: $_" -ForegroundColor Red
    exit 1
}

Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
