# 🏗️ Arquitectura DDD - Plataforma de Periodismo Digital

## 📐 Estructura del Proyecto

```
src/
├── UserManagement/          # Bounded Context: Gestión de Usuarios
│   ├── Application/         # Casos de uso y lógica de aplicación
│   ├── Domain/              # Lógica de negocio pura
│   │   ├── Entities/        # Entidades del dominio (User, Profile)
│   │   ├── Repositories/    # Interfaces de repositorios
│   │   └── ValueObjects/    # Objetos de valor (Email, Role, etc.)
│   └── Infrastructure/      # Implementación técnica
│       ├── Controllers/     # Controladores HTTP
│       ├── Models/          # Modelos Eloquent
│       ├── Persistence/     # Implementación de repositorios
│       ├── Migrations/      # Migraciones de BD
│       └── Seeders/         # Datos iniciales
│
├── Content/                 # Bounded Context: Gestión de Contenidos
│   ├── Application/
│   │   ├── Actions/         # Acciones de aplicación (CreateArticle, etc.)
│   │   └── Responses/       # DTOs de respuesta
│   ├── Domain/
│   │   ├── Entities/        # Article, Category, Tag, Media
│   │   ├── Repositories/    # Interfaces
│   │   └── ValueObjects/    # Slug, ArticleStatus, SEO, etc.
│   └── Infrastructure/
│       ├── Controllers/
│       ├── Models/
│       ├── Persistence/
│       ├── Migrations/
│       ├── Seeders/
│       ├── Factories/
│       └── Routes/
│
├── Engagement/              # Bounded Context: Interacción de Usuarios
│   ├── Application/
│   ├── Domain/
│   │   ├── Entities/        # Comment, Reaction, View
│   │   └── Repositories/
│   └── Infrastructure/
│       ├── Models/
│       ├── Migrations/
│       └── Seeders/
│
└── Shared/                  # Código compartido entre contextos
    ├── Domain/              # Interfaces y abstracciones comunes
    └── Infrastructure/      # Utilidades compartidas
```

## 🎯 Bounded Contexts

### 1. **UserManagement** (Gestión de Usuarios)
**Responsabilidad:** Autenticación, autorización, perfiles de usuario

**Entidades:**
- `User` - Usuario del sistema
- `Profile` - Perfil extendido del usuario

**Value Objects:**
- `Email` - Email validado
- `Role` - Rol del usuario (Admin, Editor, User)
- `SocialLinks` - Enlaces a redes sociales

**Casos de Uso:**
- Registrar usuario
- Autenticar usuario
- Actualizar perfil
- Gestionar roles y permisos

---

### 2. **Content** (Gestión de Contenidos)
**Responsabilidad:** Creación, edición y publicación de artículos

**Entidades:**
- `Article` - Artículo/noticia
- `Category` - Categoría de contenido
- `Tag` - Etiqueta
- `Media` - Archivo multimedia

**Value Objects:**
- `Slug` - URL amigable
- `ArticleStatus` - Estado (draft, published, archived)
- `SEO` - Metadatos SEO
- `PublishingSchedule` - Programación de publicación

**Casos de Uso:**
- Crear artículo
- Publicar artículo
- Programar publicación
- Gestionar categorías y tags
- Subir multimedia

---

### 3. **Engagement** (Interacción)
**Responsabilidad:** Comentarios, reacciones, analíticas

**Entidades:**
- `Comment` - Comentario
- `Reaction` - Reacción (like, love, etc.)
- `View` - Vista de artículo

**Value Objects:**
- `ReactionType` - Tipo de reacción
- `CommentStatus` - Estado del comentario
- `ViewMetadata` - Metadatos de la vista

**Casos de Uso:**
- Comentar artículo
- Responder comentario
- Reaccionar a contenido
- Registrar vista
- Moderar comentarios

---

### 4. **Shared** (Compartido)
**Responsabilidad:** Código reutilizable entre contextos

**Contenido:**
- Interfaces comunes
- Excepciones base
- Utilidades
- Traits compartidos

---

## 🔄 Flujo de Datos (DDD)

```
HTTP Request
    ↓
Controller (Infrastructure)
    ↓
Action/UseCase (Application)
    ↓
Domain Service (Domain)
    ↓
Entity (Domain)
    ↓
Repository Interface (Domain)
    ↓
Repository Implementation (Infrastructure)
    ↓
Eloquent Model (Infrastructure)
    ↓
Database
```

