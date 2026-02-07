<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class AuthorProfile extends Component
{
    use WithPagination;

    public $authorId;
    public $search = '';
    public $categoryId = '';

    public function mount(User $user)
    {
        $this->authorId = $user->id;
    }

    public function getAuthorProperty()
    {
        return User::findOrFail($this->authorId);
    }

    public function toggleFollow()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $author = $this->author;

        if ($user->id === $author->id) {
            return;
        }

        if ($user->isFollowing($author)) {
            $user->following()->detach($author->id);
        } else {
            $user->following()->attach($author->id);
        }
    }

    public function render()
    {
        $articles = Article::where('user_id', $this->authorId)
            ->where('status', 'published')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->when($this->categoryId, function ($query) {
                $query->where('category_id', $this->categoryId);
            })
            ->latest('published_at')
            ->paginate(12);

        return view('livewire.author-profile', [
            'author' => $this->author,
            'articles' => $articles,
            'categories' => Category::all(),
        ])->extends('layouts.app')->section('content');
    }
}
