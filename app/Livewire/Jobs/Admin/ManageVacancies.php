<?php

namespace App\Livewire\Jobs\Admin;

use Livewire\Component;
use App\Models\JobVacancy;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class ManageVacancies extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = 'all';
    public $selectedVacancy = null;
    public $viewingApplications = false;

    protected $queryString = ['search', 'statusFilter'];

    public function mount()
    {
        // Verificar que el usuario sea admin o company
        if (!Auth::check() || !Auth::user()->isCompany()) {
            abort(403, 'No autorizado');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }
    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function setStatus($vacancyId, $status)
    {
        $query = JobVacancy::query();
        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }
        $vacancy = $query->findOrFail($vacancyId);

        if (!in_array($status, ['active', 'inactive', 'closed'])) {
            return;
        }

        $oldStatus = $vacancy->status;
        $vacancy->update(['status' => $status]);

        // Registrar en auditoría si el usuario tiene permisos administrativos
        $user = Auth::user();
        if (
            $user->hasPermission('manage_users') || $user->hasPermission('manage_categories') ||
            $user->hasPermission('manage_articles') || $user->hasPermission('manage_opinions') ||
            $user->hasPermission('manage_tags') || $user->role === 'admin' || $user->isCompany()
        ) {
            AuditLog::log('update', $vacancy, "Cambió el estado de la vacante '{$vacancy->title}' de {$oldStatus} a {$status}");
        }

        session()->flash('success', 'Estado de la vacante actualizado a: ' . ucfirst($status));
    }

    public function deleteVacancy($vacancyId)
    {
        $query = JobVacancy::query();
        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }
        $vacancy = $query->findOrFail($vacancyId);
        $title = $vacancy->title;
        $vacancy->delete();

        // Registrar en auditoría si el usuario tiene permisos administrativos
        $user = Auth::user();
        if (
            $user->hasPermission('manage_users') || $user->hasPermission('manage_categories') ||
            $user->hasPermission('manage_articles') || $user->hasPermission('manage_opinions') ||
            $user->hasPermission('manage_tags') || $user->role === 'admin' || $user->isCompany()
        ) {
            AuditLog::log('delete', $vacancy, "Eliminó la vacante: {$title}");
        }

        session()->flash('success', 'Vacante eliminada correctamente');
    }

    public function showApplications($vacancyId)
    {
        $query = JobVacancy::with(['applications.user']);
        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }
        $this->selectedVacancy = $query->findOrFail($vacancyId);
        $this->viewingApplications = true;
    }

    public function closeApplications()
    {
        $this->selectedVacancy = null;
        $this->viewingApplications = false;
    }

    public function render()
    {
        $query = JobVacancy::with(['category', 'applications', 'company']);

        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('location', 'like', '%' . $this->search . '%')
                    ->orWhereHas('company', function ($sq) {
                        $sq->where('name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        $vacancies = $query->latest()->paginate(10);

        $profile = Auth::user()->companyProfile;
        $profileIncomplete = false;
        if (Auth::user()->role !== 'admin') {
            $profileIncomplete = !$profile || !$profile->company_name || !$profile->description || !$profile->location;
        }

        return view('livewire.jobs.admin.manage-vacancies', [
            'vacancies' => $vacancies,
            'profileIncomplete' => $profileIncomplete
        ])->extends('layouts.app')->section('content');
    }
}
