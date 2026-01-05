<div class="space-y-6">
    <!-- Header de Sección -->
    <div
        class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white dark:bg-gray-900 p-6 border border-gray-200 dark:border-gray-800 rounded-sm shadow-sm">
        <div>
            <h2 class="text-2xl font-serif font-bold text-gray-900 dark:text-white uppercase tracking-tight">Etiquetas
                Editorial</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Palabras clave para indexar y relacionar noticias.</p>
        </div>
        <button wire:click="openModal"
            class="inline-flex items-center gap-2 bg-black text-white font-bold text-xs px-6 py-3 rounded-sm hover:opacity-90 transition-all uppercase tracking-widest shadow-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Nueva Etiqueta
        </button>
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
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Filtrar por etiqueta..."
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-700 rounded-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-brand-600 focus:border-brand-600 sm:text-sm transition-all text-xs">
        </div>
    </div>

    <!-- Tabla de Etiquetas -->
    <div
        class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-sm shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
            <thead class="bg-gray-50 dark:bg-gray-800/50">
                <tr>
                    <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nombre
                    </th>
                    <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Slug
                    </th>
                    <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Estado
                    </th>
                    <th class="px-6 py-4 text-right text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                        Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                @foreach ($tags as $tag)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $tag->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-[10px] font-mono text-gray-500 uppercase">#{{ $tag->slug }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button wire:click="toggleStatus({{ $tag->id }})"
                                class="px-2 py-0.5 rounded-sm text-[9px] font-bold uppercase {{ $tag->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $tag->is_active ? 'Activa' : 'Inactiva' }}
                            </button>
                        </td>
                        <td
                            class="px-6 py-4 whitespace-nowrap text-right text-[10px] font-bold uppercase tracking-widest">
                            <button wire:click="edit({{ $tag->id }})"
                                class="text-brand-600 hover:text-brand-800 mr-4">Editar</button>
                            <button wire:click="delete({{ $tag->id }})" wire:confirm="¿Seguro?"
                                class="text-red-400 hover:text-red-600">Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800">
            {{ $tags->links() }}
        </div>
    </div>

    <!-- Modal Etiqueta -->
    @if ($showModal)
        <div class="fixed inset-0 z-[100] overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" wire:click="$set('showModal', false)"></div>
                <div
                    class="relative bg-white dark:bg-gray-900 w-full max-w-sm rounded-sm shadow-2xl border-t-4 border-brand-600">
                    <div
                        class="px-8 py-6 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center">
                        <h3 class="text-xl font-serif font-bold">{{ $tagId ? 'Editar Etiqueta' : 'Nueva Etiqueta' }}
                        </h3>
                    </div>
                    <div class="p-8 space-y-6">
                        <div>
                            <label
                                class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Nombre
                                de la Etiqueta</label>
                            <input type="text" wire:model.live="name"
                                class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-sm text-sm p-3 font-bold placeholder-gray-500"
                                placeholder="Ej: Ultima Hora">
                            @error('name')
                                <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Slug</label>
                            <input type="text" wire:model="slug"
                                class="w-full bg-gray-100 dark:bg-gray-800 border-none rounded-sm text-xs p-3 text-gray-500"
                                readonly>
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Estado</label>
                            <button wire:click="$toggle('is_active')"
                                class="w-full py-2.5 text-[10px] font-bold uppercase border rounded-sm transition-all {{ $is_active ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-700 border-red-200' }}">
                                {{ $is_active ? 'Visible' : 'Oculta' }}
                            </button>
                        </div>
                    </div>
                    <div
                        class="px-8 py-6 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-800 flex justify-end gap-3">
                        <button wire:click="$set('showModal', false)"
                            class="text-xs font-bold text-gray-400 px-4">Cancelar</button>
                        <button wire:click="save"
                            class="bg-brand-600 text-white font-bold text-xs px-8 py-3 rounded-sm uppercase tracking-widest shadow-lg">
                            {{ $tagId ? 'Actualizar' : 'Crear' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
