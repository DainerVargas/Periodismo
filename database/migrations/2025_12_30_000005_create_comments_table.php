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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('comments')->onDelete('cascade'); // Para respuestas/hilos
            
            $table->text('content');
            
            // Moderación
            $table->enum('status', ['pending', 'approved', 'rejected', 'spam'])->default('approved');
            $table->boolean('is_pinned')->default(false); // Comentarios destacados
            
            // Contadores
            $table->integer('likes_count')->default(0);
            
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index(['article_id', 'status']);
            $table->index('parent_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
