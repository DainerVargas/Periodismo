<?php

namespace App\Livewire\Jobs\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\CompanyProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CompanyProfileForm extends Component
{
    use WithFileUploads;

    public $company_name;
    public $description;
    public $website;
    public $location;
    public $industry;
    public $size;
    public $logo;
    public $existing_logo;

    protected $rules = [
        'company_name' => 'required|string|max:255',
        'description' => 'required|string',
        'website' => 'nullable|url|max:255',
        'location' => 'required|string|max:255',
        'industry' => 'nullable|string|max:255',
        'size' => 'nullable|string|max:255',
        'logo' => 'nullable|image|max:1024', // 1MB Max
    ];

    public function mount()
    {
        $profile = Auth::user()->companyProfile;

        if ($profile) {
            $this->company_name = $profile->company_name;
            $this->description = $profile->description;
            $this->website = $profile->website;
            $this->location = $profile->location;
            $this->industry = $profile->industry;
            $this->size = $profile->size;
            $this->existing_logo = $profile->logo_path;
        }
    }

    public function save()
    {
        $this->validate();

        $logoPath = $this->existing_logo;
        if ($this->logo) {
            if ($this->existing_logo) {
                Storage::disk('public')->delete($this->existing_logo);
            }
            $logoPath = $this->logo->store('company-logos', 'public');
        }

        $profile = CompanyProfile::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'company_name' => $this->company_name,
                'description' => $this->description,
                'website' => $this->website,
                'location' => $this->location,
                'industry' => $this->industry,
                'size' => $this->size,
                'logo_path' => $logoPath,
            ]
        );

        $this->existing_logo = $logoPath;
        $this->logo = null;

        // Registrar en auditoría si el usuario tiene permisos administrativos
        $user = Auth::user();
        if (
            $user->hasPermission('manage_users') || $user->hasPermission('manage_categories') ||
            $user->hasPermission('manage_articles') || $user->hasPermission('manage_opinions') ||
            $user->hasPermission('manage_tags') || $user->role === 'admin'
        ) {
            \App\Models\AuditLog::log('update', $profile, "Actualizó el perfil de empresa: {$this->company_name}");
        }

        session()->flash('status', 'profile-updated');
        $this->dispatch('profile-updated');
    }

    public function render()
    {
        return view('livewire.jobs.admin.company-profile-form');
    }
}
