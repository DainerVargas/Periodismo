<div class="flex flex-wrap items-center gap-6">
    <div class="flex items-center gap-1">
        @foreach($types as $type => $emoji)
            <button wire:click="react('{{ $type }}')" 
                    class="group relative flex flex-col items-center transition-all hover:scale-125 {{ $userReaction === $type ? 'scale-110' : '' }}">
                <span class="text-3xl filter {{ $userReaction && $userReaction !== $type ? 'grayscale' : '' }}">
                    {{ $emoji }}
                </span>
                <span class="absolute -top-8 bg-black text-white text-[10px] font-bold px-2 py-1 rounded-sm opacity-0 group-hover:opacity-100 transition-opacity uppercase tracking-widest pointer-events-none">
                    {{ $type }}
                </span>
                <span class="text-[10px] font-bold text-gray-500 mt-1">
                    {{ $reactionsCount[$type] ?? 0 }}
                </span>
                @if($userReaction === $type)
                    <div class="absolute -bottom-1 w-1 h-1 bg-brand-600 rounded-full"></div>
                @endif
            </button>
        @endforeach
    </div>

    <div class="flex-1 border-l border-gray-100 dark:border-gray-800 pl-6 hidden sm:block">
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-relaxed">
            @if($userReaction)
                Has reaccionado con un <span class="text-brand-600">"{{ $userReaction }}"</span>. <br>¡Gracias por interactuar!
            @else
                ¿Qué te ha parecido esta noticia? <br>Haz clic en un emoji para reaccionar.
            @endif
        </p>
    </div>
</div>
