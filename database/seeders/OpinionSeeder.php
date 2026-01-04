<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OpinionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Opinion::create([
            'author' => 'Ana V. Columnista',
            'title' => 'El silencio de las ciudades',
            'image' => 'a042581f4e29026704d', // Placeholder part from original URL
            'content' => 'Lorem ipsum...',
        ]);

        \App\Models\Opinion::create([
            'author' => 'Jorge L. Análisis',
            'title' => '¿Hacia dónde va el urbanismo?',
            'image' => 'a042581f4e29026024d',
            'content' => 'Lorem ipsum...',
        ]);

        \App\Models\Opinion::create([
            'author' => 'Marta R. Tech',
            'title' => 'Ética en la era de los algoritmos',
            'image' => 'c042581f4e29026024d',
            'content' => 'Lorem ipsum...',
        ]);
    }
}
