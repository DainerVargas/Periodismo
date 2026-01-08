<?php

use Illuminate\Support\Facades\Route;

use Src\UserManagement\Infrastructure\Controllers\LoginController;

use App\Models\Opinion;
use App\Models\Article;

use Src\UserManagement\Infrastructure\Controllers\RegisterController;

use App\Models\Category;

Route::get('/', function () {
    $featuredArticle = Article::with(['category', 'author'])
        ->where('status', 'published')
        ->where('is_featured', true)
        ->latest('published_at')
        ->first() ?? Article::with(['category', 'author'])
        ->where('status', 'published')
        ->latest('published_at')
        ->first();

    $latestArticles = Article::with(['category', 'author'])
        ->where('status', 'published')
        ->where('id', '!=', $featuredArticle?->id ?? 0)
        ->latest('published_at')
        ->take(4)
        ->get();

    $politicaArticles = Article::with(['category', 'author'])
        ->whereHas('category', fn($q) => $q->where('slug', 'politica'))
        ->where('status', 'published')
        ->where('id', '!=', $featuredArticle?->id ?? 0)
        ->latest('published_at')
        ->take(4)
        ->get();

    $tecnologiaArticles = Article::with(['category', 'author'])
        ->whereHas('category', fn($q) => $q->where('slug', 'tecnologia'))
        ->where('status', 'published')
        ->latest('published_at')
        ->take(4)
        ->get();

    $economiaArticles = Article::with(['category', 'author'])
        ->whereHas('category', fn($q) => $q->where('slug', 'economia'))
        ->where('status', 'published')
        ->latest('published_at')
        ->take(4)
        ->get();

    $culturaArticles = Article::with(['category', 'author'])
        ->whereHas('category', fn($q) => $q->where('slug', 'cultura'))
        ->where('status', 'published')
        ->latest('published_at')
        ->take(4)
        ->get();

    $opinions = Opinion::latest()->take(3)->get();

    // Lógica para Lo Más Leído Hoy
    $mostReadToday = Article::with(['category', 'author'])
        ->where('status', 'published')
        ->withCount(['views as todays_views' => function ($query) {
            $query->whereDate('viewed_at', \Illuminate\Support\Carbon::today());
        }])
        ->orderByDesc('todays_views')
        ->take(3)
        ->get();

    // Fallback a las más leídas históricamente si no hay vistas hoy
    if ($mostReadToday->isEmpty() || $mostReadToday->first()->todays_views == 0) {
        $mostReadToday = Article::with(['category', 'author'])
            ->where('status', 'published')
            ->orderByDesc('views_count')
            ->take(3)
            ->get();
    }

    return view('welcome', compact(
        'opinions',
        'featuredArticle',
        'latestArticles',
        'politicaArticles',
        'tecnologiaArticles',
        'economiaArticles',
        'culturaArticles',
        'mostReadToday'
    ));
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/noticia/{article:slug}', function (Article $article) {
    // Incrementar vistas totales (legacy/rápido)
    $article->increment('views_count');

    // Registrar vista granular
    \App\Models\ArticleView::create([
        'article_id' => $article->id,
        'user_id' => auth()->id(),
        'ip_address' => request()->ip(),
        'user_agent' => request()->userAgent(),
        'session_id' => session()->getId(),
        'viewed_at' => now(),
    ]);

    return view('articles.show', compact('article'));
})->name('articles.show');

Route::get('/seccion/{slug}', function ($slug) {
    if ($slug === 'opinion') {
        return redirect()->route('opinions.index');
    }
    $category = Category::where('slug', $slug)->firstOrFail();
    $articles = Article::with(['author', 'category'])
        ->where('category_id', $category->id)
        ->where('status', 'published')
        ->latest('published_at')
        ->paginate(10);

    return view('category', compact('category', 'articles'));
})->name('category.show');

Route::get('/opinion', [App\Http\Controllers\OpinionController::class, 'index'])->name('opinions.index');
Route::get('/opinion/{opinion:slug}', [App\Http\Controllers\OpinionController::class, 'show'])->name('opinions.show');

Route::get('/etiqueta/{slug}', function ($slug) {
    $tag = App\Models\Tag::where('slug', $slug)->where('is_active', true)->firstOrFail();
    $articles = $tag->articles()
        ->with(['author', 'category'])
        ->where('status', 'published')
        ->latest('published_at')
        ->paginate(10);

    return view('tag', compact('tag', 'articles'));
})->name('tags.show');

// Rutas protegidas (Usuario autenticado)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [Src\UserManagement\Infrastructure\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [Src\UserManagement\Infrastructure\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [Src\UserManagement\Infrastructure\Controllers\ProfileController::class, 'updatePassword'])->name('password.update');
});

Route::get('/autor/{user:slug}', App\Livewire\AuthorProfile::class)->name('author.profile');
