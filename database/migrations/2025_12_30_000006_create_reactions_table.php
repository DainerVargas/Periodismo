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
        Schema::create('reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Polimórfico: puede ser para artículos o comentarios
            $table->morphs('reactable');
            
            // Tipo de reacción: like, love, wow, sad, angry, etc.
            $table->enum('type', ['like', 'love', 'wow', 'sad', 'angry'])->default('like');
            
            $table->timestamps();
            
            // Un usuario solo puede tener una reacción por elemento
            $table->unique(['user_id', 'reactable_type', 'reactable_id']);
            
            // Índices

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reactions');
    }
};
