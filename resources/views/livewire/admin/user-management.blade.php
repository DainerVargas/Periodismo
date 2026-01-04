<div class="space-y-6">
    <!-- Header de Sección -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white dark:bg-gray-900 p-6 border border-gray-200 dark:border-gray-800 rounded-sm shadow-sm">
        <div>
            <h2 class="text-2xl font-serif font-bold text-gray-900 dark:text-white">Gestión de Usuarios</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Controla los roles y permisos de los miembros del equipo.</p>
        </div>
        <button wire:click="openModal" class="inline-flex items-center gap-2 bg-black text-white font-bold text-xs px-6 py-3 cursor-pointer rounded-sm hover:opacity-90 transition-all uppercase tracking-widest shadow-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Nuevo Usuario
        </button>
    </div>

    <!-- Barra de Búsqueda -->
    <div class="flex items-center bg-gray-50 dark:bg-gray-800/50 p-4 rounded-sm border border-gray-200 dark:border-gray-800">
        <div class="relative flex-1 max-w-md">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </span>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Buscar por nombre o email..." class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-700 rounded-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-brand-600 focus:border-brand-600 sm:text-sm transition-all text-xs">
        </div>
    </div>

    <!-- Tabla de Usuarios -->
    <div class="overflow-hidden bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 rounded-sm">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Identidad</th>
                    <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Rol</th>
                    <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Permisos</th>
                    <th class="px-6 py-4 text-right text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                @foreach($users as $user)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors group">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <img class="h-8 w-8 rounded-full" src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}" alt="">
                            <div class="ml-4">
                                <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $user->name }}</div>
                                <div class="text-[10px] text-gray-500 font-medium tracking-tight">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2 py-0.5 text-[10px] font-bold rounded-sm uppercase tracking-wider {{ $user->role === 'admin' ? 'bg-black text-white dark:bg-white dark:text-black' : 'bg-gray-100 text-gray-600' }}">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-1">
                            @forelse($user->permissions ?? [] as $perm)
                                <span class="px-1 py-0.5 bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700 text-[8px] font-bold uppercase rounded-sm text-gray-500">
                                    {{ str_replace('manage_', '', $perm) }}
                                </span>
                            @empty
                                <span class="text-[9px] text-gray-400 uppercase italic">Ninguno</span>
                            @endforelse
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-bold">
                        <button wire:click="edit({{ $user->id }})" class="text-brand-600 hover:text-brand-900">EDITAR</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Modal User -->
    @if($showModal)
    <div class="fixed inset-0 z-[100] overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" wire:click="$set('showModal', false)"></div>
            
            <div class="relative bg-white dark:bg-gray-900 w-full max-w-2xl rounded-sm shadow-2xl border-t-4 border-brand-600 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center">
                    <h3 class="text-xl font-serif font-bold">{{ $userId ? 'Configurar Usuario' : 'Nuevo Miembro de Equipo' }}</h3>
                    <button @click="$wire.showModal = false" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>

                <div class="p-8 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Nombre Completo</label>
                            <input type="text" wire:model="name" class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-sm text-sm p-3 font-bold">
                            @error('name') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Email</label>
                            <input type="email" wire:model="email" class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-sm text-sm p-3">
                            @error('email') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    @if(!$userId)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Contraseña</label>
                            <input type="password" wire:model="password" class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-sm text-sm p-3">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Confirmar</label>
                            <input type="password" wire:model="password_confirmation" class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-sm text-sm p-3">
                        </div>
                    </div>
                    @endif

                    <div class="space-y-4">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">Cargo e Inmunidad</label>
                        <div class="flex gap-2">
                            @foreach(['user' => 'Lector', 'editor' => 'Editor', 'admin' => 'Admin'] as $val => $label)
                            <button wire:click="$set('role', '{{ $val }}')" class="flex-1 py-3 text-[10px] font-bold uppercase tracking-widest rounded-sm border transition-all {{ $role === $val ? 'bg-black text-white border-black dark:bg-white dark:text-black' : 'bg-white text-gray-400 border-gray-100 dark:bg-gray-800 dark:border-gray-700' }}">
                                {{ $label }}
                            </button>
                            @endforeach
                        </div>
                    </div>

                    @if($role !== 'admin')
                    <div class="pt-6 border-t border-gray-100 dark:border-gray-800">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Permisos de Gestión</label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                            @foreach($availablePermissions as $key => $label)
                            <button wire:click="togglePermission('{{ $key }}')" type="button" class="px-4 py-2 text-[10px] font-bold border rounded-sm transition-all uppercase tracking-tight {{ in_array($key, $permissions) ? 'bg-brand-50 text-brand-700 border-brand-200' : 'bg-gray-50 text-gray-400 border-gray-100 dark:bg-gray-800 dark:border-gray-700' }}">
                                {{ str_replace('Gestionar ', '', $label) }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <div class="px-8 py-6 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-800 flex justify-end gap-3">
                    <button @click="$wire.showModal = false" class="text-xs font-bold text-gray-400 px-4">Cancelar</button>
                    <button wire:click="save" class="bg-brand-600 text-white font-bold text-xs px-8 py-3 rounded-sm uppercase tracking-widest shadow-lg">
                        {{ $userId ? 'Autorizar' : 'Registrar' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
