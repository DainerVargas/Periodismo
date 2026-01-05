<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tag;
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
        if (!$user || !$user->hasPermission('manage_articles')) {
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
            Tag::find($this->tagId)->update($data);
        } else {
            Tag::create($data);
        }

        $this->showModal = false;
        $this->dispatch('saved');
    }

    public function delete($id)
    {
        Tag::findOrFail($id)->delete();
        $this->dispatch('deleted');
    }

    public function toggleStatus($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->is_active = !$tag->is_active;
        $tag->save();
    }
}
