<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\JobCategory;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class JobCategoryManagement extends Component
{
    public $search = '';
    public $showModal = false;

    // Form fields
    public $categoryId;
    public $name;
    public $slug;
    public $description;
    public $is_active = true;

    public function mount()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || ($user->role !== 'admin' && !$user->hasPermission('manage_categories'))) {
            abort(403);
        }
    }

    protected $rules = [
        'name' => 'required|min:3|max:255',
        'slug' => 'required|unique:job_categories,slug',
        'description' => 'nullable',
        'is_active' => 'boolean',
    ];

    public function render()
    {
        $categories = JobCategory::where('name', 'like', "%{$this->search}%")
            ->orderBy('name', 'asc')
            ->get();

        return view('livewire.admin.job-category-management', [
            'categories' => $categories
        ]);
    }

    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function openModal()
    {
        $this->reset(['categoryId', 'name', 'slug', 'description', 'is_active']);
        $this->showModal = true;
    }

    public function edit($id)
    {
        $category = JobCategory::findOrFail($id);
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->description = $category->description;
        $this->is_active = $category->is_active;
        $this->showModal = true;
    }

    public function save()
    {
        if (Auth::user()->role === 'user') {
            return;
        }

        $rules = $this->rules;
        if ($this->categoryId) {
            $rules['slug'] = 'required|unique:job_categories,slug,' . $this->categoryId;
        }

        $this->validate($rules);

        if ($this->categoryId) {
            $category = JobCategory::find($this->categoryId);
            $category->update([
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ]);
            AuditLog::log('update', $category, "Actualizó la categoría de empleo: {$category->name}");
        } else {
            $category = JobCategory::create([
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ]);
            AuditLog::log('create', $category, "Creó la categoría de empleo: {$category->name}");
        }

        $this->showModal = false;
        $this->dispatch('saved');
        session()->flash('success', 'Categoría guardada correctamente');
    }

    public function delete($id)
    {
        if (Auth::user()->role !== 'admin') {
            return;
        }

        $category = JobCategory::findOrFail($id);

        // Verificar si tiene vacantes asociadas
        if ($category->vacancies()->count() > 0) {
            session()->flash('error', 'No se puede eliminar una categoría que tiene vacantes asociadas.');
            return;
        }

        $name = $category->name;
        $category->delete();

        AuditLog::log('delete', $category, "Eliminó la categoría de empleo: {$name}");

        $this->dispatch('deleted');
        session()->flash('success', 'Categoría eliminada');
    }
}
