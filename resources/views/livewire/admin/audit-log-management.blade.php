<div class="space-y-6">
    <!-- Header de Sección -->
    <div
        class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white dark:bg-gray-900 p-6 border border-gray-200 dark:border-gray-800 rounded-sm shadow-sm">
        <div>
            <h2 class="text-2xl font-serif font-bold text-gray-900 dark:text-white uppercase tracking-tight">Historial de
                Acciones</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Registro detallado de auditoría del sistema editorial.
            </p>
        </div>
        <div
            class="flex items-center gap-3 px-3 py-1.5 bg-gray-50 dark:bg-gray-800 rounded-sm border border-gray-100 dark:border-gray-700">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-[10px] font-black text-gray-600 dark:text-gray-400 uppercase tracking-widest">Logs en
                Tiempo Real</span>
        </div>
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
            <input wire:model.live.debounce.300ms="search" type="text"
                placeholder="Buscar por usuario, acción o descripción..."
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-700 rounded-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-brand-600 focus:border-brand-600 sm:text-sm transition-all text-xs">
        </div>
    </div>

    <!-- Tabla de Logs -->
    <div
        class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-sm shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                <thead class="bg-gray-50 dark:bg-gray-800/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                            Fecha / Hora</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                            Usuario</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                            Acción</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                            Descripción</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">IP
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-[11px] font-mono text-gray-600 dark:text-gray-400">
                                    {{ $log->created_at->format('d/m/Y H:i:s') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($log->user->name) }}&size=32"
                                        class="w-5 h-5 rounded-full">
                                    <div class="text-xs font-bold text-gray-900 dark:text-white">{{ $log->user->name }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 py-0.5 rounded-sm text-[9px] font-black uppercase tracking-tighter
                                    {{ $log->action === 'create' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $log->action === 'update' ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ $log->action === 'delete' ? 'bg-red-100 text-red-700' : '' }}
                                    {{ !in_array($log->action, ['create', 'update', 'delete']) ? 'bg-gray-100 text-gray-700' : '' }}">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs text-gray-600 dark:text-gray-300 max-w-md truncate">
                                    {{ $log->description }}</div>
                                <div class="text-[8px] text-gray-400 uppercase font-mono mt-0.5">
                                    {{ str_replace('App\\Models\\', '', $log->model_type) }} #{{ $log->model_id }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-[10px] font-mono text-gray-400">{{ $log->ip_address }}</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic text-sm">No se han
                                encontrado registros de actividad.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800">
            {{ $logs->links() }}
        </div>
    </div>
</div>
