<div class="space-y-6">
    <!-- Header de Sección -->
    <div
        class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white dark:bg-gray-900 p-6 border border-gray-200 dark:border-gray-800 rounded-sm shadow-sm">
        <div>
            <h2 class="text-2xl font-serif font-bold text-gray-900 dark:text-white uppercase tracking-tight">Columna de
                Opinión</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Gestiona los artículos de análisis y opinión de tus
                colaboradores.</p>
        </div>
        @if (auth()->user()->role !== 'user')
            <button wire:click="openModal"
                class="inline-flex items-center gap-2 bg-black text-white font-bold text-xs px-6 py-3 rounded-sm hover:opacity-90 transition-all uppercase tracking-widest shadow-lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nueva Opinión
            </button>
        @endif
    </div>

    <!-- Lista de Opiniones -->
    <div class="grid grid-cols-1 gap-4">
        @foreach ($opinions as $opinion)
            <div
                class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 p-6 rounded-sm shadow-sm flex gap-6 items-center group">
                <div
                    class="w-16 h-16 rounded-full bg-gray-100 overflow-hidden shrink-0 ring-2 ring-gray-100 dark:ring-gray-800">
                    @if ($opinion->image)
                        <img src="{{ Storage::url($opinion->image) }}" class="w-full h-full object-cover">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($opinion->author) }}"
                            class="w-full h-full object-cover">
                    @endif
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <div>
                            <span
                                class="text-[9px] font-black text-brand-600 uppercase tracking-widest">{{ $opinion->author }}</span>
                            <h3 class="text-lg font-serif font-bold text-gray-900 dark:text-white leading-tight mt-1">
                                {{ $opinion->title }}</h3>
                        </div>
                        @if (auth()->user()->role !== 'user')
                            <div class="flex gap-4 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button wire:click="edit({{ $opinion->id }})"
                                    class="text-[10px] font-bold text-gray-400 uppercase hover:text-brand-600">Editar</button>
                                <button wire:click="delete({{ $opinion->id }})" wire:confirm="¿Borrar columna?"
                                    class="text-[10px] font-bold text-gray-400 uppercase hover:text-red-600">Eliminar</button>
                            </div>
                        @else
                            <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                                <span class="text-[10px] font-bold text-gray-400 uppercase">Solo Lectura</span>
                            </div>
                        @endif
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 line-clamp-2 italic">{{ $opinion->content }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $opinions->links() }}
    </div>

    <!-- Modal Opinión -->
    @if ($showModal)
        <div class="fixed inset-0 z-[100] overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 py-8">
                <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" wire:click="$set('showModal', false)"></div>
                <div
                    class="relative bg-white dark:bg-gray-900 w-full max-w-2xl rounded-sm shadow-2xl border-t-4 border-black dark:border-white">
                    <div class="p-8">
                        <div class="flex justify-between items-center mb-8">
                            <h3 class="text-2xl font-serif font-bold italic">Redactar Columna de Opinión</h3>
                            <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                            <div class="space-y-6">
                                <div>
                                    <label
                                        class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Autor
                                        / Columnista</label>
                                    <input type="text" wire:model="author"
                                        class="w-full border-b-2 border-gray-100 dark:border-gray-800 bg-transparent text-sm p-2 focus:border-brand-600 transition-colors font-bold outline-none">
                                    @error('author')
                                        <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label
                                        class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Título
                                        del Artículo</label>
                                    <input type="text" wire:model.live="title"
                                        class="w-full border-b-2 border-gray-100 dark:border-gray-800 bg-transparent text-sm p-2 focus:border-brand-600 transition-colors outline-none">
                                    @error('title')
                                        <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label
                                        class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Ruta
                                        (Slug)</label>
                                    <input type="text" wire:model="slug"
                                        class="w-full border-b border-gray-100 dark:border-gray-800 bg-transparent text-[10px] p-2 text-gray-400 outline-none"
                                        readonly>
                                </div>
                            </div>

                            <div
                                class="flex flex-col items-center justify-center p-6 bg-gray-50 dark:bg-gray-800/50 rounded-sm border-2 border-dashed border-gray-200 dark:border-gray-800">
                                @if ($image)
                                    <img src="{{ $image->temporaryUrl() }}"
                                        class="w-24 h-24 rounded-full object-cover mb-4">
                                @elseif($existing_image)
                                    <img src="{{ Storage::url($existing_image) }}"
                                        class="w-24 h-24 rounded-full object-cover mb-4">
                                @else
                                    <div
                                        class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif

                                <label
                                    class="cursor-pointer text-[10px] font-bold text-brand-600 uppercase tracking-widest">
                                    <span>{{ $image || $existing_image ? 'Cambiar Foto' : 'Subir Foto' }}</span>
                                    <input type="file" wire:model="image" class="hidden">
                                </label>
                            </div>
                        </div>

                        <div class="mb-8">
                            <label
                                class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Contenido
                                de la Columna</label>
                            <textarea wire:model="content" rows="6"
                                class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-sm text-sm p-4 text-gray-600 dark:text-gray-300 placeholder-gray-400 italic"
                                placeholder="Escribe aquí el análisis..."></textarea>
                            @error('content')
                                <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex justify-end gap-3 pt-6 border-t border-gray-100 dark:border-gray-800">
                            <button wire:click="$set('showModal', false)"
                                class="text-xs font-bold text-gray-400 px-4">Cancelar</button>
                            <button wire:click="save"
                                class="bg-black text-white dark:bg-white dark:text-black font-bold text-xs px-10 py-3 rounded-sm uppercase tracking-widest shadow-lg hover:opacity-90 transition-all">
                                {{ $opinionId ? 'Actualizar Columna' : 'Publicar Opinión' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
