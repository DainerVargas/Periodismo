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
                <div class="flex gap-4">
                    <!-- Social Share Placeholder -->
                    <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">Compartir columna</span>
                </div>
            </div>
        </div>
    </article>
@endsection
