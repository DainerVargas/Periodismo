<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tag;
use App\Models\AuditLog;
use Illuminate\Support\Str;

class TagManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;

    // Form fields
    public $tagId;
    public $name;
    public $slug;
    public $is_active = true;

    protected $rules = [
        'name' => 'required|min:2|max:50',
        'slug' => 'required|unique:tags,slug',
        'is_active' => 'boolean',
    ];

    public function mount()
    {
        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user();
        if (!$user || !$user->hasPermission('manage_tags')) {
            abort(403);
        }
    }

    public function render()
    {
        $tags = Tag::where('name', 'like', "%{$this->search}%")
            ->orderBy('name', 'asc')
            ->paginate(10);

        return view('livewire.admin.tag-management', [
            'tags' => $tags
        ]);
    }

    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function openModal()
    {
        $this->reset(['tagId', 'name', 'slug', 'is_active']);
        $this->showModal = true;
    }

    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        $this->tagId = $tag->id;
        $this->name = $tag->name;
        $this->slug = $tag->slug;
        $this->is_active = $tag->is_active;
        $this->showModal = true;
    }

    public function save()
    {
        if (\Illuminate\Support\Facades\Auth::user()->role === 'user') {
            return;
        }

        $rules = $this->rules;

        if ($this->tagId) {
            $rules['slug'] = 'required|unique:tags,slug,' . $this->tagId;
        }

        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'is_active' => $this->is_active,
        ];

        if ($this->tagId) {
            $tag = Tag::find($this->tagId);
            $tag->update($data);
            AuditLog::log('update', $tag, "Actualizó la etiqueta: {$tag->name}");
        } else {
            $tag = Tag::create($data);
            AuditLog::log('create', $tag, "Creó la etiqueta: {$tag->name}");
        }

        $this->showModal = false;
        $this->dispatch('saved');
    }

    public function delete($id)
    {
        if (\Illuminate\Support\Facades\Auth::user()->role === 'user') {
            return;
        }

        $tag = Tag::findOrFail($id);
        $name = $tag->name;
        $tag->delete();

        AuditLog::log('delete', $tag, "Eliminó la etiqueta: {$name}");
        $this->dispatch('deleted');
    }


    public function toggleStatus($id)
    {
        if (\Illuminate\Support\Facades\Auth::user()->role === 'user') {
            return;
        }

        $tag = Tag::findOrFail($id);

        $tag->is_active = !$tag->is_active;
        $tag->save();

        AuditLog::log('update', $tag, ($tag->is_active ? 'Activó' : 'Desactivó') . " la etiqueta: {$tag->name}");
    }
}
