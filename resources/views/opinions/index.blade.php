@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        <div class="border-b-4 border-black dark:border-white pb-6 mb-12">
            <h1
                class="font-serif text-5xl sm:text-7xl font-black tracking-tighter text-gray-900 dark:text-white uppercase leading-none italic">
                Opinión & Análisis
            </h1>
            <p class="mt-4 text-xl text-gray-600 dark:text-gray-400 font-serif italic max-w-2xl">
                Las voces más influyentes y el análisis profundo de los temas que marcan la agenda nacional e internacional.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
            @foreach ($opinions as $opinion)
                <article
                    class="group relative bg-white dark:bg-gray-900 p-8 border border-gray-100 dark:border-gray-800 hover:shadow-xl transition-all duration-500 rounded-sm">
                    <div class="flex flex-col h-full">
                        <div class="flex items-center gap-4 mb-6">
                            <div
                                class="w-16 h-16 rounded-full bg-gray-100 overflow-hidden shrink-0 ring-4 ring-gray-50 dark:ring-gray-800">
                                @if ($opinion->image)
                                    <img src="{{ Storage::url($opinion->image) }}" alt="{{ $opinion->author }}"
                                        class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($opinion->author) }}"
                                        class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div>
                                <span
                                    class="text-[10px] font-black text-brand-600 uppercase tracking-widest block mb-1">Columnista</span>
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-tight">
                                    {{ $opinion->author }}</h3>
                            </div>
                        </div>

                        <h2
                            class="font-serif text-2xl font-bold leading-tight dark:text-gray-100 group-hover:text-brand-600 transition-colors mb-4">
                            <a href="{{ route('opinions.show', $opinion->slug ?: $opinion->id) }}" class="link-underline">
                                {{ $opinion->title }}
                            </a>
                        </h2>

                        <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed italic line-clamp-4 flex-grow">
                            "{{ Str::limit($opinion->content, 200) }}"
                        </p>

                        <div
                            class="mt-8 pt-6 border-t border-gray-50 dark:border-gray-800 flex justify-between items-center text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">
                            <span>{{ $opinion->created_at->format('M d, Y') }}</span>
                            <a href="{{ route('opinions.show', $opinion->slug ?: $opinion->id) }}"
                                class="text-black dark:text-white hover:text-brand-600 transition-colors">Leer más →</a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-16">
            {{ $opinions->links() }}
        </div>
    </div>
@endsection
