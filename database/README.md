# Diseño de Base de Datos - Plataforma de Periodismo Digital

## 📊 Estructura General

Esta base de datos está diseñada para soportar una plataforma de periodismo digital completa con las siguientes características:

- ✅ Gestión de contenidos (artículos/noticias)
- ✅ Sistema de usuarios con roles (Admin, Editor, Usuario)
- ✅ Categorización y etiquetado
- ✅ Comentarios con hilos anidados
- ✅ Sistema de reacciones (like, love, wow, sad, angry)
- ✅ Gestión multimedia
- ✅ Analíticas de vistas
- ✅ SEO optimizado

## 🗄️ Tablas Principales

### 1. **users**
Gestión de usuarios del sistema con tres roles:
- **admin**: Acceso total al sistema
- **editor**: Puede crear y gestionar artículos
- **user**: Usuario registrado que puede comentar y reaccionar

**Campos destacados:**
- `role`: enum (admin, editor, user)
- `avatar`, `bio`, `website`: Información de perfil
- `twitter`, `facebook`, `instagram`: Redes sociales
- `is_active`: Estado de la cuenta
- `last_login_at`: Última sesión

### 2. **categories**
Categorías principales para organizar noticias (Política, Economía, Tecnología, etc.)

**Campos destacados:**
- `name`, `slug`: Identificación
- `description`: Descripción de la categoría
- `color`: Color hex para la UI (#3B82F6)
- `icon`: Nombre del icono (heroicons)
- `order`: Para ordenar en la interfaz
- `is_active`: Activar/desactivar categorías

### 3. **tags**
Etiquetas para clasificación detallada de artículos

**Campos destacados:**
- `name`, `slug`: Identificación
- `is_active`: Estado

### 4. **articles** (Tabla Principal)
Contenido de noticias/artículos con funcionalidades completas

**Campos de contenido:**
- `title`, `slug`: Identificación
- `excerpt`: Resumen corto
- `content`: Contenido completo (longText)
- `featured_image`: Imagen principal
- `reading_time`: Tiempo estimado de lectura

**SEO:**
- `meta_title`, `meta_description`, `meta_keywords`

**Estado y visibilidad:**
- `status`: enum (draft, published, archived)
- `is_featured`: Destacado en portada
- `allow_comments`: Habilitar/deshabilitar comentarios
- `published_at`: Fecha de publicación programada

**Contadores (caché para performance):**
- `views_count`
- `comments_count`
- `reactions_count`

**Relaciones:**
- `user_id`: Autor del artículo
- `category_id`: Categoría principal

### 5. **article_tag** (Tabla Pivote)
Relación muchos a muchos entre artículos y etiquetas

### 6. **comments**
Sistema de comentarios con soporte para hilos anidados

**Campos destacados:**
- `parent_id`: Para crear hilos de respuestas
- `status`: enum (pending, approved, rejected, spam)
- `is_pinned`: Destacar comentarios importantes
- `likes_count`: Contador de likes

**Relaciones:**
- `article_id`: Artículo comentado
- `user_id`: Autor del comentario
- `parent_id`: Comentario padre (para respuestas)

### 7. **reactions**
Sistema de reacciones tipo Facebook/LinkedIn

**Polimórfico:** Puede aplicarse a artículos o comentarios

**Tipos de reacciones:**
- `like`: Me gusta
- `love`: Me encanta
- `wow`: Me asombra
- `sad`: Me entristece
- `angry`: Me enoja

**Restricción:** Un usuario solo puede tener una reacción activa por elemento

### 8. **media**
Gestión de archivos multimedia

**Polimórfico:** Puede asociarse a artículos u otros modelos

**Tipos soportados:**
- `image`: Imágenes
- `video`: Videos
- `audio`: Audio
- `document`: Documentos PDF, etc.

**Campos destacados:**
- `file_path`, `disk`: Almacenamiento (local, S3, etc.)
- `mime_type`, `size`: Información del archivo
- `alt_text`, `caption`: Metadatos
- `metadata`: JSON para dimensiones, duración, etc.
- `order`: Para galerías de imágenes

### 9. **article_views**
Registro de vistas para analíticas

**Campos destacados:**
- `user_id`: Usuario autenticado (nullable para visitantes)
- `ip_address`, `user_agent`: Información del visitante
- `session_id`: Para evitar duplicados
- `country`, `city`: Datos geográficos
- `referrer`: Origen del tráfico
- `viewed_at`: Timestamp de la vista

## 🔗 Diagrama de Relaciones

```
users (1) ──────────── (N) articles
  │                         │
  │                         ├─── (N) comments
  │                         ├─── (N) reactions (polimórfico)
  │                         ├─── (N) media (polimórfico)
  │                         ├─── (N) article_views
  │                         └─── (1) category
  │
  ├─────────── (N) comments
  └─────────── (N) reactions (polimórfico)

articles (N) ──────────── (N) tags
              (via article_tag)

categories (1) ────────── (N) articles

comments (1) ──────────── (N) comments (self-reference)
           └──────────── (N) reactions (polimórfico)
```

## 📋 Índices Implementados

### Performance Optimizations:
- **articles**: Índices en `status`, `published_at`, `is_featured`, y compuesto `[category_id, status]`
- **comments**: Índices en `[article_id, status]`, `parent_id`
- **reactions**: Índice en `[reactable_type, reactable_id]`
- **media**: Índice en `[mediable_type, mediable_id]`, `type`
- **article_views**: Índices en `[article_id, viewed_at]`, `session_id`, `viewed_at`
- **users**: Índice en `role`

## 🔒 Características de Seguridad

1. **Soft Deletes**: Implementado en `articles` y `comments` para recuperación de datos
2. **Cascade Deletes**: Configurado en relaciones para mantener integridad referencial
3. **Unique Constraints**: 
   - `categories.slug`
   - `tags.slug`
   - `articles.slug`
   - `article_tag.[article_id, tag_id]`
   - `reactions.[user_id, reactable_type, reactable_id]`

## 🚀 Datos Iniciales (Seeders)

### UserSeeder
- Admin: `admin@periodismo.local` / `password`
- Editor: `editor@periodismo.local` / `password`
- User: `user@periodismo.local` / `password`
- +10 usuarios generados con Factory

### CategorySeeder
8 categorías predefinidas:
1. Política (#DC2626 - rojo)
2. Economía (#16A34A - verde)
3. Tecnología (#2563EB - azul)
4. Deportes (#F59E0B - ámbar)
5. Cultura (#8B5CF6 - púrpura)
6. Ciencia (#06B6D4 - cian)
7. Salud (#EC4899 - rosa)
8. Sociedad (#84CC16 - lima)

### TagSeeder
20 etiquetas comunes:
- breaking-news, investigación, opinión, entrevista, análisis
- internacional, nacional, local
- clima, medio-ambiente, educación, empleo, vivienda, transporte
- seguridad, derechos-humanos, covid-19, elecciones, corrupción, justicia

## 📦 Instalación y Uso

```bash
# 1. Instalar dependencias
composer install

# 2. Configurar base de datos en .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=periodismo
DB_USERNAME=root
DB_PASSWORD=

# 3. Ejecutar migraciones
php artisan migrate

# 4. Poblar con datos iniciales
php artisan db:seed

# O todo junto:
php artisan migrate:fresh --seed
```

## 🎯 Próximos Pasos

1. ✅ **Diseño de Base de Datos** (Completado)
2. ⏳ **Crear Modelos Eloquent** con relaciones
3. ⏳ **Implementar Componentes Livewire** para CRUD
4. ⏳ **Diseñar Interfaz de Usuario** moderna y responsive
5. ⏳ **Implementar Sistema de Autenticación**
6. ⏳ **Crear Sistema de Permisos** (Policies/Gates)
7. ⏳ **Implementar API REST** (opcional)

## 📝 Notas Técnicas

### Campos JSON:
- `media.metadata`: Almacena información adicional flexible (dimensiones de imagen, duración de video, etc.)

### Timestamps:
- Todas las tablas tienen `created_at` y `updated_at` automáticos

### Relaciones Polimórficas:
- **reactions**: `reactable_type`, `reactable_id`
- **media**: `mediable_type`, `mediable_id`

Esto permite que estos modelos se relacionen con múltiples tipos de entidades.
