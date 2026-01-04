# ⚡ INICIO RÁPIDO

## 🚀 Instalación en 3 Pasos

### 1️⃣ Crear Base de Datos

**Windows (PowerShell):**
```powershell
.\install-database.ps1
```

**Linux/Mac:**
```bash
chmod +x install-database.sh
./install-database.sh
```

**O manualmente:**
```bash
mysql -u root -p < database/create_database.sql
```

---

### 2️⃣ Configurar Proyecto

```bash
# Instalar dependencias (si composer ya funcionó)
composer dump-autoload

# Configurar .env
cp .env.example .env

# Editar .env:
# DB_DATABASE=periodismo
# DB_USERNAME=root
# DB_PASSWORD=

# Generar clave
php artisan key:generate
```

---

### 3️⃣ Iniciar Servidor

```bash
php artisan serve
```

Visita: **http://localhost:8000**

---

## 👥 Credenciales

| Email | Password |
|-------|----------|
| admin@periodismo.local | password |
| editor@periodismo.local | password |
| user@periodismo.local | password |

---

## 📚 Documentación

- `README.md` - Documentación principal
- `ARCHITECTURE.md` - Arquitectura DDD
- `SETUP.md` - Guía completa de instalación
- `PROYECTO_COMPLETADO.md` - Resumen de lo implementado

---

## 🏗️ Estructura DDD

```
src/
├── UserManagement/    # Usuarios y autenticación
├── Content/           # Artículos, categorías, tags
├── Engagement/        # Comentarios, reacciones, vistas
└── Shared/            # Código compartido
```

---

## 📊 Base de Datos

**Tablas creadas:** 12  
**Datos iniciales:**
- 3 usuarios + 10 aleatorios
- 8 categorías
- 20 etiquetas

---

## ⚠️ Problemas Comunes

### Composer pide autenticación
```bash
composer install --ignore-platform-reqs --no-scripts
composer dump-autoload
```

### Error de base de datos
Verifica que MySQL esté corriendo en Laragon

### Error de clave
```bash
php artisan key:generate
```

---

## 🎯 Próximos Pasos

1. ✅ Base de datos creada
2. ✅ Estructura DDD implementada
3. ⏳ Crear entidades de dominio
4. ⏳ Implementar casos de uso
5. ⏳ Diseñar interfaz de usuario

---

**¿Necesitas ayuda?** Consulta `SETUP.md` para la guía completa.
