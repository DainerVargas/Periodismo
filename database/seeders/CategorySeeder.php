<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Política',
                'slug' => 'politica',
                'description' => 'Noticias sobre política nacional e internacional',
                'color' => '#DC2626',
                'icon' => 'flag',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Economía',
                'slug' => 'economia',
                'description' => 'Análisis económico, mercados y finanzas',
                'color' => '#16A34A',
                'icon' => 'chart-bar',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'Tecnología',
                'slug' => 'tecnologia',
                'description' => 'Innovación, gadgets y tendencias tecnológicas',
                'color' => '#2563EB',
                'icon' => 'cpu-chip',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'name' => 'Deportes',
                'slug' => 'deportes',
                'description' => 'Noticias deportivas, resultados y análisis',
                'color' => '#F59E0B',
                'icon' => 'trophy',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'name' => 'Cultura',
                'slug' => 'cultura',
                'description' => 'Arte, música, literatura y entretenimiento',
                'color' => '#8B5CF6',
                'icon' => 'paint-brush',
                'is_active' => true,
                'order' => 5,
            ],
            [
                'name' => 'Ciencia',
                'slug' => 'ciencia',
                'description' => 'Descubrimientos científicos e investigación',
                'color' => '#06B6D4',
                'icon' => 'beaker',
                'is_active' => true,
                'order' => 6,
            ],
            [
                'name' => 'Salud',
                'slug' => 'salud',
                'description' => 'Salud, bienestar y medicina',
                'color' => '#EC4899',
                'icon' => 'heart',
                'is_active' => true,
                'order' => 7,
            ],
            [
                'name' => 'Sociedad',
                'slug' => 'sociedad',
                'description' => 'Temas sociales, educación y comunidad',
                'color' => '#84CC16',
                'icon' => 'users',
                'is_active' => true,
                'order' => 8,
            ],
        ];

        foreach ($categories as $category) {
            $category['created_at'] = now();
            $category['updated_at'] = now();
            DB::table('categories')->insert($category);
        }
    }
}
