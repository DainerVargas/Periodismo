<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $cats = [
                ['name' => 'Periodismo & Redacción', 'slug' => 'periodismo-redaccion'],
                ['name' => 'Marketing Digital', 'slug' => 'marketing-digital'],
                ['name' => 'Diseño & Multimedia', 'slug' => 'diseno-multimedia'],
                ['name' => 'Tecnología & Desarrollo', 'slug' => 'tecnologia-desarrollo'],
                ['name' => 'Producción Audiovisual', 'slug' => 'produccion-audiovisual'],
            ];

            foreach ($cats as $cat) {
                \App\Models\JobCategory::firstOrCreate(['slug' => $cat['slug']], $cat);
            }

            // Create Companies
            $companies = [
                [
                    'name' => 'MediaGroup',
                    'email' => 'hr@mediagroup.com',
                    'profile' => [
                        'company_name' => 'MediaGroup Global',
                        'description' => 'Líderes en medios digitales en Latinoamérica, enfocados en innovación y calidad periodística. Nos apasiona contar historias que impactan.',
                        'industry' => 'Medios de Comunicación',
                        'location' => 'Bogotá, Colombia',
                        'website' => 'https://mediagroup.com'
                    ],
                    'jobs' => [
                        [
                            'title' => 'Editor Jefe de Actualidad',
                            'cat_slug' => 'periodismo-redaccion',
                            'salary' => '$4.000.000 - $5.000.000',
                            'type' => 'Indefinido',
                            'desc' => "Estamos buscando un Editor Jefe apasionado para liderar nuestra mesa de redacción de actualidad. \n\nResponsabilidades:\n- Coordinar la agenda diaria.\n- Editar y aprobar artículos de alto impacto.\n- Gestionar un equipo de 5 periodistas.\n\nRequisitos:\n- 5+ años de experiencia.\n- Portafolio comprobable."
                        ],
                        [
                            'title' => 'Videógrafo Documentalista',
                            'cat_slug' => 'produccion-audiovisual',
                            'salary' => '$2.500.000 - $3.000.000',
                            'type' => 'Prestación de Servicios',
                            'desc' => "Buscas contar historias a través del lente? Únete a nuestro equipo de documentales."
                        ]
                    ]
                ],
                [
                    'name' => 'TechTimes',
                    'email' => 'jobs@techtimes.com',
                    'profile' => [
                        'company_name' => 'TechTimes News',
                        'description' => 'El portal de tecnología más leído de la región. Buscamos talento geek y apasionado por la innovación.',
                        'industry' => 'Tecnología',
                        'location' => 'Medellín, Colombia',
                        'website' => 'https://techtimes.com'
                    ],
                    'jobs' => [
                        [
                            'title' => 'Desarrollador Full Stack (Laravel)',
                            'cat_slug' => 'tecnologia-desarrollo',
                            'salary' => '$5.000.000 - $7.000.000',
                            'type' => 'Remoto',
                            'desc' => "Ayúdanos a construir la próxima generación de nuestra plataforma de noticias. Stack: TALL (Tailwind, Alpine, Laravel, Livewire)."
                        ]
                    ]
                ]
            ];

            foreach ($companies as $c) {
                // Check if exists
                $user = \App\Models\User::firstOrCreate(
                    ['email' => $c['email']],
                    [
                        'name' => $c['name'],
                        'password' => bcrypt('password'),
                        'role' => 'company',
                        'slug' => \Illuminate\Support\Str::slug($c['name']) . '-' . rand(10, 99) // Ensure unique slug if name exists
                    ]
                );

                \App\Models\CompanyProfile::updateOrCreate(
                    ['user_id' => $user->id],
                    $c['profile']
                );

                foreach ($c['jobs'] as $job) {
                    $cat = \App\Models\JobCategory::where('slug', $job['cat_slug'])->first();
                    if (!$cat) {
                        dump("Category not found: " . $job['cat_slug']);
                        continue;
                    }
                    \App\Models\JobVacancy::create([
                        'user_id' => $user->id,
                        'job_category_id' => $cat->id,
                        'title' => $job['title'],
                        'slug' => \Illuminate\Support\Str::slug($job['title']) . '-' . rand(1000, 9999),
                        'description' => $job['desc'],
                        'salary_range' => $job['salary'],
                        'contract_type' => $job['type'],
                        'location' => $c['profile']['location'],
                        'status' => 'active',
                        'created_at' => now(),
                    ]);
                }
            }
        } catch (\Exception $e) {
            dump($e->getMessage());
        }
    }
}
