<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CategoryManagement extends Component
{
    public $search = '';
    public $showModal = false;

    // Form fields
    public $categoryId;
    public $name;
    public $slug;
    public $description;
    public $color = '#3B82F6';
    public $is_active = true;

    public function mount()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->hasPermission('manage_categories')) {
            abort(403);
        }
    }

    protected $rules = [
        'name' => 'required|min:3|max:255',
        'slug' => 'required|unique:categories,slug',
        'description' => 'nullable',
        'color' => 'required|hex_color',
        'is_active' => 'boolean',
    ];

    public function render()
    {
        $categories = Category::where('name', 'like', "%{$this->search}%")
            ->orderBy('order', 'asc')
            ->get();

        return view('livewire.admin.category-management', [
            'categories' => $categories
        ]);
    }

    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function openModal()
    {
        $this->reset(['categoryId', 'name', 'slug', 'description', 'color', 'is_active']);
        $this->showModal = true;
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->description = $category->description;
        $this->color = $category->color;
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
            $rules['slug'] = 'required|unique:categories,slug,' . $this->categoryId;
        }

        $this->validate($rules);

        if ($this->categoryId) {
            $category = Category::find($this->categoryId);
            $category->update([
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
                'color' => $this->color,
                'is_active' => $this->is_active,
            ]);
            AuditLog::log('update', $category, "Actualizó la categoría: {$category->name}");
        } else {
            $category = Category::create([
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
                'color' => $this->color,
                'is_active' => $this->is_active,
                'order' => Category::count() + 1
            ]);
            AuditLog::log('create', $category, "Creó la categoría: {$category->name}");
        }

        $this->showModal = false;
        $this->dispatch('saved');
    }

    public function delete($id)
    {
        if (Auth::user()->role === 'user') {
            return;
        }

        $category = Category::findOrFail($id);
        $name = $category->name;
        $category->delete();

        AuditLog::log('delete', $category, "Eliminó la categoría: {$name}");

        $this->dispatch('deleted');
    }
}
