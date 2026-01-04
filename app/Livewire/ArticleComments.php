<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class ArticleComments extends Component
{
    public Article $article;
    public $newComment = '';
    public $replyTo = null;
    public $replyingToName = '';

    protected $rules = [
        'newComment' => 'required|min:3|max:1000',
    ];

    public function mount(Article $article)
    {
        $this->article = $article;
    }

    public function postComment()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->validate();

        Comment::create([
            'article_id' => $this->article->id,
            'user_id' => Auth::id(),
            'parent_id' => $this->replyTo,
            'content' => $this->newComment,
            'status' => 'approved' // Por ahora auto-aprobado
        ]);

        $this->newComment = '';
        $this->replyTo = null;
        $this->replyingToName = '';
        $this->article->increment('comments_count');
        
        $this->dispatch('commentPosted');
    }

    public function setReply($commentId, $userName)
    {
        $this->replyTo = $commentId;
        $this->replyingToName = $userName;
        $this->dispatch('scroll-to-bottom'); // Opcional
    }

    public function cancelReply()
    {
        $this->replyTo = null;
        $this->replyingToName = '';
    }

    public function render()
    {
        $comments = $this->article->comments()
            ->whereNull('parent_id')
            ->where('status', 'approved')
            ->with(['user', 'replies.user'])
            ->latest()
            ->get();

        return view('livewire.article-comments', [
            'comments' => $comments
        ]);
    }
}
