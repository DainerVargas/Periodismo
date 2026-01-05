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
            for ($i = 1; $i <= 5; $i++) {
                Article::create([
                    'title' => "Noticia {$i} de {$category->name}: Impacto e Importancia",
                    'slug' => Str::slug("Noticia {$i} de {$category->name} " . Str::random(5)),
                    'excerpt' => "Este es el resumen de la noticia número {$i} en la categoría de {$category->name}. Analizamos los puntos clave.",
                    'content' => "Contenido completo sobre {$category->name}. El desarrollo de esta noticia permite entender mejor los cambios que se están produciendo en esta área. " . str_repeat("Lorem ipsum dolor sit amet, consectetur adipiscing elit. ", 5),
                    'category_id' => $category->id,
                    'user_id' => $admin->id,
                    'status' => 'published',
                    'published_at' => now()->subHours(rand(1, 48)),
                ]);
            }
        }
    }
}
