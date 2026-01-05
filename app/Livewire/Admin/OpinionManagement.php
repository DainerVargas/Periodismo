<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Opinion;
use Illuminate\Support\Facades\Storage;

class OpinionManagement extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $showModal = false;

    // Form fields
    public $opinionId;
    public $author;
    public $title;
    public $content;
    public $image; // Temporal upload
    public $existing_image;

    protected $rules = [
        'author' => 'required|min:3|max:100',
        'title' => 'required|min:5|max:255',
        'content' => 'required|min:10',
        'image' => 'nullable|image|max:1024',
    ];

    public function mount()
    {
        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user();
        if (!$user || !$user->hasPermission('manage_articles')) {
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
        $this->reset(['opinionId', 'author', 'title', 'content', 'image', 'existing_image']);
        $this->showModal = true;
    }

    public function edit($id)
    {
        $opinion = Opinion::findOrFail($id);
        $this->opinionId = $opinion->id;
        $this->author = $opinion->author;
        $this->title = $opinion->title;
        $this->content = $opinion->content;
        $this->existing_image = $opinion->image;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'author' => $this->author,
            'title' => $this->title,
            'content' => $this->content,
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('opinions', 'public');
        }

        if ($this->opinionId) {
            Opinion::find($this->opinionId)->update($data);
        } else {
            Opinion::create($data);
        }

        $this->showModal = false;
        $this->dispatch('saved');
    }

    public function delete($id)
    {
        Opinion::findOrFail($id)->delete();
        $this->dispatch('deleted');
    }
}
