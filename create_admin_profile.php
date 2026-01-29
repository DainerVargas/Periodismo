<?php

use App\Models\User;
use App\Models\CompanyProfile;

$admin = User::where('email', 'admin@periodismo.local')->first();

if ($admin && !$admin->companyProfile) {
    CompanyProfile::create([
        'user_id' => $admin->id,
        'company_name' => 'Periodismo Digital',
        'description' => 'Medio de comunicación digital independiente dedicado a la verdad y el análisis profundo de la actualidad.',
        'industry' => 'Medios de Comunicación',
        'website' => 'https://periodismo.local',
        'company_size' => '10-50 empleados',
    ]);
    echo "✅ Perfil de empresa creado para el admin\n";
} else {
    echo "ℹ️ El admin ya tiene perfil de empresa o no existe\n";
}
