<?php

namespace App\Livewire\Jobs\Admin;

use Livewire\Component;
use App\Models\JobVacancy;
use App\Models\JobCategory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CreateVacancy extends Component
{
    public $title = '';
    public $job_category_id = '';
    public $description = '';
    public $salary_range = '';
    public $contract_type = 'Indefinido';
    public $schedule = 'Tiempo Completo';
    public $location = '';
    public $expires_at = '';
    public $status = 'active';

    protected $rules = [
        'title' => 'required|string|max:255',
        'job_category_id' => 'required|exists:job_categories,id',
        'description' => 'required|string',
        'salary_range' => 'nullable|string|max:100',
        'contract_type' => 'required|string',
        'schedule' => 'required|string',
        'location' => 'required|string|max:255',
        'expires_at' => 'nullable|date|after:today',
        'status' => 'required|in:active,inactive,closed',
    ];

    public function mount()
    {
        // Verificar que el usuario sea admin o company
        if (!Auth::check() || !Auth::user()->isCompany()) {
            abort(403, 'No autorizado');
        }

        $profile = Auth::user()->companyProfile;

        // Si no es admin, debe tener perfil de empresa completo
        if (Auth::user()->role !== 'admin') {
            if (!$profile || !$profile->company_name || !$profile->description || !$profile->location) {
                session()->flash('error', 'Debes completar tu Perfil de Empresa antes de publicar una vacante.');
                return redirect()->route('profile.edit', ['tab' => 'company']);
            }
        }
    }

    public function save()
    {
        $this->validate();

        try {
            $vacancy = JobVacancy::create([
                'user_id' => Auth::id(),
                'job_category_id' => $this->job_category_id,
                'title' => $this->title,
                'slug' => Str::slug($this->title) . '-' . rand(1000, 9999),
                'description' => $this->description,
                'salary_range' => $this->salary_range,
                'contract_type' => $this->contract_type,
                'schedule' => $this->schedule,
                'location' => $this->location,
                'status' => $this->status,
                'expires_at' => $this->expires_at,
            ]);

            // Registrar en auditoría
            \App\Models\AuditLog::log('create', $vacancy, "Creó la vacante: {$this->title}");

            session()->flash('success', '¡Vacante creada exitosamente!');

            return redirect()->route('profile.edit', ['tab' => 'jobs']);
        } catch (\Exception $e) {
            session()->flash('error', 'Error al crear la vacante: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $categories = JobCategory::where('is_active', true)->get();

        return view('livewire.jobs.admin.create-vacancy', [
            'categories' => $categories
        ])->extends('layouts.app')->section('content');
    }
}
