<?php

namespace App\Livewire\Jobs;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\JobVacancy;
use App\Models\JobCategory;

class JobList extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCategory = '';
    public $selectedLocation = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCategory' => ['except' => ''],
        'selectedLocation' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $categories = JobCategory::where('is_active', true)->get();

        $locations = JobVacancy::where('status', 'active')
            ->whereNotNull('location')
            ->distinct()
            ->pluck('location');

        $vacancies = JobVacancy::with(['company.companyProfile', 'category'])
            ->where('status', 'active')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhereHas('company', function ($subQ) {
                            $subQ->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->selectedCategory, function ($query) {
                $query->where('job_category_id', $this->selectedCategory);
            })
            ->when($this->selectedLocation, function ($query) {
                $query->where('location', $this->selectedLocation);
            })
            ->latest()
            ->paginate(12);

        return view('livewire.jobs.job-list', [
            'vacancies' => $vacancies,
            'categories' => $categories,
            'locations' => $locations
        ])->extends('layouts.app')->section('content');
    }
}
