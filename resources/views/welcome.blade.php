@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <!-- GRID PRINCIPAL -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-16">

            <!-- COLUMNA IZQUIERDA -->
            <div class="lg:col-span-8 space-y-12">

                <!-- FEATURED ARTICLE (HERO) -->
                @if ($featuredArticle)
                    <article class="group relative flex flex-col gap-5">
                        <div class="aspect-[16/9] w-full overflow-hidden bg-gray-100 dark:bg-gray-800 rounded-sm shadow-sm">
                            @if ($featuredArticle->featured_image)
                                <img src="{{ Storage::url($featuredArticle->featured_image) }}"
                                    alt="{{ $featuredArticle->title }}" class="img-zoom h-full w-full object-cover">
                            @else
                                <div class="h-full w-full flex items-center justify-center bg-gray-200 dark:bg-gray-800">
                                    <span class="text-gray-400 font-serif italic">Imagen no disponible</span>
                                </div>
                            @endif
                            <div
                                class="absolute top-4 right-4 bg-black/70 backdrop-blur text-white text-[10px] font-bold px-2 py-1 rounded-sm uppercase tracking-widest">
                                {{ $featuredArticle->reading_time ?? '5' }} min lectura
                            </div>
                        </div>
                        <div class="flex flex-col gap-3">
                            <div class="flex items-center gap-3 text-[10px] font-bold uppercase tracking-widest"
                                style="color: {{ $featuredArticle->category->color }}">
                                <span class="w-2 h-2 rounded-full animate-pulse"
                                    style="background-color: {{ $featuredArticle->category->color }}"></span>
                                {{ $featuredArticle->category->name }}
                            </div>
                            <h2
                                class="font-serif text-4xl sm:text-5xl font-black leading-tight text-ink dark:text-gray-100 text-balance group-hover:text-brand-700 dark:group-hover:text-brand-400 transition-colors">
                                <a href="{{ route('articles.show', $featuredArticle->slug) }}" class="link-underline pb-1">
                                    <span class="absolute inset-0"></span>
                                    {{ $featuredArticle->title }}
                                </a>
                            </h2>
                            <p class="text-lg text-gray-600 dark:text-gray-400 leading-relaxed text-balance">
                                {{ $featuredArticle->excerpt ?? Str::limit(strip_tags($featuredArticle->content), 160) }}
                            </p>

                            <div class="flex items-center gap-4 mt-2 pt-4 border-t border-gray-100 dark:border-gray-800">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden ring-1 ring-gray-100 dark:ring-gray-800">
                                        <img src="{{ $featuredArticle->author->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($featuredArticle->author->name) }}"
                                            alt="Avatar">
                                    </div>
                                    <div class="text-[10px] uppercase tracking-widest font-bold">
                                        <span
                                            class="block text-gray-900 dark:text-white">{{ $featuredArticle->author->name }}</span>
                                        <span
                                            class="block text-gray-400">{{ $featuredArticle->author->role ?? 'Editor' }}</span>
                                    </div>
                                </div>
                                <span class="text-gray-300 dark:text-gray-700">|</span>
                                <span
                                    class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $featuredArticle->published_at ? $featuredArticle->published_at->diffForHumans() : $featuredArticle->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </article>
                @endif

                <!-- SECONDARY GRID -->
                <div
                    class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-10 border-t border-black/10 dark:border-white/10 pt-10">
                    @foreach ($latestArticles as $article)
                        <article class="flex flex-col gap-4 group">
                            <div class="aspect-[3/2] overflow-hidden bg-gray-100 dark:bg-gray-800 rounded-sm relative">
                                @if ($article->featured_image)
                                    <img src="{{ Storage::url($article->featured_image) }}"
                                        class="img-zoom w-full h-full object-cover">
                                @endif
                                <span
                                    class="absolute bottom-2 left-2 bg-white/90 dark:bg-black/80 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider">
                                    {{ $article->reading_time ?? '4' }} MIN
                                </span>
                            </div>
                            <div class="space-y-2">
                                <span class="text-[10px] font-bold uppercase tracking-widest"
                                    style="color: {{ $article->category->color }}">
                                    {{ $article->category->name }}
                                </span>
                                <h3
                                    class="font-serif text-2xl font-bold leading-snug text-gray-900 dark:text-gray-100 group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors">
                                    <a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3">
                                    {{ $article->excerpt ?? Str::limit(strip_tags($article->content), 100) }}
                                </p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>

            <!-- SIDEBAR -->
            <div class="lg:col-span-4 space-y-10 pl-0 lg:pl-10 border-l border-gray-100 dark:border-gray-800">



                <!-- Opinion Section -->
                <div class="space-y-6">
                    <h4
                        class="font-sans font-bold text-xs uppercase tracking-wider text-orange-600 dark:text-orange-500 border-b border-orange-600 pb-2">
                        Opinión destacada
                    </h4>

                    @foreach ($opinions as $opinion)
                        <article class="group">
                            <div class="flex items-center gap-3 mb-2">
                                <div
                                    class="w-6 h-6 rounded-full bg-gray-200 overflow-hidden ring-1 ring-gray-100 dark:ring-gray-700">
                                    @if ($opinion->image)
                                        <img src="{{ Storage::url($opinion->image) }}" alt="{{ $opinion->author }}">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($opinion->author) }}"
                                            alt="Author">
                                    @endif
                                </div>
                                <span
                                    class="text-[10px] font-bold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ $opinion->author }}</span>
                            </div>
                            <h3
                                class="font-serif text-lg font-bold leading-tight group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors dark:text-gray-200">
                                <a
                                    href="{{ route('opinions.show', $opinion->slug ?: $opinion->id) }}">{{ $opinion->title }}</a>
                            </h3>
                        </article>
                    @endforeach
                </div>

                <!-- Most Read -->
                <div>
                    <h4
                        class="font-sans font-bold text-sm uppercase tracking-wider text-gray-500 mb-4 flex items-center gap-2 dark:text-gray-400">
                        <span class="w-2 h-2 rounded-full bg-black dark:bg-white"></span> Lo más leído hoy
                    </h4>
                    <ol
                        class="list-decimal list-inside space-y-4 font-serif text-lg font-bold text-gray-900 dark:text-gray-100 marker:font-sans marker:text-gray-300 marker:font-bold">
                        @foreach ($mostReadToday as $article)
                            <li class="pl-2 border-b border-gray-100 dark:border-gray-800 pb-3 last:border-b-0">
                                <a href="{{ route('articles.show', $article->slug) }}"
                                    class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors block ml-[-0.5rem] mt-1 leading-tight">
                                    {{ $article->title }}
                                </a>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>

        </div>

        <!-- SECCIÓN POLÍTICA -->
        @if ($politicaArticles->count() > 0)
            <section class="border-t-2 border-brand-600 py-12 mb-12">
                <div class="flex items-end justify-between mb-8">
                    <h2 class="font-serif text-3xl font-black dark:text-white uppercase tracking-tighter">Política</h2>
                    <a href="{{ route('category.show', 'politica') }}"
                        class="text-xs font-bold uppercase tracking-widest text-brand-600 hover:text-brand-800 dark:text-brand-400 dark:hover:text-brand-300 flex items-center gap-1 group">
                        Ver todo <span class="group-hover:translate-x-1 transition-transform">→</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach ($politicaArticles as $article)
                        <article class="group">
                            <div class="aspect-video overflow-hidden bg-gray-100 dark:bg-gray-800 mb-4 rounded-sm">
                                @if ($article->featured_image)
                                    <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}"
                                        class="img-zoom w-full h-full object-cover">
                                @endif
                            </div>
                            <h3
                                class="font-serif font-bold text-xl leading-snug text-gray-900 dark:text-gray-100 group-hover:text-brand-600 transition-colors">
                                <a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                            </h3>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- SECCIÓN TECNOLOGÍA & ECONOMÍA -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-12 border-t border-gray-100 dark:border-gray-800 pt-12">
            <!-- TECNOLOGÍA -->
            @if ($tecnologiaArticles->count() > 0)
                <div>
                    <h2
                        class="font-serif text-2xl font-black dark:text-white mb-8 border-l-4 border-blue-600 pl-4 uppercase">
                        Tecnología</h2>
                    <div class="space-y-8">
                        @foreach ($tecnologiaArticles as $article)
                            <article class="flex gap-4 group">
                                <div class="w-24 h-24 shrink-0 bg-gray-100 dark:bg-gray-800 rounded-sm overflow-hidden">
                                    @if ($article->featured_image)
                                        <img src="{{ Storage::url($article->featured_image) }}"
                                            class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                                    @endif
                                </div>
                                <div class="space-y-1">
                                    <h3
                                        class="font-serif font-bold text-lg leading-tight dark:text-gray-200 group-hover:text-brand-600 transition-colors">
                                        <a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                                    </h3>
                                    <span
                                        class="text-[10px] uppercase font-bold text-gray-400">{{ $article->published_at ? $article->published_at->format('M d, Y') : $article->created_at->format('M d, Y') }}</span>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    <a href="{{ route('category.show', 'tecnologia') }}"
                        class="inline-block mt-8 text-xs font-bold uppercase tracking-widest text-blue-600 hover:text-blue-800 transition-colors">Más
                        en Tecnología →</a>
                </div>
            @endif

            <!-- ECONOMÍA -->
            @if ($economiaArticles->count() > 0)
                <div>
                    <h2
                        class="font-serif text-2xl font-black dark:text-white mb-8 border-l-4 border-green-600 pl-4 uppercase">
                        Economía</h2>
                    <div class="space-y-8">
                        @foreach ($economiaArticles as $article)
                            <article class="flex gap-4 group">
                                <div class="w-24 h-24 shrink-0 bg-gray-100 dark:bg-gray-800 rounded-sm overflow-hidden">
                                    @if ($article->featured_image)
                                        <img src="{{ Storage::url($article->featured_image) }}"
                                            class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                                    @endif
                                </div>
                                <div class="space-y-1">
                                    <h3
                                        class="font-serif font-bold text-lg leading-tight dark:text-gray-200 group-hover:text-brand-600 transition-colors">
                                        <a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                                    </h3>
                                    <span
                                        class="text-[10px] uppercase font-bold text-gray-400">{{ $article->published_at ? $article->published_at->format('M d, Y') : $article->created_at->format('M d, Y') }}</span>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    <a href="{{ route('category.show', 'economia') }}"
                        class="inline-block mt-8 text-xs font-bold uppercase tracking-widest text-green-600 hover:text-green-800 transition-colors">Más
                        en Economía →</a>
                </div>
            @endif
        </div>

        <!-- SECCIÓN CULTURA -->
        @if ($culturaArticles->count() > 0)
            <section class="border-t-4 border-black dark:border-white py-12 mb-12">
                <div class="flex items-end justify-between mb-8">
                    <h2 class="font-serif text-3xl font-black dark:text-white">Cultura & Estilo</h2>
                    <a href="{{ route('category.show', 'cultura') }}"
                        class="text-xs font-bold uppercase tracking-widest text-brand-600 hover:text-brand-800 dark:text-brand-400 dark:hover:text-brand-300 flex items-center gap-1 group">
                        Ver todo <span class="group-hover:translate-x-1 transition-transform">→</span>
                    </a>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach ($culturaArticles as $article)
                        <article class="group cursor-pointer">
                            <div class="aspect-square bg-gray-100 dark:bg-gray-800 mb-4 overflow-hidden rounded-sm">
                                @if ($article->featured_image)
                                    <img src="{{ Storage::url($article->featured_image) }}"
                                        class="w-full h-full object-cover transition duration-700 group-hover:scale-110 grayscale group-hover:grayscale-0">
                                @else
                                    <div
                                        class="w-full h-full flex items-center justify-center text-gray-400 italic text-xs">
                                        Sin imagen</div>
                                @endif
                            </div>
                            <h3
                                class="font-serif font-bold text-lg leading-tight group-hover:text-brand-600 dark:group-hover:text-brand-400 dark:text-gray-200 mb-2">
                                <a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                            </h3>
                            <span
                                class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ $article->category->name }}</span>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

    </div>
@endsection
