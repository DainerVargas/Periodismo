<div class="bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 rounded-sm">
    <form wire:submit.prevent="save" class="divide-y divide-gray-200 dark:divide-gray-800">
        <div class="px-6 py-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white uppercase tracking-tight">Perfil de Empresa</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Completa esta información para poder publicar
                vacantes de empleo.</p>
        </div>

        <div class="px-6 py-6 space-y-8">
            <!-- Logo Section -->
            <div class="flex items-center gap-6">
                <div class="relative group">
                    <div
                        class="h-24 w-24 rounded-2xl overflow-hidden bg-gray-50 dark:bg-gray-800 border-2 border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-center">
                        @if ($logo)
                            <img src="{{ $logo->temporaryUrl() }}" class="h-full w-full object-cover">
                        @elseif ($existing_logo)
                            <img src="{{ Storage::url($existing_logo) }}" class="h-full w-full object-cover">
                        @else
                            <svg class="h-10 w-10 text-gray-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4a1 1 0 011-1h2a1 1 0 011 1v3M12 7h1m-1 4h1m-5 10H3a2 2 0 01-2-2V7a2 2 0 012-2h2m4 0h6a2 2 0 012 2v10a2 2 0 01-2 2h-3">
                                </path>
                            </svg>
                        @endif

                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center cursor-pointer"
                            onclick="document.getElementById('company-logo').click()">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <input type="file" id="company-logo" wire:model="logo" class="hidden" accept="image/*">
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 dark:text-white uppercase text-xs tracking-widest">Logo de la
                        Empresa</h3>
                    <p class="text-[10px] text-gray-500 mt-1">PNG, JPG o GIF. Máximo 1MB.</p>
                    @error('logo')
                        <span class="text-xs text-red-600 font-bold block mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Basic Info Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-1">
                    <label
                        class="block text-xs font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">Nombre
                        Legal de la Empresa</label>
                    <input type="text" wire:model="company_name"
                        class="w-full rounded-sm border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-brand-500 focus:ring-brand-500 shadow-sm text-sm p-3">
                    @error('company_name')
                        <span class="text-xs text-red-600 font-bold block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-1">
                    <label
                        class="block text-xs font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">Ubicación
                        / Ciudad</label>
                    <input type="text" wire:model="location" placeholder="Ej: Madrid, España"
                        class="w-full rounded-sm border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-brand-500 focus:ring-brand-500 shadow-sm text-sm p-3">
                    @error('location')
                        <span class="text-xs text-red-600 font-bold block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-1">
                    <label
                        class="block text-xs font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">Sitio
                        Web (Opcional)</label>
                    <input type="url" wire:model="website" placeholder="https://miweb.com"
                        class="w-full rounded-sm border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-brand-500 focus:ring-brand-500 shadow-sm text-sm p-3">
                    @error('website')
                        <span class="text-xs text-red-600 font-bold block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-1">
                    <label
                        class="block text-xs font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">Industria</label>
                    <input type="text" wire:model="industry" placeholder="Ej: Tecnología, Salud, etc."
                        class="w-full rounded-sm border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-brand-500 focus:ring-brand-500 shadow-sm text-sm p-3">
                </div>

                <div class="col-span-2">
                    <label
                        class="block text-xs font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">Descripción
                        de la Empresa</label>
                    <textarea wire:model="description" rows="4"
                        class="w-full rounded-sm border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-brand-500 focus:ring-brand-500 shadow-sm text-sm p-3"></textarea>
                    @error('description')
                        <span class="text-xs text-red-600 font-bold block mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 flex justify-end">
            <button type="submit" wire:loading.attr="disabled"
                class="bg-brand-600 text-white font-black uppercase text-xs px-8 py-3 rounded-sm hover:bg-brand-700 shadow-lg shadow-brand-500/20 transition-all active:scale-95 disabled:opacity-50">
                <span wire:loading.remove>Guardar Perfil de Empresa</span>
                <span wire:loading>Guardando...</span>
            </button>
        </div>
    </form>

    @if (session('status') === 'profile-updated')
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            class="fixed bottom-4 right-4 bg-green-900 text-white px-4 py-3 rounded-md shadow-lg flex items-center gap-2 animate-enter z-50">
            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span class="font-medium text-sm">Perfil de empresa actualizado correctamente</span>
        </div>
    @endif
</div>