---

## 📦 Capas de la Arquitectura

### **Domain Layer** (Capa de Dominio)
- ✅ **Sin dependencias** de frameworks
- ✅ Lógica de negocio pura
- ✅ Entidades y Value Objects
- ✅ Interfaces de repositorios
- ✅ Eventos de dominio

### **Application Layer** (Capa de Aplicación)
- ✅ Casos de uso del sistema
- ✅ Orquestación de la lógica de dominio
- ✅ DTOs (Data Transfer Objects)
- ✅ Validación de entrada

### **Infrastructure Layer** (Capa de Infraestructura)
- ✅ Implementaciones técnicas
- ✅ Acceso a base de datos (Eloquent)
- ✅ Controladores HTTP
- ✅ Servicios externos
- ✅ Migraciones y Seeders

---

## 🎨 Patrones Implementados

### 1. **Repository Pattern**
```php
// Domain
interface ArticleRepositoryInterface {
    public function findById(int $id): ?Article;
    public function save(Article $article): void;
}

// Infrastructure
class EloquentArticleRepository implements ArticleRepositoryInterface {
    public function findById(int $id): ?Article {
        return ArticleModel::find($id);
    }
}
```

### 2. **Value Objects**
```php
class Slug {
    private string $value;
    
    public function __construct(string $value) {
        $this->validate($value);
        $this->value = $value;
    }
    
    private function validate(string $value): void {
        // Validación de slug
    }
}
```

### 3. **Domain Events**
```php
class ArticlePublished {
    public function __construct(
        public readonly int $articleId,
        public readonly DateTime $publishedAt
    ) {}
}
```

### 4. **Factory Pattern**
```php
class ArticleFactory {
    public static function create(array $data): Article {
        return new Article(
            title: $data['title'],
            slug: new Slug($data['slug']),
            content: $data['content']
        );
    }
}
```

---

## 🔗 Comunicación Entre Contextos

### **Anti-Corruption Layer (ACL)**
Los contextos se comunican a través de:
- **Eventos de dominio** (Domain Events)
- **APIs internas** (Application Services)
- **DTOs** (Data Transfer Objects)

Ejemplo:
```php
// Content emite evento
event(new ArticlePublished($article->id));

// Engagement escucha evento
class UpdateArticleViewsListener {
    public function handle(ArticlePublished $event) {
        // Actualizar contadores
    }
}
```

---

## 📊 Mapeo de Tablas a Bounded Contexts

| Tabla | Bounded Context |
|-------|----------------|
| `users` | UserManagement |
| `articles` | Content |
| `categories` | Content |
| `tags` | Content |
| `article_tag` | Content |
| `media` | Content |
| `comments` | Engagement |
| `reactions` | Engagement |
| `article_views` | Engagement |

---

## 🚀 Ventajas de esta Arquitectura

### ✅ **Separación de Responsabilidades**
Cada bounded context tiene una responsabilidad clara y bien definida.

### ✅ **Escalabilidad**
Los contextos pueden evolucionar independientemente.

### ✅ **Testabilidad**
La lógica de dominio es fácil de testear sin dependencias.

### ✅ **Mantenibilidad**
Código organizado y fácil de entender.

### ✅ **Flexibilidad**
Fácil agregar nuevos bounded contexts (ej: Analytics, Notifications).

---

## 📝 Próximos Pasos de Implementación

### Fase 1: Domain Layer
1. Crear entidades de dominio
2. Definir value objects
3. Crear interfaces de repositorios
4. Definir eventos de dominio

### Fase 2: Application Layer
1. Implementar casos de uso
2. Crear DTOs
3. Definir validadores

### Fase 3: Infrastructure Layer
1. Implementar repositorios con Eloquent
2. Crear controladores
3. Configurar rutas
4. Migrar datos existentes

### Fase 4: Integration
1. Configurar eventos entre contextos
2. Implementar middleware
3. Crear tests de integración

---

## 🔧 Configuración de Autoload

Actualizar `composer.json`:

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

Ejecutar:
```bash
composer dump-autoload
```

---

## 📚 Recursos y Referencias

- **Domain-Driven Design** - Eric Evans
- **Implementing Domain-Driven Design** - Vaughn Vernon
- **Clean Architecture** - Robert C. Martin
- **Hexagonal Architecture** - Alistair Cockburn

---

**Última actualización:** 2025-12-29  
**Versión:** 1.0  
**Estado:** Estructura base creada ✅
