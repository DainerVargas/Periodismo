<div class="space-y-12">
    <!-- Formulario de Comentario -->
    @auth
        <div class="bg-gray-50 dark:bg-gray-800/50 p-6 rounded-sm border border-gray-100 dark:border-gray-800 shadow-sm transition-all" id="comment-form">
            @if($replyTo)
                <div class="flex justify-between items-center bg-brand-50 dark:bg-brand-900/20 px-4 py-2 rounded-sm mb-4 border border-brand-100 dark:border-brand-800">
                    <span class="text-xs font-bold text-brand-700 dark:text-brand-400 uppercase tracking-widest">Respondiendo a {{ $replyingToName }}</span>
                    <button wire:click="cancelReply" class="text-xs font-bold text-gray-400 hover:text-red-500 uppercase tracking-widest transition-colors">Cancelar</button>
                </div>
            @endif

            <div class="flex gap-4">
                <img class="w-10 h-10 rounded-full hidden sm:block ring-1 ring-gray-200 dark:ring-gray-700" src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name) }}" alt="">
                <div class="flex-1 space-y-4">
                    <textarea wire:model="newComment" rows="4" placeholder="Escribe tu opinión respetuosa sobre esta noticia..." class="block w-full text-sm bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-700 rounded-sm focus:ring-1 focus:ring-brand-500 dark:text-gray-200 p-4 leading-relaxed"></textarea>
                    @error('newComment') <span class="text-red-500 text-[10px] font-bold uppercase tracking-widest">{{ $message }}</span> @enderror
                    
                    <div class="flex justify-end">
                        <button wire:click="postComment" class="bg-black dark:bg-white text-white dark:text-black font-bold text-xs px-8 py-3 rounded-sm hover:opacity-90 transition-all uppercase tracking-widest shadow-lg">
                            {{ $replyTo ? 'Publicar Respuesta' : 'Publicar Comentario' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-gray-50 dark:bg-gray-800/50 p-8 rounded-sm border-2 border-dashed border-gray-200 dark:border-gray-700 text-center">
            <p class="text-gray-500 dark:text-gray-400 font-serif italic mb-4">Debes iniciar sesión para participar en el debate.</p>
            <a href="{{ route('login') }}" class="inline-flex bg-brand-600 text-white font-bold text-xs px-6 py-2 rounded-sm hover:bg-brand-700 transition-colors uppercase tracking-widest">Iniciar Sesión</a>
        </div>
    @endauth

    <!-- Lista de Comentarios -->
    <div class="space-y-8 mt-12">
        @forelse($comments as $comment)
            <div class="flex gap-4 group">
                <img class="w-12 h-12 rounded-full ring-2 ring-gray-100 dark:ring-gray-800 shadow-sm" src="{{ $comment->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($comment->user->name) }}" alt="">
                <div class="flex-1">
                    <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 p-6 rounded-sm relative shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <h4 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">{{ $comment->user->name }}</h4>
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            @auth
                                <button wire:click="setReply({{ $comment->id }}, '{{ $comment->user->name }}')" class="text-[10px] font-bold text-brand-600 hover:text-brand-800 uppercase tracking-widest transition-colors">Responder</button>
                            @endauth
                        </div>
                        <p class="text-base text-gray-700 dark:text-gray-300 leading-relaxed font-sans">
                            {!! nl2br(e($comment->content)) !!}
                        </p>
                    </div>

                    <!-- Respuestas -->
                    @if($comment->replies->count() > 0)
                        <div class="mt-4 ml-8 space-y-4 border-l-2 border-gray-100 dark:border-gray-800 pl-4">
                            @foreach($comment->replies as $reply)
                                <div class="flex gap-3">
                                    <img class="w-8 h-8 rounded-full ring-1 ring-gray-100 dark:ring-gray-800" src="{{ $reply->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($reply->user->name) }}" alt="">
                                    <div class="flex-1 bg-gray-50 dark:bg-gray-800/30 p-4 rounded-sm border border-gray-100 dark:border-gray-800/50">
                                        <div class="flex justify-between items-center mb-2">
                                            <h5 class="text-[10px] font-bold text-gray-900 dark:text-white uppercase tracking-wider">{{ $reply->user->name }}</h5>
                                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $reply->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                                            {!! nl2br(e($reply->content)) !!}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="py-12 text-center text-gray-400 font-serif italic border-t border-gray-100 dark:border-gray-800">
                Sé el primero en comentar esta noticia...
            </div>
        @endforelse
    </div>
</div>
