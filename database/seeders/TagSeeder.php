<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'breaking-news' => 'Breaking News',
            'investigacion' => 'Investigación',
            'opinion' => 'Opinión',
            'entrevista' => 'Entrevista',
            'analisis' => 'Análisis',
            'internacional' => 'Internacional',
            'nacional' => 'Nacional',
            'local' => 'Local',
            'clima' => 'Clima',
            'medio-ambiente' => 'Medio Ambiente',
            'educacion' => 'Educación',
            'empleo' => 'Empleo',
            'vivienda' => 'Vivienda',
            'transporte' => 'Transporte',
            'seguridad' => 'Seguridad',
            'derechos-humanos' => 'Derechos Humanos',
            'covid-19' => 'COVID-19',
            'elecciones' => 'Elecciones',
            'corrupcion' => 'Corrupción',
            'justicia' => 'Justicia',
        ];

        foreach ($tags as $slug => $name) {
            DB::table('tags')->insert([
                'name' => $name,
                'slug' => $slug,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
