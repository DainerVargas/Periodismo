<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable(); // Resumen corto
            $table->longText('content'); // Contenido completo
            
            // Relaciones
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Autor
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            
            // Multimedia
            $table->string('featured_image')->nullable(); // Imagen principal
            $table->string('featured_image_alt')->nullable(); // Texto alternativo
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            
            // Estado y visibilidad
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->boolean('is_featured')->default(false); // Destacado en portada
            $table->boolean('allow_comments')->default(true);
            
            // Programación de publicación
            $table->timestamp('published_at')->nullable();
            
            // Contadores (caché)
            $table->integer('views_count')->default(0);
            $table->integer('comments_count')->default(0);
            $table->integer('reactions_count')->default(0);
            
            // Tiempo de lectura estimado (en minutos)
            $table->integer('reading_time')->default(0);
            
            $table->timestamps();
            $table->softDeletes(); // Borrado suave
            
            // Índices para optimizar consultas
            $table->index('status');
            $table->index('published_at');
            $table->index('is_featured');
            $table->index(['category_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
