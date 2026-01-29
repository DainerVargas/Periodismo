<?php

namespace App\Livewire\Jobs;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\JobVacancy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class JobDetail extends Component
{
    use WithFileUploads;

    public JobVacancy $vacancy;
    public $showApplyModal = false;
    public $resume;
    public $cover_letter;
    public $hasApplied = false;

    public function mount(JobVacancy $vacancy)
    {
        $this->vacancy = $vacancy->load(['company.companyProfile', 'category']);

        if (auth()->check()) {
            $this->hasApplied = $vacancy->applications()->where('user_id', auth()->id())->exists();
        }
    }

    public function promptApply()
    {
        if (!auth()->check()) {
            // Guardar la URL intencional si deseas redirigir de vuelta después
            session()->put('url.intended', route('jobs.show', $this->vacancy->slug));
            return redirect()->route('login');
        }
        $this->showApplyModal = true;
    }

    public function render()
    {
        return view('livewire.jobs.job-detail')
            ->extends('layouts.app')
            ->section('content');
    }

    public function apply()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        try {
            $this->validate([
                'resume' => 'required|mimes:pdf|max:5120', // 5MB Max
                'cover_letter' => 'nullable|string|max:1000',
            ]);

            // Guardar el archivo PDF
            $path = $this->resume->store('resumes', 'public');

            // Crear la aplicación
            $this->vacancy->applications()->create([
                'user_id' => Auth::id(),
                'resume_path' => $path,
                'cover_letter' => $this->cover_letter,
                'status' => 'applied'
            ]);

            // Actualizar el estado
            $this->hasApplied = true;
            $this->showApplyModal = false;

            // Mensaje de éxito
            session()->flash('success', '¡Postulación enviada con éxito! La empresa revisará tu perfil.');

            // Limpiar los campos
            $this->reset(['resume', 'cover_letter']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Los errores de validación se manejan automáticamente por Livewire
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error en postulación: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'vacancy_id' => $this->vacancy->id,
                'trace' => $e->getTraceAsString()
            ]);

            $this->addError('resume', 'Hubo un error al enviar tu postulación. Por favor, intenta de nuevo.');
        }
    }
}
