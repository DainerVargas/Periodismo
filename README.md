# 📰 Plataforma de Periodismo Digital

Una plataforma moderna de periodismo digital construida con **Laravel 12** y arquitectura **DDD (Domain-Driven Design)**.

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![DDD](https://img.shields.io/badge/Architecture-DDD-blue?style=for-the-badge)

---

## ✨ Características

### 📝 Gestión de Contenidos
- ✅ Editor de artículos con contenido rico
- ✅ Categorías y etiquetas personalizables
- ✅ Publicación programada
- ✅ Borradores y artículos archivados
- ✅ Sistema de multimedia (imágenes, videos, audio)
- ✅ SEO optimizado (meta tags, slugs amigables)

### 👥 Gestión de Usuarios
- ✅ Sistema de roles (Admin, Editor, Usuario)
- ✅ Perfiles de usuario completos
- ✅ Integración con redes sociales
- ✅ Autenticación y autorización

### 💬 Engagement
- ✅ Sistema de comentarios con hilos anidados
- ✅ 5 tipos de reacciones (like, love, wow, sad, angry)
- ✅ Moderación de comentarios
- ✅ Analíticas de vistas con geolocalización

### 🎨 Diseño
- ✅ Interfaz moderna y responsive
- ✅ Categorías con colores personalizados
- ✅ Artículos destacados
- ✅ Tiempo de lectura estimado

---

## 🏗️ Arquitectura

Este proyecto implementa **Domain-Driven Design (DDD)** con **Bounded Contexts**:

```
src/
├── UserManagement/     # Gestión de usuarios y autenticación
├── Content/            # Artículos, categorías, tags, multimedia
├── Engagement/         # Comentarios, reacciones, vistas
└── Shared/             # Código compartido
```

Cada bounded context sigue la estructura:
- **Domain**: Lógica de negocio pura (Entities, Value Objects, Repositories)
- **Application**: Casos de uso (Actions, Responses)
- **Infrastructure**: Implementación técnica (Models, Controllers, Migrations)

📖 Ver documentación completa: [ARCHITECTURE.md](ARCHITECTURE.md)

---

## 📊 Base de Datos

### Tablas Principales

| Tabla | Descripción | Bounded Context |
|-------|-------------|----------------|
| `users` | Usuarios del sistema | UserManagement |
| `articles` | Artículos/noticias | Content |
| `categories` | Categorías de contenido | Content |
| `tags` | Etiquetas | Content |
| `comments` | Comentarios | Engagement |
| `reactions` | Reacciones (polimórfico) | Engagement |
| `media` | Archivos multimedia (polimórfico) | Content |
| `article_views` | Analíticas de vistas | Engagement |

📖 Ver documentación completa: [database/README.md](database/README.md)

---

## 🚀 Instalación Rápida

### 1. Clonar repositorio
```bash
git clone <repository-url>
cd Periodismo
```

### 2. Crear base de datos
```bash
# Opción A: Usando el script SQL
mysql -u root -p < database/create_database.sql

# Opción B: Manual
mysql -u root -p -e "CREATE DATABASE periodismo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 3. Instalar dependencias
```bash
composer install
npm install
```

### 4. Configurar entorno
```bash
cp .env.example .env
php artisan key:generate
```

Edita `.env`:
```env
DB_DATABASE=periodismo
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Migrar datos (si no usaste el script SQL)
```bash
php artisan migrate:fresh --seed
```

### 6. Iniciar servidor
```bash
php artisan serve
npm run dev
```

Visita: http://localhost:8000

📖 Ver guía completa: [SETUP.md](SETUP.md)

---

## 👥 Credenciales de Prueba

| Rol | Email | Password |
|-----|-------|----------|
| **Admin** | admin@periodismo.local | password |
| **Editor** | editor@periodismo.local | password |
| **Usuario** | user@periodismo.local | password |

---

## 📁 Estructura del Proyecto

```
Periodismo/
├── app/                    # Código Laravel tradicional
├── src/                    # Arquitectura DDD
│   ├── UserManagement/     # BC: Gestión de usuarios
│   ├── Content/            # BC: Gestión de contenidos
│   ├── Engagement/         # BC: Interacción de usuarios
│   └── Shared/             # Código compartido
├── database/
│   ├── migrations/         # Migraciones de BD
│   ├── seeders/            # Datos iniciales
│   ├── factories/          # Factories para testing
│   ├── create_database.sql # Script SQL completo
│   └── README.md           # Documentación de BD
├── resources/
│   ├── views/              # Vistas Blade
│   ├── css/                # Estilos
│   └── js/                 # JavaScript
├── routes/                 # Rutas de la aplicación
├── tests/                  # Tests automatizados
├── ARCHITECTURE.md         # Documentación de arquitectura
├── SETUP.md                # Guía de instalación
└── README.md               # Este archivo
```

---

## 🛠️ Tecnologías Utilizadas

### Backend
- **Laravel 12** - Framework PHP
- **MySQL 8.0** - Base de datos
- **PHP 8.2** - Lenguaje de programación

### Frontend
- **Blade** - Motor de plantillas
- **Livewire** - Componentes reactivos (próximamente)
- **Tailwind CSS** - Framework CSS (próximamente)
- **Alpine.js** - JavaScript reactivo (próximamente)

### Arquitectura
- **DDD** - Domain-Driven Design
- **Repository Pattern** - Abstracción de datos
- **Value Objects** - Objetos inmutables
- **Domain Events** - Comunicación entre contextos

---

## 📈 Características Técnicas

### Performance
- ✅ 15+ índices de base de datos optimizados
- ✅ Contadores en caché (views, comments, reactions)
- ✅ Índices compuestos para queries comunes
- ✅ Full-text search en artículos

### Seguridad
- ✅ Soft deletes para recuperación de datos
- ✅ Cascade deletes para integridad referencial
- ✅ Unique constraints
- ✅ Validación de datos
- ✅ Preparado para implementar Policies

### Escalabilidad
- ✅ Arquitectura modular (Bounded Contexts)
- ✅ Separación de responsabilidades
- ✅ Fácil agregar nuevos contextos
- ✅ Preparado para microservicios

---

## 🎯 Roadmap

### Fase 1: Base ✅
- [x] Diseño de base de datos
- [x] Estructura DDD
- [x] Migraciones y seeders
- [x] Documentación

### Fase 2: Domain Layer ⏳
- [ ] Crear entidades de dominio
- [ ] Implementar value objects
- [ ] Definir interfaces de repositorios
- [ ] Crear eventos de dominio

### Fase 3: Application Layer ⏳
- [ ] Implementar casos de uso
- [ ] Crear DTOs
- [ ] Validadores

### Fase 4: Infrastructure Layer ⏳
- [ ] Implementar repositorios
- [ ] Crear controladores
- [ ] Configurar rutas
- [ ] Componentes Livewire

### Fase 5: Frontend ⏳
- [ ] Diseño de interfaz
- [ ] Componentes reutilizables
- [ ] Sistema de diseño
- [ ] Responsive design

### Fase 6: Features Avanzadas ⏳
- [ ] API REST
- [ ] Sistema de notificaciones
- [ ] Analytics dashboard
- [ ] Búsqueda avanzada
- [ ] Exportación de contenido

---

## 🧪 Testing

```bash
# Ejecutar tests
php artisan test

# Con coverage
php artisan test --coverage
```

---

## 📝 Documentación

- [ARCHITECTURE.md](ARCHITECTURE.md) - Arquitectura DDD completa
- [SETUP.md](SETUP.md) - Guía de instalación paso a paso
- [database/README.md](database/README.md) - Documentación de base de datos
- [DATABASE_DESIGN_COMPLETED.md](DATABASE_DESIGN_COMPLETED.md) - Resumen del diseño

---

## 🤝 Contribuir

Las contribuciones son bienvenidas. Por favor:

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

---

## 📄 Licencia

Este proyecto está bajo la licencia MIT. Ver el archivo `LICENSE` para más detalles.

---

## 👨‍💻 Autor

Desarrollado con ❤️ para la comunidad de periodismo digital.

---

## 🙏 Agradecimientos

- Laravel Framework
- Domain-Driven Design Community
- Open Source Community

---

**Última actualización:** 2025-12-29  
**Versión:** 1.0.0  
**Estado:** En desarrollo activo 🚀
