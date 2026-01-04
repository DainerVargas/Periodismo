# 🚀 Guía de Instalación - Plataforma de Periodismo Digital

## 📋 Requisitos Previos

- PHP 8.2 o superior
- MySQL 8.0 o superior
- Composer
- Node.js y NPM (para assets)
- Laragon (o XAMPP/WAMP)

---

## 🗄️ Paso 1: Crear Base de Datos

### Opción A: Usando el Script SQL (Recomendado)

1. **Abrir MySQL en Laragon:**
   - Inicia Laragon
   - Click en "Database" → "MySQL"
   - O usa HeidiSQL/phpMyAdmin

2. **Ejecutar el script:**

```bash
# Desde la terminal de Laragon
mysql -u root -p < database/create_database.sql
```

O manualmente:
- Abre `database/create_database.sql`
- Copia todo el contenido
- Pégalo en tu cliente MySQL y ejecuta

### Opción B: Usando Artisan (después de composer install)

```bash
# Crear base de datos manualmente primero
mysql -u root -p -e "CREATE DATABASE periodismo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Luego ejecutar migraciones
php artisan migrate:fresh --seed
```

---

## 📦 Paso 2: Instalar Dependencias

### Resolver problema de autenticación de Composer

Si Composer pide autenticación de GitHub:

**Opción 1: Configurar token de GitHub**
```bash
# 1. Crear token en: https://github.com/settings/tokens
# 2. Configurar en composer:
composer config --global github-oauth.github.com TU_TOKEN_AQUI
# 3. Instalar:
composer install
```

**Opción 2: Omitir autenticación**
```bash
composer install --ignore-platform-reqs --no-scripts
composer dump-autoload
```

---

## ⚙️ Paso 3: Configurar .env

Edita el archivo `.env`:

```env
APP_NAME="Periodismo Digital"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_TIMEZONE=America/Bogota
APP_URL=http://periodismo.test

# Base de datos
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=periodismo
DB_USERNAME=root
DB_PASSWORD=

# Otros servicios...
```

Genera la clave de aplicación:
```bash
php artisan key:generate
```

---

## 🔧 Paso 4: Configurar Autoload para DDD

Actualiza `composer.json`:

```json
{
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "Src\\UserManagement\\": "src/UserManagement/",
            "Src\\Content\\": "src/Content/",
            "Src\\Engagement\\": "src/Engagement/",
            "Src\\Shared\\": "src/Shared/",
            "Database\\Factories\\": "database/factories/",
            "Database\\Seeders\\": "database/seeders/"
        }
    }
}
```

Ejecuta:
```bash
composer dump-autoload
```

---

## 🎨 Paso 5: Instalar Assets Frontend

```bash
npm install
npm run dev
```

---

## ✅ Paso 6: Verificar Instalación

### Verificar base de datos:
```bash
php artisan db:show
php artisan db:table users
```

### Verificar datos iniciales:
```sql
USE periodismo;
SELECT * FROM users;
SELECT * FROM categories;
SELECT * FROM tags;
```

### Iniciar servidor:
```bash
php artisan serve
```

Visita: http://localhost:8000

---

## 👥 Credenciales de Prueba

| Rol | Email | Password |
|-----|-------|----------|
| Admin | admin@periodismo.local | password |
| Editor | editor@periodismo.local | password |
| User | user@periodismo.local | password |

---

## 🐛 Solución de Problemas

### Error: "vendor/autoload.php not found"
```bash
composer install
```

### Error: "No application encryption key"
```bash
php artisan key:generate
```

### Error: "SQLSTATE[HY000] [1049] Unknown database"
```bash
# Crear base de datos manualmente
mysql -u root -p -e "CREATE DATABASE periodismo;"
```

### Error: Composer pide autenticación
Ver "Paso 2: Instalar Dependencias"

---

## 📊 Estructura de Carpetas Creada

```
src/
├── UserManagement/
│   ├── Application/
│   ├── Domain/
│   │   ├── Entities/
│   │   ├── Repositories/
│   │   └── ValueObjects/
│   └── Infrastructure/
│       ├── Controllers/
│       ├── Models/
│       ├── Persistence/
│       ├── Migrations/
│       └── Seeders/
├── Content/
│   ├── Application/
│   │   ├── Actions/
│   │   └── Responses/
│   ├── Domain/
│   │   ├── Entities/
│   │   ├── Repositories/
│   │   └── ValueObjects/
│   └── Infrastructure/
│       ├── Controllers/
│       ├── Models/
│       ├── Persistence/
│       ├── Migrations/
│       ├── Seeders/
│       ├── Factories/
│       └── Routes/
├── Engagement/
│   ├── Application/
│   ├── Domain/
│   │   ├── Entities/
│   │   └── Repositories/
│   └── Infrastructure/
│       ├── Models/
│       ├── Migrations/
│       └── Seeders/
└── Shared/
    ├── Domain/
    └── Infrastructure/
```

---

## 🚀 Próximos Pasos

1. ✅ Base de datos creada
2. ✅ Estructura DDD implementada
3. ⏳ Crear entidades de dominio
4. ⏳ Implementar repositorios
5. ⏳ Crear controladores
6. ⏳ Diseñar interfaz de usuario

---

## 📞 Soporte

Para más información, consulta:
- `ARCHITECTURE.md` - Documentación de arquitectura DDD
- `database/README.md` - Documentación de base de datos
- `DATABASE_DESIGN_COMPLETED.md` - Resumen del diseño

---

**Última actualización:** 2025-12-29  
**Versión:** 1.0
