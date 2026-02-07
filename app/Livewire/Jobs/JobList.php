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
                $words = preg_split('/\s+/', strtolower(trim($this->search)));
                $query->where(function ($q) use ($words) {
                    foreach ($words as $word) {
                        if (strlen($word) <= 4) {
                            continue;
                        }
                        $term = '%' . $word . '%';
                        $q->orWhere(function ($subQ) use ($term) {
                            $subQ->where('title', 'LIKE', $term)
                                ->orWhere('description', 'LIKE', $term)
                                ->orWhere('location', 'LIKE', $term)
                                ->orWhereHas('category', function ($catQ) use ($term) {
                                    $catQ->where('name', 'LIKE', $term);
                                })
                                ->orWhereHas('company', function ($compQ) use ($term) {
                                    $compQ->where('name', 'LIKE', $term);
                                });
                        });
                    }
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
