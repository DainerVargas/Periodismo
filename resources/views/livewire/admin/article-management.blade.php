<div class="space-y-6">
    <!-- Header de Sección -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white dark:bg-gray-900 p-6 border border-gray-200 dark:border-gray-800 rounded-sm shadow-sm">
        <div>
            <h2 class="text-2xl font-serif font-bold text-gray-900 dark:text-white">Gestión de Noticias</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Publica, edita y organiza el contenido de tu periódico.</p>
        </div>
        <button wire:click="openModal" class="inline-flex items-center gap-2 bg-brand-600 text-white font-bold text-xs px-6 py-3 rounded-sm hover:bg-brand-700 transition-all uppercase tracking-widest shadow-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Publicar Noticia
        </button>
    </div>

    <!-- Barra de Búsqueda y Filtros -->
    <div class="flex items-center bg-gray-50 dark:bg-gray-800/50 p-4 rounded-sm border border-gray-200 dark:border-gray-800">
        <div class="relative flex-1 max-w-md">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </span>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Buscar por título o contenido..." class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-700 rounded-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-brand-600 focus:border-brand-600 sm:text-sm transition-all text-xs">
        </div>
    </div>

    <!-- Tabla de Contenido -->
    <div class="overflow-hidden bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 rounded-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Contenido</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Categoría</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Estado</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Autor</th>
                        <th class="px-6 py-4 text-right text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($articles as $article)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-16 overflow-hidden rounded-sm bg-gray-100 dark:bg-gray-800">
                                    @if($article->featured_image)
                                        <img class="h-full w-full object-cover" src="{{ Storage::url($article->featured_image) }}" alt="">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center">
                                            <svg class="h-5 w-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4 max-w-sm">
                                    <div class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ $article->title }}</div>
                                    <div class="text-[10px] text-gray-500 font-medium">{{ $article->created_at->format('d M, Y') }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-0.5 text-[10px] font-bold rounded-sm uppercase tracking-wider" style="background-color: {{ $article->category->color }}22; color: {{ $article->category->color }}">
                                {{ $article->category->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-[9px] font-bold uppercase rounded-sm {{ $article->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $article->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-xs text-gray-600 dark:text-gray-400 font-medium">{{ $article->author->name }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-[10px] font-bold">
                            <button wire:click="edit({{ $article->id }})" class="text-brand-600 mr-4">EDITAR</button>
                            <button wire:click="delete({{ $article->id }})" wire:confirm="¿Seguro?" class="text-red-500">BORRAR</button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-6 py-10 text-center text-gray-400">No hay noticias.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50">
            {{ $articles->links() }}
        </div>
    </div>

    <!-- Modal de Article -->
    @if($showModal)
    <div class="fixed inset-0 z-[100] overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" wire:click="$set('showModal', false)"></div>
            
            <div class="relative bg-white dark:bg-gray-900 w-full max-w-5xl rounded-sm shadow-2xl border-t-4 border-brand-600 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center">
                    <h3 class="text-xl font-serif font-bold">{{ $articleId ? 'Editar Noticia' : 'Publicar Nueva Noticia' }}</h3>
                    <button @click="$wire.showModal = false" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>

                <div class="p-8 grid grid-cols-1 lg:grid-cols-12 gap-10">
                    <!-- Editor -->
                    <div class="lg:col-span-8 space-y-6">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Título</label>
                            <input type="text" wire:model.live="title" class="w-full text-2xl font-serif font-bold border-0 border-b-2 border-gray-100 focus:border-brand-600 bg-transparent p-0">
                            @error('title') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Resumen</label>
                            <textarea wire:model="excerpt" rows="2" class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-sm text-sm p-4 italic"></textarea>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Contenido completo</label>
                            <textarea wire:model="content" rows="12" class="w-full bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-sm p-4 text-base leading-relaxed"></textarea>
                            @error('content') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:col-span-4 space-y-6">
                        <div class="bg-gray-50 dark:bg-gray-800/50 p-6 rounded-sm border border-gray-100 dark:border-gray-700 space-y-6">
                            <div>
                                <label class="block text-xs font-bold mb-2">Imagen de Portada</label>
                                <div class="relative aspect-video bg-gray-200 dark:bg-gray-700 rounded-sm overflow-hidden flex items-center justify-center">
                                    @if($featured_image)
                                        <img src="{{ $featured_image->temporaryUrl() }}" class="absolute inset-0 w-full h-full object-cover">
                                    @elseif($existing_featured_image)
                                        <img src="{{ Storage::url($existing_featured_image) }}" class="absolute inset-0 w-full h-full object-cover">
                                    @else
                                        <span class="text-[10px] font-bold text-gray-400 uppercase">Cargar Imagen</span>
                                    @endif
                                    <input type="file" wire:model="featured_image" class="absolute inset-0 opacity-0 cursor-pointer">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold mb-2">Sección Editorial</label>
                                <select wire:model="category_id" class="w-full bg-white dark:bg-gray-900 border-gray-200 text-xs rounded-sm">
                                    <option value="">Selecciona...</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold mb-2">Estado</label>
                                <select wire:model="status" class="w-full bg-white dark:bg-gray-900 border-gray-200 text-xs rounded-sm">
                                    <option value="draft">Borrador</option>
                                    <option value="published">Publicado</option>
                                </select>
                            </div>
                        </div>

                        <button wire:click="save" class="w-full bg-brand-600 text-white font-bold text-xs py-4 rounded-sm uppercase tracking-widest shadow-lg">
                            {{ $articleId ? 'Actualizar' : 'Publicar' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
