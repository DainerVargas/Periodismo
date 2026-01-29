<?php

namespace App\Livewire\Jobs\Admin;

use Livewire\Component;
use App\Models\JobVacancy;
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

    public function toggleStatus($vacancyId)
    {
        $query = JobVacancy::query();
        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }
        $vacancy = $query->findOrFail($vacancyId);

        $vacancy->update([
            'status' => $vacancy->status === 'active' ? 'closed' : 'active'
        ]);

        session()->flash('success', 'Estado actualizado correctamente');
    }

    public function deleteVacancy($vacancyId)
    {
        $query = JobVacancy::query();
        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }
        $vacancy = $query->findOrFail($vacancyId);
        $vacancy->delete();

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

        return view('livewire.jobs.admin.manage-vacancies', [
            'vacancies' => $vacancies
        ])->extends('layouts.app')->section('content');
    }
}
