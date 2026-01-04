<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Article;
use App\Models\Reaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArticleReactions extends Component
{
    public Article $article;
    public $reactionsCount = [];
    public $userReaction = null;

    protected $listeners = ['reactionUpdated' => '$refresh'];

    public function mount(Article $article)
    {
        $this->article = $article;
        $this->loadReactions();
    }

    public function loadReactions()
    {
        $this->reactionsCount = $this->article->reactions()
            ->select('type', \DB::raw('count(*) as count'))
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();

        if (Auth::check()) {
            $this->userReaction = $this->article->reactions()
                ->where('user_id', Auth::id())
                ->first()?->type;
        }
    }

    public function react($type)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $existing = Reaction::where('user_id', Auth::id())
            ->where('reactable_id', $this->article->id)
            ->where('reactable_type', Article::class)
            ->first();

        if ($existing) {
            if ($existing->type === $type) {
                $existing->delete();
                $this->userReaction = null;
            } else {
                $existing->update(['type' => $type]);
                $this->userReaction = $type;
            }
        } else {
            Reaction::create([
                'user_id' => Auth::id(),
                'reactable_id' => $this->article->id,
                'reactable_type' => Article::class,
                'type' => $type
            ]);
            $this->userReaction = $type;
        }

        // Update article counter if needed (optional if using live counts)
        $this->article->update(['reactions_count' => $this->article->reactions()->count()]);
        
        $this->loadReactions();
    }

    public function render()
    {
        $types = [
            'like' => '👍',
            'love' => '❤️',
            'wow' => '😮',
            'sad' => '😢',
            'angry' => '😠'
        ];

        return view('livewire.article-reactions', [
            'types' => $types
        ]);
    }
}
