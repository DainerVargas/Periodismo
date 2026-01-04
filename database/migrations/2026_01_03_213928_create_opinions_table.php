<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('opinions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('image')->nullable(); // URL or path
            $table->text('content')->nullable(); // For the actual opinion text if linked
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opinions');
    }
};
