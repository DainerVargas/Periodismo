<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Opinion;

class OpinionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Opinion::create([
            'author' => 'Ana V. Columnista',
            'title' => 'El silencio de las ciudades',
            'image' => 'a042581f4e29026704d',
            'content' => 'Lorem ipsum...',
        ]);

        Opinion::create([
            'author' => 'Jorge L. Análisis',
            'title' => '¿Hacia dónde va el urbanismo?',
            'image' => 'a042581f4e29026024d',
            'content' => 'Lorem ipsum...',
        ]);

        Opinion::create([
            'author' => 'Marta R. Tech',
            'title' => 'Ética en la era de los algoritmos',
            'image' => 'c042581f4e29026024d',
            'content' => 'Lorem ipsum...',
        ]);

        Opinion::create([
            'author' => 'Ricardo S. Economía',
            'title' => 'Inflación y el bolsillo ciudadano',
            'image' => 'b042581f4e29026024d',
            'content' => 'Análisis sobre el impacto de la inflación...',
        ]);

        Opinion::create([
            'author' => 'Lucía M. Cultura',
            'title' => 'El renacer del teatro local',
            'image' => 'd042581f4e29026024d',
            'content' => 'Crónica sobre la escena teatral...',
        ]);
    }
}
