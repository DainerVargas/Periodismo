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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            
            // Polimórfico: puede asociarse a artículos u otros modelos
            $table->morphs('mediable');
            
            $table->string('file_name');
            $table->string('file_path');
            $table->string('disk')->default('public'); // local, s3, etc.
            $table->string('mime_type');
            $table->unsignedBigInteger('size'); // Tamaño en bytes
            
            // Metadatos
            $table->string('alt_text')->nullable();
            $table->text('caption')->nullable();
            $table->json('metadata')->nullable(); // Para dimensiones, duración, etc.
            
            // Tipo de medio
            $table->enum('type', ['image', 'video', 'audio', 'document'])->default('image');
            
            // Orden en galerías
            $table->integer('order')->default(0);
            
            $table->timestamps();
            
            // Índices

            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
