<div class="bg-gray-50 dark:bg-gray-900 min-h-screen pb-12">
    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
            <div class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 p-4 rounded-md shadow-sm">
                <div class="flex">
                    <svg class="h-5 w-5 text-green-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm font-bold text-green-800 dark:text-green-200">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
            <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-4 rounded-md shadow-sm">
                <div class="flex">
                    <svg class="h-5 w-5 text-red-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm font-bold text-red-800 dark:text-red-200">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 border-b dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <!-- Job Info -->
                <div class="flex items-center gap-6">
                    @if ($vacancy->company->companyProfile && $vacancy->company->companyProfile->logo_path)
                        <img src="{{ Storage::url($vacancy->company->companyProfile->logo_path) }}"
                            class="w-20 h-20 rounded-xl object-cover border border-gray-200" alt="">
                    @else
                        <div
                            class="w-20 h-20 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-3xl font-bold text-gray-400">
                            {{ substr($vacancy->company->companyProfile->company_name ?? $vacancy->company->name, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $vacancy->title }}</h1>
                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 dark:text-gray-400 mt-2">
                            <span class="flex items-center gap-1 font-medium text-gray-900 dark:text-gray-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                {{ $vacancy->company->companyProfile->company_name ?? $vacancy->company->name }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                                {{ $vacancy->location ?? 'Remoto' }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $vacancy->salary_range ?? 'Salario a convenir' }}
                            </span>
                            <span
                                class="bg-blue-100 text-blue-800 text-xs px-2.5 py-0.5 rounded-full dark:bg-blue-900/30 dark:text-blue-300 font-bold uppercase tracking-wider">
                                {{ $vacancy->contract_type }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- CTA -->
                <div>
                    @if ($hasApplied)
                        <div
                            class="inline-flex items-center px-8 py-4 border border-transparent text-lg font-black rounded-2xl text-white bg-green-600 shadow-xl shadow-green-500/20">
                            <svg class="w-6 h-6 mr-2 animate-bounce" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            YA TE POSTULASTE
                        </div>
                    @else
                        <button wire:click="promptApply"
                            class="inline-flex items-center px-10 py-4 border border-transparent text-lg font-black rounded-2xl shadow-2xl text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-4 focus:ring-brand-500/50 transition-all transform hover:scale-105 active:scale-95">
                            POSTULARME AHORA
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-8">
                <h2 class="text-xl font-bold mb-6 text-gray-900 dark:text-white">Descripción del Puesto</h2>
                <div class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300">
                    {!! nl2br(e($vacancy->description)) !!}
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6">
                <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">Sobre la Empresa</h3>
                @if ($vacancy->company->companyProfile && $vacancy->company->companyProfile->description)
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                        {{ Str::limit($vacancy->company->companyProfile->description, 300) }}</p>
                @endif

                <div class="space-y-3 drop-shadow">
                    @if ($vacancy->company->companyProfile && $vacancy->company->companyProfile->website)
                        <a href="{{ $vacancy->company->companyProfile->website }}" target="_blank"
                            class="flex items-center text-sm font-bold text-brand-600 hover:underline">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            Visitar sitio web
                        </a>
                    @endif
                    <div class="flex items-center text-sm text-gray-500 font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        {{ $vacancy->company->companyProfile->industry ?? 'Industria no especificada' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Apply Modal -->
    @if ($showApplyModal)
        <div class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6" role="dialog" aria-modal="true">
            <!-- Overlay con desenfoque -->
            <div class="fixed inset-0 bg-gray-900/80 backdrop-blur-md transition-opacity"
                wire:click="$set('showApplyModal', false)"></div>

            <!-- Panel del Modal -->
            <div
                class="relative bg-white dark:bg-gray-800 rounded-[2.5rem] shadow-2xl w-full max-w-xl max-h-[95vh] flex flex-col overflow-hidden border border-gray-200 dark:border-gray-700 transform transition-all">

                <!-- Header -->
                <div
                    class="px-8 py-5 border-b dark:border-gray-700 flex items-center justify-between flex-shrink-0 bg-white dark:bg-gray-800 z-10">
                    <h3 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight">
                        Postulación
                    </h3>
                    <button wire:click="$set('showApplyModal', false)"
                        class="text-gray-400 hover:text-gray-600 transition-colors p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Scrollable Content -->
                <div class="px-8 py-8 overflow-y-auto flex-grow space-y-8">
                    <div>
                        <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-2 text-center">
                            Vacante Seleccionada</h4>
                        <p class="text-xl font-bold text-gray-900 dark:text-white text-center leading-tight">
                            {{ $vacancy->title }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-black text-gray-700 dark:text-gray-300 mb-4 text-center">
                            CARGAR HOJA DE VIDA (PDF) <span class="text-red-500 font-black">*</span>
                        </label>

                        <div x-data="{ isDropping: false, isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
                            x-on:livewire-upload-finish="isUploading = false"
                            x-on:livewire-upload-error="isUploading = false"
                            x-on:livewire-upload-progress="progress = $event.detail.progress"
                            @dragover.prevent="isDropping = true" @dragleave.prevent="isDropping = false"
                            @drop.prevent="isDropping = false; if ($event.dataTransfer.files.length > 0) { @this.upload('resume', $event.dataTransfer.files[0]) }"
                            :class="isDropping ?
                                'border-brand-500 bg-brand-50 dark:bg-brand-900/30 ring-4 ring-brand-500/20 scale-[1.02]' :
                                'border-gray-300 dark:border-gray-700'"
                            class="relative border-4 border-dashed rounded-3xl px-6 py-12 transition-all duration-300 group bg-gray-50/50 dark:bg-gray-900/20 overflow-hidden">

                            <input wire:model="resume" type="file" accept=".pdf"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">

                            <div class="text-center">
                                @if ($resume && !$errors->has('resume'))
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="h-24 w-24 bg-green-100 dark:bg-green-900/30 rounded-3xl flex items-center justify-center mb-6 shadow-xl shadow-green-500/10 rotate-3">
                                            <svg class="h-12 w-12 text-green-600 dark:text-green-400" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <p
                                            class="text-base font-black text-gray-900 dark:text-white mb-2 truncate max-w-full">
                                            {{ $resume instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile ? $resume->getClientOriginalName() : 'Documento listo' }}
                                        </p>
                                        <div
                                            class="inline-flex items-center px-4 py-2 rounded-xl bg-green-600 text-white text-xs font-black animate-pulse shadow-lg shadow-green-500/30">
                                            ¡LISTO! PRESIONA ENVIAR ABAJO
                                        </div>
                                    </div>
                                @else
                                    <div class="flex flex-col items-center space-y-6">
                                        <div
                                            class="h-24 w-24 bg-white dark:bg-gray-800 rounded-3xl flex items-center justify-center shadow-xl transition-all group-hover:scale-110 group-hover:rotate-6">
                                            <svg class="h-12 w-12 text-brand-500" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-lg font-black text-gray-900 dark:text-white">
                                                Arrastra tu PDF aquí
                                            </p>
                                            <p class="text-sm text-gray-500 mt-2 font-medium">O haz clic para
                                                seleccionar (Máx. 5MB)</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Progress Overlay -->
                            <div x-show="isUploading"
                                class="absolute inset-0 bg-white/98 dark:bg-gray-800/98 flex flex-col items-center justify-center z-20 rounded-3xl p-10 backdrop-blur-md">
                                <div
                                    class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-5 mb-6 shadow-inner overflow-hidden border-2 border-white dark:border-gray-600">
                                    <div class="bg-brand-600 h-full transition-all duration-300 ease-out shadow-lg"
                                        :style="`width: ${progress}%`"></div>
                                </div>
                                <p class="text-3xl font-black text-brand-600 mb-2" x-text="`${progress}%`"></p>
                                <p class="text-sm font-black text-gray-500 uppercase tracking-widest leading-none">
                                    Cargando Hoja de Vida...</p>
                            </div>
                        </div>
                        @error('resume')
                            <div
                                class="mt-4 flex items-center gap-3 text-sm text-red-600 font-bold bg-red-50 dark:bg-red-900/20 p-4 rounded-2xl border-2 border-red-100 dark:border-red-900/30">
                                <svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="space-y-3">
                        <label class="block text-sm font-black text-gray-700 dark:text-gray-300">
                            Carta de Presentación (Mensaje opcional)
                        </label>
                        <textarea wire:model="cover_letter" rows="5"
                            class="w-full rounded-3xl border-2 border-gray-100 dark:border-gray-700 dark:bg-gray-900/50 dark:text-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all resize-none shadow-inner p-5 text-sm font-medium"
                            placeholder="Escribe aquí un breve mensaje para la empresa..."></textarea>
                        @error('cover_letter')
                            <p class="text-sm text-red-500 font-bold ml-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Footer -->
                <div
                    class="px-8 py-6 bg-white dark:bg-gray-800 border-t dark:border-gray-700 flex flex-col sm:flex-row-reverse gap-4 flex-shrink-0">
                    <button wire:click="apply" type="button" {{ !$resume ? 'disabled' : '' }}
                        class="inline-flex justify-center items-center px-12 py-5 rounded-2xl text-lg font-black tracking-tighter text-white transition-all transform active:scale-95
                                {{ $resume
                                    ? 'bg-brand-600 hover:bg-brand-700 shadow-2xl shadow-brand-500/30 animate-pulse ring-4 ring-brand-500/20'
                                    : 'bg-gray-200 dark:bg-gray-700 cursor-not-allowed opacity-50 grayscale' }}"
                        wire:loading.attr="disabled" wire:target="apply">
                        <span wire:loading.remove wire:target="apply">ENVIAR MI POSTULACIÓN</span>
                        <span wire:loading wire:target="apply" class="flex items-center gap-3">
                            <svg class="animate-spin h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            PROCESANDO...
                        </span>
                    </button>
                    <button wire:click="$set('showApplyModal', false)" type="button"
                        class="inline-flex justify-center items-center px-8 py-5 rounded-2xl text-lg font-bold text-gray-500 dark:text-gray-400 bg-transparent hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all border-none">
                        CANCELAR
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
