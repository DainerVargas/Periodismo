<?php

namespace App\Livewire\Jobs;

use Livewire\Component;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MyApplications extends Component
{
    public function render()
    {
        $applications = JobApplication::where('user_id', Auth::id())
            ->with(['vacancy.company.companyProfile'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.jobs.my-applications', [
            'applications' => $applications
        ]);
    }

    public function deleteApplication($id)
    {
        $application = JobApplication::where('user_id', Auth::id())->findOrFail($id);

        // Opcional: Eliminar el archivo del currículum si existe
        if ($application->resume_path) {
            Storage::delete($application->resume_path);
        }

        $application->delete();

        session()->flash('success', 'Postulación eliminada correctamente');
    }
}
