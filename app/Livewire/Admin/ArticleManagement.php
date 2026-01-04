<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ArticleManagement extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $showModal = false;
    
    // Form fields
    public $articleId;
    public $title;
    public $slug;
    public $excerpt;
    public $content;
    public $category_id;
    public $status = 'draft';
    public $is_featured = false;
    public $featured_image; // Temporal para upload
    public $existing_featured_image; // Para mostrar la actual

    public function mount()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        if (!$user || !$user->hasPermission('manage_articles')) {
            abort(403);
        }
    }

    protected $rules = [
        'title' => 'required|min:5|max:255',
        'slug' => 'required|unique:articles,slug',
        'excerpt' => 'nullable|max:500',
        'content' => 'required',
        'category_id' => 'required|exists:categories,id',
        'status' => 'required|in:draft,published,archived',
        'is_featured' => 'boolean',
        'featured_image' => 'nullable|image|max:2048',
    ];

    public function render()
    {
        $articles = Article::with(['category', 'author'])
            ->where('title', 'like', "%{$this->search}%")
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.article-management', [
            'articles' => $articles,
            'categories' => Category::all()
        ]);
    }

    public function updatedTitle($value)
    {
        $this->slug = Str::slug($value);
    }

    public function openModal()
    {
        $this->reset(['articleId', 'title', 'slug', 'excerpt', 'content', 'category_id', 'status', 'is_featured', 'featured_image', 'existing_featured_image']);
        $this->showModal = true;
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $this->articleId = $article->id;
        $this->title = $article->title;
        $this->slug = $article->slug;
        $this->excerpt = $article->excerpt;
        $this->content = $article->content;
        $this->category_id = $article->category_id;
        $this->status = $article->status;
        $this->is_featured = $article->is_featured;
        $this->existing_featured_image = $article->featured_image;
        $this->showModal = true;
    }

    public function save()
    {
        $rules = $this->rules;
        if ($this->articleId) {
            $rules['slug'] = 'required|unique:articles,slug,' . $this->articleId;
        }

        $this->validate($rules);

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'category_id' => $this->category_id,
            'status' => $this->status,
            'is_featured' => $this->is_featured,
            'user_id' => Auth::id(), // El usuario actual es el autor
        ];

        if ($this->featured_image) {
            $data['featured_image'] = $this->featured_image->store('articles', 'public');
        }

        if ($this->status === 'published' && !$this->articleId) {
            $data['published_at'] = now();
        }

        if ($this->articleId) {
            Article::find($this->articleId)->update($data);
        } else {
            Article::create($data);
        }

        $this->showModal = false;
        $this->dispatch('saved');
    }

    public function delete($id)
    {
        Article::findOrFail($id)->delete();
        $this->dispatch('deleted');
    }
}
