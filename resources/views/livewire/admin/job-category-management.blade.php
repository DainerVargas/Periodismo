<div class="space-y-6">
    <!-- Header de Sección -->
    <div
        class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white dark:bg-gray-900 p-6 border border-gray-200 dark:border-gray-800 rounded-sm shadow-sm">
        <div>
            <h2 class="text-2xl font-serif font-bold text-gray-900 dark:text-white">Categorías de Vacantes</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Administra los sectores y categorías laborales
                disponibles en la bolsa de empleo.</p>
        </div>
        @if (auth()->user()->role === 'admin')
            <button wire:click="openModal"
                class="inline-flex items-center gap-2 bg-black text-white font-bold text-xs px-6 py-3 rounded-sm hover:opacity-90 transition-all uppercase tracking-widest shadow-lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nueva Categoría
            </button>
        @endif
    </div>

    <!-- Barra de Búsqueda -->
    <div
        class="flex items-center bg-gray-50 dark:bg-gray-800/50 p-4 rounded-sm border border-gray-200 dark:border-gray-800">
        <div class="relative flex-1 max-w-md">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </span>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Filtrar por nombre..."
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-700 rounded-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-brand-600 focus:border-brand-600 sm:text-sm transition-all text-xs">
        </div>
    </div>

    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative text-sm font-bold">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative text-sm font-bold">
            {{ session('error') }}
        </div>
    @endif

    <!-- Lista de Categorías -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($categories as $category)
            <div
                class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-sm shadow-sm hover:shadow-md transition-all group overflow-hidden">
                <div class="h-1 w-full bg-brand-600"></div>
                <div class="p-6">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-lg font-serif font-bold text-gray-900 dark:text-white">{{ $category->name }}
                        </h3>
                        <span
                            class="px-2 py-0.5 rounded-sm text-[9px] font-bold uppercase {{ $category->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $category->is_active ? 'Activa' : 'Inactiva' }}
                        </span>
                    </div>
                    <p class="text-[10px] text-gray-400 font-mono mb-4">{{ $category->slug }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-6 flex-grow italic line-clamp-2">
                        {{ $category->description ?: 'Categoría dedicada para ofertas de empleo.' }}
                    </p>
                    <div class="flex justify-between items-center pt-4 border-t border-gray-50 dark:border-gray-800">
                        <div class="flex items-center gap-2">
                            <span
                                class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">{{ $category->vacancies()->count() }}
                                Vacantes</span>
                        </div>
                        @if (auth()->user()->role === 'admin')
                            <div class="flex gap-4">
                                <button wire:click="edit({{ $category->id }})"
                                    class="text-[10px] font-bold text-brand-600 uppercase tracking-widest">Editar</button>
                                <button wire:click="delete({{ $category->id }})"
                                    wire:confirm="¿Seguro que deseas eliminar esta categoría? No podrá ser eliminada si tiene vacantes vinculadas."
                                    class="text-[10px] font-bold text-red-400 uppercase tracking-widest">Borrar</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div
                class="col-span-full py-12 text-center bg-gray-50 dark:bg-gray-800/20 rounded-sm border-2 border-dashed border-gray-200 dark:border-gray-800">
                <p class="text-gray-400 text-sm font-bold uppercase tracking-widest">No se encontraron categorías</p>
            </div>
        @endforelse
    </div>

    <!-- Modal Categoría -->
    @if ($showModal)
        <div class="fixed inset-0 z-[100] overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 text-center">
                <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"
                    wire:click="$set('showModal', false)"></div>

                <div
                    class="relative inline-block align-middle bg-white dark:bg-gray-900 rounded-sm text-left shadow-2xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full border-t-4 border-brand-600 overflow-hidden">
                    <div
                        class="px-8 py-6 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center">
                        <h3 class="text-xl font-serif font-bold text-gray-900 dark:text-white">
                            {{ $categoryId ? 'Editar Categoría de Vacante' : 'Nueva Categoría de Vacante' }}</h3>
                        <button wire:click="$set('showModal', false)"
                            class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="p-8 space-y-6">
                        <div>
                            <label
                                class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Nombre
                                de la Categoría</label>
                            <input type="text" wire:model.live="name"
                                placeholder="Ej: Periodismo Digital, Marketing, etc."
                                class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-sm text-sm p-3 font-bold text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500/20">
                            @error('name')
                                <span class="text-red-500 text-[10px] font-bold mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Slug
                                (Ruta única)</label>
                            <input type="text" wire:model="slug" readonly
                                class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-sm text-xs p-3 text-gray-400 cursor-not-allowed">
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Descripción</label>
                            <textarea wire:model="description" rows="3" placeholder="Breve descripción sobre el campo de esta categoría..."
                                class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-sm text-xs p-3 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500/20 shadow-inner"></textarea>
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Estado
                                de Visibilidad</label>
                            <button wire:click="$toggle('is_active')"
                                class="w-full py-3 text-[10px] font-bold uppercase border rounded-sm transition-all {{ $is_active ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-700 border-red-200' }}">
                                {{ $is_active ? 'Activa y Visible' : 'Oculta / Inactiva' }}
                            </button>
                        </div>
                    </div>

                    <div
                        class="px-8 py-6 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-800 flex justify-end gap-3">
                        <button wire:click="$set('showModal', false)"
                            class="text-xs font-bold text-gray-400 px-4 hover:text-gray-600 transition-colors uppercase tracking-widest">Cancelar</button>
                        <button wire:click="save"
                            class="bg-brand-600 text-white font-bold text-xs px-10 py-3 rounded-sm uppercase tracking-widest shadow-lg hover:bg-brand-700 transition-all">
                            {{ $categoryId ? 'Actualizar' : 'Crear Categoría' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
