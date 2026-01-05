@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        <div class="border-b-4 border-black dark:border-white pb-6 mb-12">
            <div class="flex items-center gap-4 mb-2">
                <span class="w-12 h-1 bg-gray-400"></span>
                <span class="text-xs font-bold uppercase tracking-widest text-gray-400">Archivos por Etiqueta</span>
            </div>
            <h1
                class="font-serif text-5xl sm:text-7xl font-black tracking-tighter text-gray-900 dark:text-white uppercase leading-none">
                #{{ $tag->name }}
            </h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <div class="lg:col-span-8 space-y-12">
                @forelse($articles as $article)
                    <article class="group relative flex flex-col md:flex-row gap-8 items-start">
                        <div
                            class="w-full md:w-1/3 aspect-[4/3] bg-gray-100 dark:bg-gray-800 rounded-sm overflow-hidden shrink-0">
                            @if ($article->featured_image)
                                <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}"
                                    class="img-zoom w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 italic">Sin imagen
                                </div>
                            @endif
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <span
                                    class="text-[10px] font-bold uppercase tracking-widest text-brand-600">{{ $article->category->name }}</span>
                            </div>
                            <h2
                                class="font-serif text-3xl font-bold leading-tight dark:text-gray-100 group-hover:text-brand-600 transition-colors">
                                <a href="{{ route('articles.show', $article->slug) }}">
                                    {{ $article->title }}
                                </a>
                            </h2>
                            <p class="text-gray-600 dark:text-gray-400 leading-relaxed line-clamp-3">
                                {{ $article->excerpt ?? Str::limit(strip_tags($article->content), 150) }}
                            </p>
                            <div
                                class="flex items-center gap-4 text-[10px] uppercase font-bold tracking-widest text-gray-400">
                                <span>{{ $article->author->name }}</span>
                                <span>•</span>
                                <span>{{ $article->published_at ? $article->published_at->format('d M, Y') : $article->created_at->format('d M, Y') }}</span>
                            </div>
                        </div>
                    </article>
                @empty
                    <div
                        class="p-20 bg-gray-50 dark:bg-gray-900 text-center rounded-lg border-2 border-dashed border-gray-200 dark:border-gray-800">
                        <p class="text-gray-400 font-serif italic text-lg text-balance">No hemos encontrado artículos con
                            esta etiqueta todavía.</p>
                    </div>
                @endforelse

                <div class="mt-12">
                    {{ $articles->links() }}
                </div>
            </div>

            <div class="lg:col-span-4 space-y-10 lg:pl-10 lg:border-l border-gray-100 dark:border-gray-800">
                <div>
                    <h3
                        class="font-bold text-xs uppercase tracking-widest mb-6 py-2 border-y border-black dark:border-white">
                        Etiquetas Populares</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach (App\Models\Tag::where('is_active', true)->where('id', '!=', $tag->id)->take(15)->get() as $other)
                            <a href="{{ route('tags.show', $other->slug) }}"
                                class="px-3 py-1 bg-gray-100 dark:bg-gray-800 text-[9px] font-bold uppercase tracking-widest hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black transition-colors rounded-full">
                                #{{ $other->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
