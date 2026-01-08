<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header del Perfil -->
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow-sm border border-gray-100 dark:border-gray-800 p-8 mb-12">
        <div class="flex flex-col md:flex-row items-center gap-8">
            <div class="shrink-0 relative">
                <div class="w-32 h-32 rounded-full overflow-hidden ring-4 ring-gray-50 dark:ring-gray-800 shadow-xl">
                    @if ($author->avatar)
                        <img src="{{ $author->avatar }}" alt="{{ $author->name }}" class="w-full h-full object-cover">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($author->name) }}&background=0D8ABC&color=fff"
                            class="w-full h-full object-cover">
                    @endif
                </div>
            </div>

            <div class="flex-grow text-center md:text-left space-y-4">
                <div>
                    <h1 class="font-serif text-3xl md:text-4xl font-black text-gray-900 dark:text-white mb-2">
                        {{ $author->name }}</h1>
                    <p class="text-brand-600 dark:text-brand-400 font-bold uppercase tracking-widest text-xs">
                        {{ $author->role ?? 'Periodista' }}</p>
                </div>

                @if ($author->bio)
                    <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto md:mx-0">{{ $author->bio }}</p>
                @endif

                <div class="flex items-center justify-center md:justify-start gap-6 text-sm text-gray-500">
                    <div class="flex flex-col items-center md:items-start">
                        <span
                            class="font-black text-gray-900 dark:text-white text-xl">{{ $author->followers()->count() }}</span>
                        <span class="text-[10px] uppercase tracking-wider">Seguidores</span>
                    </div>
                    <div class="flex flex-col items-center md:items-start">
                        <span class="font-black text-gray-900 dark:text-white text-xl">{{ $articles->total() }}</span>
                        <span class="text-[10px] uppercase tracking-wider">Artículos</span>
                    </div>
                </div>
            </div>

            <div class="shrink-0">
                @auth
                    @if (auth()->id() !== $author->id)
                        <button wire:click="toggleFollow"
                            class="px-8 py-3 rounded-full text-xs font-bold uppercase tracking-widest transition-all
                            {{ auth()->user()->isFollowing($author)
                                ? 'bg-gray-100 text-gray-500 hover:bg-red-50 hover:text-red-500 hover:border-red-200 border border-transparent'
                                : 'bg-brand-600 text-white hover:bg-brand-700 shadow-lg hover:shadow-xl' }}">
                            {{ auth()->user()->isFollowing($author) ? 'Dejar de Seguir' : 'Seguir Autor' }}
                        </button>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                        class="px-8 py-3 rounded-full bg-brand-600 text-white text-xs font-bold uppercase tracking-widest hover:bg-brand-700 shadow-lg hover:shadow-xl transition-all">
                        Seguir Autor
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Filtros y Grid -->
    <div class="mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
        <h2 class="font-serif text-2xl font-bold dark:text-white">Artículos Publicados</h2>

        <div class="flex gap-4 w-full md:w-auto">
            <select wire:model.live="categoryId"
                class="px-4 py-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-sm text-sm focus:ring-2 focus:ring-brand-500 outline-none">
                <option value="">Todas las Categorías</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>

            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar artículo..."
                class="px-4 py-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-sm text-sm focus:ring-2 focus:ring-brand-500 outline-none w-full md:w-64">
        </div>
    </div>

    @if ($articles->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @foreach ($articles as $article)
                <article
                    class="group bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-sm overflow-hidden hover:shadow-xl transition-all duration-300">
                    <div class="aspect-video relative overflow-hidden bg-gray-100">
                        @if ($article->featured_image)
                            <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        @endif
                        <span
                            class="absolute top-4 left-4 bg-white/90 dark:bg-black/80 px-2 py-1 text-[10px] font-bold uppercase tracking-widest text-black dark:text-white">
                            {{ $article->category->name }}
                        </span>
                    </div>

                    <div class="p-6">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-2">
                            {{ $article->published_at->format('d M, Y') }}
                        </span>

                        <h3
                            class="font-serif text-xl font-bold leading-tight mb-3 text-gray-900 dark:text-white group-hover:text-brand-600 transition-colors">
                            <a href="{{ route('articles.show', $article->slug) }}">
                                {{ $article->title }}
                            </a>
                        </h3>

                        <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-3 mb-4">
                            {{ $article->excerpt }}
                        </p>

                        <a href="{{ route('articles.show', $article->slug) }}"
                            class="text-xs font-bold uppercase tracking-widest text-brand-600 hover:text-brand-800 flex items-center gap-1">
                            Leer más <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $articles->links() }}
        </div>
    @else
        <div
            class="text-center py-24 bg-gray-50 dark:bg-gray-800/50 rounded-lg border-2 border-dashed border-gray-200 dark:border-gray-800">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                </path>
            </svg>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">No se encontraron artículos</h3>
            <p class="text-gray-500 text-sm">Prueba ajustando los filtros de búsqueda</p>
        </div>
    @endif
</div>
