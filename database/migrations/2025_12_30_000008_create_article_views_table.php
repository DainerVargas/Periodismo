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
        Schema::create('article_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Null para visitantes
            
            // Información del visitante
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('session_id')->nullable();
            
            // Datos geográficos (opcional, para analytics)
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            
            // Referencia (de dónde vino el visitante)
            $table->string('referrer')->nullable();
            
            $table->timestamp('viewed_at');
            
            // Índices para analytics
            $table->index(['article_id', 'viewed_at']);
            $table->index('session_id');
            $table->index('viewed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_views');
    }
};
