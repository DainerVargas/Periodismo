<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $categories = Category::all();

        if ($categories->isEmpty()) return;

        foreach ($categories as $category) {
            Article::create([
                'title' => "Noticia de prueba en {$category->name}",
                'slug' => Str::slug("Noticia de prueba en {$category->name}"),
                'excerpt' => "Este es un breve resumen de lo que está sucediendo en la sección de {$category->name}.",
                'content' => "Contenido extenso de una noticia de prueba para demostrar el funcionamiento del sistema editorial.",
                'category_id' => $category->id,
                'user_id' => $admin->id,
                'status' => 'published',
                'published_at' => now(),
            ]);
        }
    }
}
