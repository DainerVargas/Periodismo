<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\CompanyProfile;

class CreateAdminCompanyProfile extends Command
{
    protected $signature = 'admin:create-company-profile';
    protected $description = 'Create company profile for admin user';

    public function handle()
    {
        $admin = User::where('email', 'admin@periodismo.local')->first();

        if (!$admin) {
            $this->error('Admin user not found!');
            return 1;
        }

        if ($admin->companyProfile) {
            $this->info('Admin already has a company profile!');
            return 0;
        }

        CompanyProfile::create([
            'user_id' => $admin->id,
            'company_name' => 'Periodismo Digital',
            'description' => 'Medio de comunicación digital independiente dedicado a la verdad y el análisis profundo de la actualidad.',
            'industry' => 'Medios de Comunicación',
            'website' => 'https://periodismo.local',
            'company_size' => '10-50 empleados',
        ]);

        $this->info('✅ Company profile created successfully for admin!');
        return 0;
    }
}
