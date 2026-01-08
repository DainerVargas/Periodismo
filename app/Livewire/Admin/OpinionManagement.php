<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Opinion;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OpinionManagement extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $showModal = false;

    // Form fields
    public $opinionId;
    public $author;
    public $title;
    public $slug;
    public $content;
    public $image; // Temporal upload
    public $existing_image;

    protected $rules = [
        'author' => 'required|min:3|max:100',
        'title' => 'required|min:5|max:255',
        'slug' => 'required|unique:opinions,slug',
        'content' => 'required|min:10',
        'image' => 'nullable|image|max:1024',
    ];

    public function mount()
    {
        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user();
        if (!$user || !$user->hasPermission('manage_opinions')) {
            abort(403);
        }
    }

    public function render()
    {
        $opinions = Opinion::where('author', 'like', "%{$this->search}%")
            ->orWhere('title', 'like', "%{$this->search}%")
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('livewire.admin.opinion-management', [
            'opinions' => $opinions
        ]);
    }

    public function openModal()
    {
        $this->reset(['opinionId', 'author', 'title', 'slug', 'content', 'image', 'existing_image']);
        $this->showModal = true;
    }

    public function edit($id)
    {
        $opinion = Opinion::findOrFail($id);
        $this->opinionId = $opinion->id;
        $this->author = $opinion->author;
        $this->title = $opinion->title;
        $this->slug = $opinion->slug;
        $this->content = $opinion->content;
        $this->existing_image = $opinion->image;
        $this->showModal = true;
    }

    public function updatedTitle($value)
    {
        $this->slug = Str::slug($value);
    }

    public function save()
    {
        if (\Illuminate\Support\Facades\Auth::user()->role === 'user') {
            return;
        }

        $rules = $this->rules;
        if ($this->opinionId) {
            $rules['slug'] = 'required|unique:opinions,slug,' . $this->opinionId;
        }

        $this->validate($rules);


        $data = [
            'author' => $this->author,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('opinions', 'public');
        }

        if ($this->opinionId) {
            $opinion = Opinion::find($this->opinionId);
            $opinion->update($data);
            AuditLog::log('update', $opinion, "Actualizó la columna de opinión: {$opinion->title}");
        } else {
            $opinion = Opinion::create($data);
            AuditLog::log('create', $opinion, "Creó una nueva columna de opinión: {$opinion->title}");
        }

        $this->showModal = false;
        $this->dispatch('saved');
    }

    public function delete($id)
    {
        if (\Illuminate\Support\Facades\Auth::user()->role === 'user') {
            return;
        }

        $opinion = Opinion::findOrFail($id);
        $title = $opinion->title;
        $opinion->delete();

        AuditLog::log('delete', $opinion, "Eliminó la columna de opinión: {$title}");
        $this->dispatch('deleted');
    }
}
