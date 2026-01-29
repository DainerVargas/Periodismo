<div>
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-10">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h1 class="text-4xl font-black text-gray-900 dark:text-white tracking-tight">Gestión de Empleo</h1>
                    <p class="mt-2 text-base text-gray-500 dark:text-gray-400 font-medium">Control panel para vacantes y
                        postulaciones en tiempo real.</p>
                </div>
                <a href="{{ route('jobs.create') }}"
                    class="inline-flex items-center px-6 py-4 border border-transparent rounded-2xl shadow-xl text-base font-black text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-4 focus:ring-brand-500/50 transition-all transform hover:scale-105 active:scale-95">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    NUEVA VACANTE
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-8 animate-in fade-in slide-in-from-top-4 duration-500">
                <div
                    class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 p-5 rounded-2xl shadow-sm flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-full p-1 mr-4">
                        <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <p class="text-sm font-bold text-green-800 dark:text-green-200 uppercase tracking-wide">
                        {{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Filters -->
        <div
            class="bg-white dark:bg-gray-800 shadow-2xl shadow-gray-200/50 dark:shadow-none rounded-[2rem] p-8 mb-10 border border-gray-100 dark:border-gray-700">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="lg:col-span-2">
                    <label
                        class="block text-xs font-black text-gray-400 dark:text-gray-500 mb-3 uppercase tracking-widest">Buscar
                        Vacante</label>
                    <div class="relative group">
                        <input type="text" wire:model.live.debounce.300ms="search"
                            placeholder="Título, ubicación o empresa..."
                            class="w-full h-14 pl-12 rounded-2xl border-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition-all">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 group-focus-within:text-brand-500 transition-colors"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
                <div class="lg:col-span-2">
                    <label
                        class="block text-xs font-black text-gray-400 dark:text-gray-500 mb-3 uppercase tracking-widest">Estado</label>
                    <div
                        class="flex p-1 bg-gray-50 dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-700 h-14">
                        <button wire:click="$set('statusFilter', 'all')"
                            class="flex-1 rounded-xl text-xs font-black uppercase tracking-widest transition-all {{ $statusFilter === 'all' ? 'bg-white dark:bg-gray-800 text-brand-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">Todas</button>
                        <button wire:click="$set('statusFilter', 'active')"
                            class="flex-1 rounded-xl text-xs font-black uppercase tracking-widest transition-all {{ $statusFilter === 'active' ? 'bg-white dark:bg-gray-800 text-green-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">Activas</button>
                        <button wire:click="$set('statusFilter', 'closed')"
                            class="flex-1 rounded-xl text-xs font-black uppercase tracking-widest transition-all {{ $statusFilter === 'closed' ? 'bg-white dark:bg-gray-800 text-yellow-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">Cerradas</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vacancies List -->
        <div class="space-y-6">
            @forelse ($vacancies as $vacancy)
                <div
                    class="group bg-white dark:bg-gray-800 rounded-[2.5rem] p-1 shadow-2xl shadow-gray-200/40 dark:shadow-none border border-gray-100 dark:border-gray-700 hover:border-brand-500/30 transition-all duration-500">
                    <div class="p-8">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8">
                            <div class="flex-1">
                                <div class="flex flex-wrap items-center gap-4 mb-4">
                                    <span
                                        class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-[0.2em] shadow-sm
                                        @if ($vacancy->status === 'active') bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400
                                        @elseif($vacancy->status === 'closed') bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400
                                        @else bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300 @endif">
                                        {{ $vacancy->status === 'active' ? 'Publicada' : 'Pausada' }}
                                    </span>
                                    @if (auth()->user()->role === 'admin')
                                        <div
                                            class="flex items-center text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                            <span class="mr-2">Empresa:</span>
                                            <span class="text-brand-600">{{ $vacancy->company->name }}</span>
                                        </div>
                                    @endif
                                </div>

                                <h3
                                    class="text-2xl font-black text-gray-900 dark:text-white group-hover:text-brand-600 transition-colors leading-tight mb-4">
                                    {{ $vacancy->title }}
                                </h3>

                                <div
                                    class="flex flex-wrap items-center gap-6 text-sm font-bold text-gray-500 dark:text-gray-400">
                                    <div
                                        class="flex items-center bg-gray-50 dark:bg-gray-700/50 px-3 py-1.5 rounded-xl border border-gray-100 dark:border-gray-600">
                                        <svg class="w-4 h-4 mr-2 text-brand-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        </svg>
                                        {{ $vacancy->location }}
                                    </div>
                                    <div
                                        class="flex items-center bg-gray-50 dark:bg-gray-700/50 px-3 py-1.5 rounded-xl border border-gray-100 dark:border-gray-600">
                                        <svg class="w-4 h-4 mr-2 text-orange-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        {{ $vacancy->applications->count() }} POSTULACIONES
                                    </div>
                                    <span class="text-xs font-medium italic opacity-60">Creada
                                        {{ $vacancy->created_at->format('d M, Y') }}</span>
                                </div>
                            </div>

                            <div
                                class="flex items-center gap-3 bg-gray-50 dark:bg-gray-900/50 p-4 rounded-[1.5rem] border border-gray-100 dark:border-gray-700 shadow-inner">
                                <button wire:click="showApplications({{ $vacancy->id }})"
                                    class="flex-1 lg:flex-none flex items-center justify-center gap-2 px-6 py-4 bg-brand-600 hover:bg-brand-700 text-white font-black text-xs uppercase tracking-widest rounded-2xl shadow-xl shadow-brand-500/20 transition-all transform hover:-translate-y-1 active:scale-95">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    CANDIDATOS
                                </button>

                                <div class="flex gap-2">
                                    <button wire:click="toggleStatus({{ $vacancy->id }})"
                                        class="p-4 bg-white dark:bg-gray-800 text-gray-400 hover:text-yellow-600 dark:hover:text-yellow-400 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm transition-all hover:shadow-lg"
                                        title="{{ $vacancy->status === 'active' ? 'Pausar' : 'Activar' }}">
                                        @if ($vacancy->status === 'active')
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2.5"
                                                    d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2.5"
                                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @endif
                                    </button>

                                    <button wire:click="deleteVacancy({{ $vacancy->id }})"
                                        wire:confirm="¿Estás completamente seguro de eliminar esta vacante? Esta acción es irreversible."
                                        class="p-4 bg-white dark:bg-gray-800 text-gray-400 hover:text-red-600 dark:hover:text-red-400 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm transition-all hover:shadow-lg"
                                        title="Eliminar permanentemente">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div
                    class="py-24 text-center bg-white dark:bg-gray-800 rounded-[3rem] shadow-xl border-4 border-dashed border-gray-100 dark:border-gray-700">
                    <div
                        class="h-24 w-24 bg-gray-50 dark:bg-gray-900 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="h-12 w-12 text-gray-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight">No se
                        encontraron vacantes</h3>
                    <p class="mt-2 text-gray-500 dark:text-gray-400 max-w-sm mx-auto font-medium">No hay registros que
                        coincidan con tus filtros. Prueba ajustando la búsqueda.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $vacancies->links() }}
        </div>
    </div>

    <!-- Applications Modal -->
    @if ($viewingApplications && $selectedVacancy)
        <div class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-8" role="dialog"
            aria-modal="true">
            <div class="fixed inset-0 bg-gray-950/80 backdrop-blur-xl" wire:click="closeApplications"></div>

            <div
                class="relative bg-white dark:bg-gray-900 rounded-[3rem] shadow-2xl w-full max-w-5xl max-h-[90vh] flex flex-col overflow-hidden border border-white/20 transform transition-all">
                <!-- Modal Header -->
                <div
                    class="px-10 py-8 border-b dark:border-gray-800 flex items-center justify-between bg-white dark:bg-gray-900 z-10 flex-shrink-0">
                    <div>
                        <h2 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight uppercase">
                            Candidatos Postulados</h2>
                        <p class="text-brand-600 font-bold text-sm mt-1 uppercase tracking-widest">
                            {{ $selectedVacancy->title }}</p>
                    </div>
                    <button wire:click="closeApplications"
                        class="p-3 rounded-2xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors text-gray-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Content -->
                <div class="flex-grow overflow-y-auto p-10 space-y-8">
                    @forelse ($selectedVacancy->applications as $application)
                        <div
                            class="bg-gray-50 dark:bg-gray-800/50 rounded-[2.5rem] p-8 border border-gray-100 dark:border-gray-700 shadow-sm transition-all hover:shadow-xl hover:border-brand-500/20 group">
                            <div class="flex flex-col lg:flex-row gap-8">
                                <!-- User Column -->
                                <div class="lg:w-1/3 space-y-6">
                                    <div class="flex items-center gap-5">
                                        @if ($application->user->avatar)
                                            <img src="{{ Storage::url($application->user->avatar) }}"
                                                class="h-20 w-20 rounded-3xl object-cover shadow-lg border-2 border-white dark:border-gray-700"
                                                alt="">
                                        @else
                                            <div
                                                class="h-20 w-20 rounded-3xl bg-brand-600 flex items-center justify-center text-3xl font-black text-white shadow-xl rotate-3">
                                                {{ substr($application->user->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <h4
                                                class="text-xl font-black text-gray-900 dark:text-white leading-tight uppercase tracking-tight">
                                                {{ $application->user->name }}</h4>
                                            <p class="text-sm font-bold text-brand-600 break-all">
                                                {{ $application->user->email }}</p>
                                        </div>
                                    </div>

                                    @if ($application->user->bio)
                                        <div
                                            class="bg-white dark:bg-gray-900 p-5 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-inner">
                                            <h5
                                                class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">
                                                Sobre el candidato</h5>
                                            <p
                                                class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed italic line-clamp-4">
                                                "{{ $application->user->bio }}"</p>
                                        </div>
                                    @endif

                                    <div class="flex flex-wrap gap-2 text-gray-400">
                                        @if ($application->user->twitter)
                                            <a href="{{ $application->user->twitter }}" target="_blank"
                                                class="p-2 bg-white dark:bg-gray-900 rounded-xl hover:text-blue-400 transition-colors border border-gray-100 dark:border-gray-700">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                                                </svg>
                                            </a>
                                        @endif
                                        @if ($application->user->facebook)
                                            <a href="{{ $application->user->facebook }}" target="_blank"
                                                class="p-2 bg-white dark:bg-gray-900 rounded-xl hover:text-blue-600 transition-colors border border-gray-100 dark:border-gray-700">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.324v-21.35c0-.732-.593-1.325-1.325-1.325z" />
                                                </svg>
                                            </a>
                                        @endif
                                        @if ($application->user->instagram)
                                            <a href="{{ $application->user->instagram }}" target="_blank"
                                                class="p-2 bg-white dark:bg-gray-900 rounded-xl hover:text-pink-500 transition-colors border border-gray-100 dark:border-gray-700">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 1.166.054 1.8.249 2.223.413.562.217.96.477 1.382.899.422.422.682.821.899 1.382.164.423.359 1.057.413 2.223.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.054 1.166-.249 1.8-.413 2.223-.217.562-.477.96-.899 1.382-.422.422-.821.682-1.382.899-.423.164-1.057.359-2.223.413-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.166-.054-1.8-.249-2.223-.413-.562-.217-.96-.477-1.382-.899-.422-.422-.682-.821-.899-1.382-.164-.423-.359-1.057-.413-2.223-.058-1.266-.07-1.646-.07-4.85s.012-3.584.07-4.85c.054-1.166.249-1.8.413-2.223.217-.562.477-.96.899-1.382.422-.422.821-.682 1.382-.899.423-.164 1.057-.359 2.223-.413 1.266-.058 1.646-.07 4.85-.07zm0-2.163c-3.259 0-3.667.014-4.947.072-1.277.057-2.148.258-2.911.556-.788.306-1.458.715-2.125 1.383-.667.667-1.077 1.337-1.383 2.125-.298.763-.499 1.634-.556 2.911-.059 1.28-.073 1.688-.073 4.947s.014 3.667.072 4.947c.057 1.277.258 2.148.556 2.911.306.788.715 1.458 1.383 2.125.667.667 1.337 1.077 2.125 1.383.763.298 1.634.499 2.911.556 1.28.059 1.688.073 4.947.073s3.667-.014 4.947-.072c1.277-.057 2.148-.258 2.911-.556.788-.306 1.458-.715 2.125-1.383.667-.667 1.077-1.337 1.383-2.125.298-.763.499-1.634.556-2.911.059-1.28.073-1.688.073-4.947s-.014-3.667-.072-4.947c-.057-1.277-.258-2.148-.556-2.911-.306-.788-.715-1.458-1.383-2.125-.667-.667-1.337-1.077-2.125-1.383-.763-.298-1.634-.499-2.911-.556-1.28-.059-1.688-.073-4.947-.073z" />
                                                    <path
                                                        d="M12 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.162 6.162 6.162 6.162-2.759 6.162-6.162-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.791-4-4s1.791-4 4-4 4 1.791 4 4-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.441s.645 1.441 1.441 1.441 1.441-.645 1.441-1.441-.645-1.441-1.441-1.441z" />
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                <!-- Message Column -->
                                <div class="flex-1 space-y-6">
                                    <div class="h-full flex flex-col justify-between">
                                        <div>
                                            <div class="flex items-center gap-3 mb-4">
                                                <h5
                                                    class="text-xs font-black text-gray-400 uppercase tracking-[0.2em]">
                                                    Carta de Presentación</h5>
                                                <div class="h-px flex-grow bg-gray-100 dark:bg-gray-700"></div>
                                            </div>
                                            @if ($application->cover_letter)
                                                <div
                                                    class="prose dark:prose-invert max-w-none text-sm font-medium text-gray-600 dark:text-gray-300 leading-relaxed bg-brand-50/30 dark:bg-brand-900/10 p-6 rounded-3xl border border-brand-50 dark:border-brand-500/10">
                                                    {{ $application->cover_letter }}
                                                </div>
                                            @else
                                                <div
                                                    class="p-6 rounded-3xl border border-dashed border-gray-200 dark:border-gray-700 text-center">
                                                    <p class="text-xs font-bold text-gray-400">No se incluyó mensaje
                                                        adicional.</p>
                                                </div>
                                            @endif
                                        </div>

                                        <div
                                            class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-6 pt-6 border-t dark:border-gray-700">
                                            <span
                                                class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Postulado
                                                el {{ $application->created_at->format('d/m/Y - H:i') }}</span>

                                            <div class="flex items-center gap-3 w-full sm:w-auto">
                                                <a href="{{ Storage::url($application->resume_path) }}"
                                                    target="_blank"
                                                    class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-3.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-900 dark:text-white text-xs font-black uppercase tracking-widest rounded-2xl transition-all active:scale-95 border-b-4 border-gray-300 dark:border-gray-800">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2.5"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    Visualizar
                                                </a>

                                                <a href="{{ Storage::url($application->resume_path) }}"
                                                    download="{{ Str::slug($application->user->name) }}_CV.pdf"
                                                    class="flex-1 sm:flex-none inline-flex items-center justify-center px-8 py-3.5 bg-brand-600 hover:bg-brand-700 text-white text-xs font-black uppercase tracking-widest rounded-2xl shadow-lg shadow-brand-500/20 transition-all transform hover:-translate-y-1 active:scale-95 border-b-4 border-brand-800">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2.5"
                                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                    </svg>
                                                    Descargar CV
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="py-20 text-center">
                            <div
                                class="h-20 w-20 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="h-10 w-10 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <p class="text-xl font-bold text-gray-400">Aún no hay postulaciones para esta vacante.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Footer -->
                <div
                    class="px-10 py-6 bg-gray-50 dark:bg-gray-800/80 border-t dark:border-gray-800 flex justify-end flex-shrink-0">
                    <button wire:click="closeApplications"
                        class="px-10 py-4 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-black text-xs uppercase tracking-widest rounded-2xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-all shadow-sm">
                        Cerrar Panel
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
