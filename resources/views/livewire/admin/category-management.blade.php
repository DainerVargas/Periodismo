<div class="space-y-6">
    <!-- Header de Sección -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white dark:bg-gray-900 p-6 border border-gray-200 dark:border-gray-800 rounded-sm shadow-sm">
        <div>
            <h2 class="text-2xl font-serif font-bold text-gray-900 dark:text-white">Categorías del Periódico</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Organiza tus noticias por temas y define sus estilos visuales.</p>
        </div>
        <button wire:click="openModal" class="inline-flex items-center gap-2 bg-black text-white font-bold text-xs px-6 py-3 rounded-sm hover:opacity-90 transition-all uppercase tracking-widest shadow-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Nueva Categoría
        </button>
    </div>

    <!-- Barra de Búsqueda -->
    <div class="flex items-center bg-gray-50 dark:bg-gray-800/50 p-4 rounded-sm border border-gray-200 dark:border-gray-800">
        <div class="relative flex-1 max-w-md">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </span>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Filtrar por nombre..." class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-700 rounded-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-brand-600 focus:border-brand-600 sm:text-sm transition-all text-xs">
        </div>
    </div>

    <!-- Lista de Categorías -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($categories as $category)
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-sm shadow-sm hover:shadow-md transition-all group overflow-hidden">
                <div class="h-1 w-full" style="background-color: {{ $category->color }}"></div>
                <div class="p-6">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-lg font-serif font-bold text-gray-900 dark:text-white">{{ $category->name }}</h3>
                        <span class="px-2 py-0.5 rounded-sm text-[9px] font-bold uppercase {{ $category->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $category->is_active ? 'Activa' : 'Inactiva' }}
                        </span>
                    </div>
                    <p class="text-[10px] text-gray-400 font-mono mb-4">/seccion/{{ $category->slug }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-6 flex-grow italic line-clamp-2">
                        {{ $category->description ?: 'Sector editorial para noticias variadas.' }}
                    </p>
                    <div class="flex justify-between items-center pt-4 border-t border-gray-50 dark:border-gray-800">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full" style="background-color: {{ $category->color }}"></div>
                            <span class="text-[9px] font-bold text-gray-400">{{ strtoupper($category->color) }}</span>
                        </div>
                        <div class="flex gap-4">
                            <button wire:click="edit({{ $category->id }})" class="text-[10px] font-bold text-brand-600 uppercase tracking-widest">Editar</button>
                            <button wire:click="delete({{ $category->id }})" wire:confirm="¿Seguro?" class="text-[10px] font-bold text-red-400 uppercase tracking-widest">Borrar</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal Categoría -->
    @if($showModal)
    <div class="fixed inset-0 z-[100] overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" wire:click="$set('showModal', false)"></div>
            
            <div class="relative bg-white dark:bg-gray-900 w-full max-w-lg rounded-sm shadow-2xl border-t-4 border-brand-600 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center">
                    <h3 class="text-xl font-serif font-bold">{{ $categoryId ? 'Editar Categoría' : 'Nueva Sección' }}</h3>
                    <button @click="$wire.showModal = false" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>

                <div class="p-8 space-y-6">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Nombre</label>
                        <input type="text" wire:model.live="name" class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-sm text-sm p-3 font-bold">
                        @error('name') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Ruta Única (Slug)</label>
                        <input type="text" wire:model="slug" class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-sm text-xs p-3 text-gray-500">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Descripción</label>
                        <textarea wire:model="description" rows="3" class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-sm text-xs p-3"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Color</label>
                            <input type="color" wire:model="color" class="h-10 w-full border-none rounded-sm cursor-pointer p-0 bg-transparent">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Estado</label>
                            <button wire:click="$toggle('is_active')" class="w-full py-2.5 text-[10px] font-bold uppercase border rounded-sm transition-all {{ $is_active ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-700 border-red-200' }}">
                                {{ $is_active ? 'Activa' : 'Inactiva' }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="px-8 py-6 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-800 flex justify-end gap-3">
                    <button @click="$wire.showModal = false" class="text-xs font-bold text-gray-400 px-4">Cancelar</button>
                    <button wire:click="save" class="bg-brand-600 text-white font-bold text-xs px-8 py-3 rounded-sm uppercase tracking-widest shadow-lg">
                        {{ $categoryId ? 'Guardar' : 'Crear' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
