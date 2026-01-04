<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin principal
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@periodismo.local',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'admin',
            'bio' => 'Administrador principal del sistema',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Editor de ejemplo
        User::create([
            'name' => 'María García',
            'email' => 'editor@periodismo.local',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'editor',
            'bio' => 'Periodista y editora con 10 años de experiencia en medios digitales',
            'twitter' => '@mariagarcia',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Usuario regular de ejemplo
        User::create([
            'name' => 'Juan Pérez',
            'email' => 'user@periodismo.local',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'user',
            'bio' => 'Lector apasionado de noticias y actualidad',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Más usuarios de prueba
        User::factory(10)->create();
    }
}
