@extends('layouts.app')

@section('content')
    <article class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-12 text-center">
            <span class="text-[11px] font-black text-brand-600 uppercase tracking-[0.3em] block mb-4">Columna de
                Opinión</span>
            <h1
                class="font-serif text-4xl sm:text-6xl font-black tracking-tighter text-gray-900 dark:text-white leading-tight italic">
                {{ $opinion->title }}
            </h1>

            <div class="mt-10 flex flex-col items-center">
                <div
                    class="w-24 h-24 rounded-full bg-gray-100 overflow-hidden mb-4 ring-4 ring-gray-50 dark:ring-gray-800 shadow-lg">
                    @if ($opinion->image)
                        <img src="{{ Storage::url($opinion->image) }}" alt="{{ $opinion->author }}"
                            class="w-full h-full object-cover">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($opinion->author) }}"
                            class="w-full h-full object-cover">
                    @endif
                </div>
                <span class="text-lg font-bold text-gray-900 dark:text-white">{{ $opinion->author }}</span>
                <span
                    class="text-[10px] font-mono text-gray-400 uppercase tracking-widest mt-1">{{ $opinion->created_at->format('d F, Y') }}</span>
            </div>
        </div>

        <div
            class="prose prose-lg dark:prose-invert mx-auto font-serif text-xl leading-relaxed text-gray-700 dark:text-gray-300 italic">
            {!! nl2br(e($opinion->content)) !!}
        </div>

        <div class="mt-20 pt-12 border-t border-black dark:border-white">
            <div class="flex justify-between items-center">
                <a href="{{ route('opinions.index') }}"
                    class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-black dark:hover:text-white transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver a Opinión
                </a>
                <div class="flex items-center gap-6">
                    <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">Compartir columna:</span>
                    <div class="flex gap-3">
                        <!-- Facebook -->
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                            target="_blank"
                            class="w-8 h-8 rounded-full border border-gray-100 dark:border-gray-800 flex items-center justify-center text-gray-400 hover:text-blue-600 hover:border-blue-600 transition-all">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        <!-- X (Twitter) -->
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($opinion->title) }}"
                            target="_blank"
                            class="w-8 h-8 rounded-full border border-gray-100 dark:border-gray-800 flex items-center justify-center text-gray-400 hover:text-black dark:hover:text-white hover:border-black dark:hover:border-white transition-all">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                            </svg>
                        </a>
                        <!-- Copy Link -->
                        <button x-data="{ copied: false }"
                            @click="navigator.clipboard.writeText(window.location.href).then(() => { copied = true; setTimeout(() => copied = false, 2000) })"
                            class="w-8 h-8 rounded-full border border-gray-100 dark:border-gray-800 flex items-center justify-center text-gray-400 hover:text-brand-600 hover:border-brand-600 transition-all relative"
                            :class="{ '!border-green-500 !text-green-500': copied }">

                            <svg x-show="!copied" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                </path>
                            </svg>

                            <svg x-show="copied" style="display: none;" class="w-4 h-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>

                            <div x-show="copied" x-transition.opacity.duration.200ms style="display: none;"
                                class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 bg-gray-900 dark:bg-white text-white dark:text-gray-900 text-[9px] font-bold py-1 px-2 rounded-sm shadow-lg whitespace-nowrap uppercase tracking-widest">
                                Copiado
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </article>
@endsection
