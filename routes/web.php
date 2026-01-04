<?php

use Illuminate\Support\Facades\Route;

use Src\UserManagement\Infrastructure\Controllers\LoginController;

use App\Models\Opinion;
use App\Models\Article;

use Src\UserManagement\Infrastructure\Controllers\RegisterController;

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

    $opinions = Opinion::latest()->take(3)->get();
    return view('welcome', compact('opinions', 'featuredArticle', 'latestArticles'));
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/noticia/{article:slug}', function (Article $article) {
    // Incrementar vistas
    $article->increment('views_count');
    return view('articles.show', compact('article'));
})->name('articles.show');

Route::get('/seccion/{category}', function ($category) {
    return view('category', ['category' => ucfirst($category)]);
})->name('category.show');

// Rutas protegidas (Usuario autenticado)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [Src\UserManagement\Infrastructure\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [Src\UserManagement\Infrastructure\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [Src\UserManagement\Infrastructure\Controllers\ProfileController::class, 'updatePassword'])->name('password.update');
});
