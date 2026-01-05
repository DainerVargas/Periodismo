<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-sm p-6 shadow-sm">

    <!-- Hero Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold font-serif text-gray-900 dark:text-white tracking-tight italic">Centro de
                Control Editorial</h2>
            <p class="text-sm text-gray-400 dark:text-gray-500">Panel unificado para la gestión de contenidos y equipo
                profesional.</p>
        </div>

        <div
            class="flex items-center gap-3 px-3 py-1.5 bg-brand-50 dark:bg-brand-900/20 rounded-sm border border-brand-100 dark:border-brand-800">
            <span class="w-1.5 h-1.5 rounded-full bg-brand-600 animate-pulse"></span>
            <span
                class="text-[9px] font-black text-brand-700 dark:text-brand-400 uppercase tracking-widest letter-spacing-1.5">Conectado
                como {{ auth()->user()->role }}</span>
        </div>
    </div>

    <!-- Navegación de Pestañas -->
    <div
        class="flex items-center border-b-2 border-gray-50 dark:border-gray-800 mb-8 overflow-x-auto no-scrollbar scroll-smooth">
        @foreach (['users' => 'Usuarios', 'categories' => 'Categorías', 'articles' => 'Noticias', 'opinions' => 'Opinión', 'tags' => 'Etiquetas', 'roles' => 'Estructura'] as $tab => $label)
            @if (auth()->user()->hasPermission("manage_$tab") || $tab === 'roles')
                <button wire:click="switchTab('{{ $tab }}')"
                    class="group relative py-4 px-6 text-[10px] font-black uppercase tracking-[0.2em] transition-all border-b-2 -mb-[2px] cursor-pointer {{ $currentTab === $tab ? 'text-brand-600 border-brand-600 bg-brand-50/5' : 'text-gray-400 border-transparent hover:text-gray-900 dark:hover:text-white hover:border-gray-300' }}">
                    <div class="flex items-center gap-2">
                        @if ($tab === 'users')
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        @elseif($tab === 'categories')
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                        @elseif($tab === 'articles')
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2zM14 4v4h4"></path>
                            </svg>
                        @elseif($tab === 'opinions')
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        @elseif($tab === 'tags')
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                </path>
                            </svg>
                        @else
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                        @endif
                        {{ $label }}
                    </div>
                </button>
            @endif
        @endforeach
    </div>

    <!-- Contenido Dinámico -->
    <div class="relative min-h-[500px]">
        @if ($currentTab === 'users' && auth()->user()->hasPermission('manage_users'))
            <livewire:admin.user-management wire:key="tab-comp-users" />
        @elseif($currentTab === 'categories' && auth()->user()->hasPermission('manage_categories'))
            <livewire:admin.category-management wire:key="tab-comp-categories" />
        @elseif($currentTab === 'articles' && auth()->user()->hasPermission('manage_articles'))
            <livewire:admin.article-management wire:key="tab-comp-articles" />
        @elseif($currentTab === 'opinions' && auth()->user()->hasPermission('manage_opinions'))
            <livewire:admin.opinion-management wire:key="tab-comp-opinions" />
        @elseif($currentTab === 'tags' && auth()->user()->hasPermission('manage_tags'))
            <livewire:admin.tag-management wire:key="tab-comp-tags" />
        @elseif($currentTab === 'roles')
            <div
                class="animate-in fade-in slide-in-from-bottom-2 duration-500 bg-gray-50 dark:bg-gray-800/20 p-8 rounded-sm border border-gray-100 dark:border-gray-800">
                <div class="max-w-3xl">
                    <h3 class="text-xl font-serif font-bold text-gray-900 dark:text-white mb-4 italic tracking-tight">
                        Manual de Estilo y Responsabilidades</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed mb-8">
                        Como parte del equipo de <span class="text-brand-600 font-bold">Periodismo Digital</span>, cada
                        rol tiene permisos específicos para mantener la integridad de nuestra línea editorial.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="w-1 h-3 bg-black dark:bg-white"></div>
                                <h4 class="text-[10px] font-black uppercase tracking-widest">Nivel Administrativo</h4>
                            </div>
                            <p class="text-xs text-gray-500">Gestión de RRHH, asignación de cargos e inmunidad en el
                                sistema.</p>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="w-1 h-3 bg-brand-600"></div>
                                <h4 class="text-[10px] font-black uppercase tracking-widest text-brand-600">Nivel
                                    Editorial</h4>
                            </div>
                            <p class="text-xs text-gray-500">Curaduría de noticias, creación de secciones temáticas y
                                moderación.</p>
                        </div>
                    </div>

                    <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-800">
                        <div
                            class="inline-flex items-center gap-2 text-[9px] font-mono text-gray-400 uppercase tracking-tighter">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Todos los cambios en el núcleo editorial quedan registrados en el log de auditoría.
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
