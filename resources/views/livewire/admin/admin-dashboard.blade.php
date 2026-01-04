<div x-data="{ 
        tab: 'users',
        init() {
            // Permitir cambio de pestaña externo si es necesario
            this.$watch('tab', (val) => {
                console.log('Tab changed to:', val);
            })
        }
     }" class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-sm p-6 shadow-sm">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold font-serif text-gray-900 dark:text-white tracking-tight">Centro de Control Editorial</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Panel unificado de administración y equipo.</p>
        </div>
        
        <div class="flex items-center gap-3 px-3 py-1.5 bg-brand-50 dark:bg-brand-900/20 rounded-sm border border-brand-100 dark:border-brand-800">
            <span class="w-2 h-2 rounded-full bg-brand-600 shadow-[0_0_8px_rgba(var(--brand-600),0.8)]"></span>
            <span class="text-[10px] font-bold text-brand-700 dark:text-brand-400 uppercase tracking-widest">{{ auth()->user()->role }} Mode</span>
        </div>
    </div>

    <!-- Navegación Instantánea (Alpine.js) -->
    <div class="flex items-center border-b border-gray-200 dark:border-gray-800 mb-8 overflow-x-auto no-scrollbar">
        @if(auth()->user()->hasPermission('manage_users'))
        <button @click="tab = 'users'" 
                :class="tab === 'users' ? 'text-brand-600 border-brand-600' : 'text-gray-400 border-transparent hover:text-gray-600'"
                class="group relative py-4 px-6 border-b-2 transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            <span class="text-xs font-bold uppercase tracking-widest">Usuarios</span>
        </button>
        @endif

        @if(auth()->user()->hasPermission('manage_categories'))
        <button @click="tab = 'categories'" 
                :class="tab === 'categories' ? 'text-brand-600 border-brand-600' : 'text-gray-400 border-transparent hover:text-gray-600'"
                class="group relative py-4 px-6 border-b-2 transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            <span class="text-xs font-bold uppercase tracking-widest">Categorías</span>
        </button>
        @endif

        @if(auth()->user()->hasPermission('manage_articles'))
        <button @click="tab = 'articles'" 
                :class="tab === 'articles' ? 'text-brand-600 border-brand-600' : 'text-gray-400 border-transparent hover:text-gray-600'"
                class="group relative py-4 px-6 border-b-2 transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2zM14 4v4h4"></path></svg>
            <span class="text-xs font-bold uppercase tracking-widest">Noticias</span>
        </button>
        @endif

        <button @click="tab = 'roles'" 
                :class="tab === 'roles' ? 'text-brand-600 border-brand-600' : 'text-gray-400 border-transparent hover:text-gray-600'"
                class="group relative py-4 px-6 border-b-2 transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            <span class="text-xs font-bold uppercase tracking-widest">Roles</span>
        </button>
    </div>

    <!-- Contenedores de Secciones (Permanece en el DOM para evitar lags) -->
    <div class="relative min-h-[500px]">
        
        @if(auth()->user()->hasPermission('manage_users'))
        <div x-cloak x-show="tab === 'users'" class="animate-in fade-in slide-in-from-bottom-2 duration-300">
            <livewire:admin.user-management wire:key="admin-users" />
        </div>
        @endif

        @if(auth()->user()->hasPermission('manage_categories'))
        <div x-cloak x-show="tab === 'categories'" class="animate-in fade-in slide-in-from-bottom-2 duration-300">
            <livewire:admin.category-management wire:key="admin-categories" />
        </div>
        @endif

        @if(auth()->user()->hasPermission('manage_articles'))
        <div x-cloak x-show="tab === 'articles'" class="animate-in fade-in slide-in-from-bottom-2 duration-300">
            <livewire:admin.article-management wire:key="admin-articles" />
        </div>
        @endif

        <!-- Sección de Roles e Información (Estática) -->
        <div x-cloak x-show="tab === 'roles'" class="animate-in fade-in slide-in-from-bottom-2 duration-300 bg-gray-50 dark:bg-gray-800/50 p-8 rounded-sm border border-gray-100 dark:border-gray-700">
            <div class="max-w-4xl mx-auto">
                <h3 class="text-xl font-serif font-bold text-gray-900 dark:text-white mb-8">Estructura de Permisos del Diario</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Admin -->
                    <div class="bg-white dark:bg-gray-900 p-6 rounded-sm shadow-sm border-t-4 border-black dark:border-white">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-4 h-4 rounded-full bg-black dark:bg-white"></div>
                            <h4 class="text-xs font-black uppercase tracking-widest text-900">Admin</h4>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed">Acceso total. Puede gestionar el personal y configurar el núcleo del sistema.</p>
                    </div>

                    <!-- Editor -->
                    <div class="bg-white dark:bg-gray-900 p-6 rounded-sm shadow-sm border-t-4 border-brand-600">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-4 h-4 rounded-full bg-brand-600"></div>
                            <h4 class="text-xs font-black uppercase tracking-widest text-brand-600">Editor</h4>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed">Gestiona contenido y secciones. No puede administrar otros usuarios.</p>
                    </div>

                    <!-- Lector -->
                    <div class="bg-white dark:bg-gray-900 p-6 rounded-sm shadow-sm border-t-4 border-gray-300">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-4 h-4 rounded-full bg-gray-300"></div>
                            <h4 class="text-xs font-black uppercase tracking-widest text-gray-400">Lector</h4>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed">Acceso a lectura y favoritos. Sin permisos administrativos.</p>
                    </div>
                </div>

                <div class="mt-12">
                    <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4">Referencia Técnica</h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left text-xs">
                            <thead class="bg-gray-100 dark:bg-gray-800 text-gray-500 font-bold uppercase text-[9px]">
                                <tr>
                                    <th class="px-4 py-3">Variable (Slug)</th>
                                    <th class="px-4 py-3">Descripción</th>
                                    <th class="px-4 py-3">Nivel sugerido</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-gray-600 dark:text-gray-400">
                                <tr>
                                    <td class="px-4 py-3 font-mono text-brand-600 italic">manage_users</td>
                                    <td class="px-4 py-3">Contratación y perfiles de equipo</td>
                                    <td class="px-4 py-3">Admin</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 font-mono text-brand-600 italic">manage_categories</td>
                                    <td class="px-4 py-3">Crear secciones como 'Deportes'</td>
                                    <td class="px-4 py-3">Editor / Admin</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 font-mono text-brand-600 italic">manage_articles</td>
                                    <td class="px-4 py-3">Publicar y borrar noticias</td>
                                    <td class="px-4 py-3">Editor / Admin</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
