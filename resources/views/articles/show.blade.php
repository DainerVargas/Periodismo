@extends('layouts.app')

@section('content')
<main class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumbs / Categoría -->
    <div class="mb-6 flex items-center gap-2">
        <a href="/" class="text-[10px] font-bold uppercase tracking-widest text-gray-400 hover:text-brand-600 transition-colors">Portada</a>
        <span class="text-gray-300">/</span>
        <a href="{{ route('category.show', $article->category->slug) }}" class="text-[10px] font-bold uppercase tracking-widest transition-colors" style="color: {{ $article->category->color }}">
            {{ $article->category->name }}
        </a>
    </div>

    <!-- Título y Resumen -->
    <header class="mb-12">
        <h1 class="font-serif text-4xl sm:text-6xl font-black leading-tight text-ink dark:text-gray-100 mb-6 text-balance">
            {{ $article->title }}
        </h1>
        @if($article->excerpt)
            <p class="text-xl sm:text-2xl text-gray-600 dark:text-gray-400 font-serif italic leading-relaxed border-l-4 border-gray-100 dark:border-gray-800 pl-6 py-2">
                {{ $article->excerpt }}
            </p>
        @endif
    </header>

    <!-- Metadatos y Social Share Superior -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-6 border-y border-gray-100 dark:border-gray-800 mb-12 gap-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-800 ring-2 ring-white dark:ring-gray-900 shadow-sm">
                <img src="{{ $article->author->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($article->author->name) }}" alt="{{ $article->author->name }}">
            </div>
            <div class="flex flex-col">
                <span class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">{{ $article->author->name }}</span>
                <div class="flex items-center gap-2 text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                    <span>{{ $article->published_at ? $article->published_at->translatedFormat('d F, Y') : $article->created_at->translatedFormat('d F, Y') }}</span>
                    <span>•</span>
                    <span>{{ $article->reading_time ?? '5' }} min lectura</span>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <!-- Share Buttons -->
            <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(request()->url()) }}" target="_blank" class="w-8 h-8 flex items-center justify-center rounded-full bg-black text-white hover:opacity-80 transition-all">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"></path></svg>
            </a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-600 text-white hover:opacity-80 transition-all">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"></path></svg>
            </a>
            <button onclick="navigator.clipboard.writeText('{{ request()->url() }}'); alert('Enlace copiado');" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
            </button>
        </div>
    </div>

    <!-- Imagen Principal -->
    @if($article->featured_image)
    <div class="mb-12 relative">
        <div class="aspect-[16/9] overflow-hidden rounded-sm shadow-xl">
            <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
        </div>
        @if($article->featured_image_alt)
            <p class="mt-3 text-[10px] text-gray-500 font-bold uppercase tracking-widest text-center">
                {{ $article->featured_image_alt }}
            </p>
        @endif
    </div>
    @endif

    <!-- Contenido del Artículo -->
    <div class="prose prose-lg dark:prose-invert max-w-none font-serif leading-relaxed text-ink dark:text-gray-300 first-letter:text-6xl first-letter:font-black first-letter:mr-3 first-letter:float-left first-letter:font-serif">
        {!! nl2br(e($article->content)) !!}
    </div>

    <!-- Reacciones y Tags Section -->
    <section class="mt-16 pt-8 border-t border-gray-100 dark:border-gray-800">
        <livewire:article-reactions :article="$article" />
    </section>

    <!-- Comentarios Section -->
    <section id="comments" class="mt-16 pt-16 border-t-2 border-black dark:border-white">
        <h3 class="font-serif text-3xl font-black mb-10 dark:text-white flex items-center gap-3">
            Comentarios
            <span class="text-xs font-sans font-bold bg-gray-100 dark:bg-gray-800 px-3 py-1 rounded-full uppercase tracking-widest text-gray-500">
                {{ $article->comments_count }}
            </span>
        </h3>
        
        <livewire:article-comments :article="$article" />
    </section>
</main>
@endsection
