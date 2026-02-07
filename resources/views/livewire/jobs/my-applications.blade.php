<div class="space-y-6">
    <div class="bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 rounded-sm p-6">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Mis Postulaciones</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">Aquí puedes ver el historial de las vacantes a las que te has
            postulado.</p>
    </div>

    @if (session()->has('success'))
        <div
            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-sm relative text-xs font-bold uppercase tracking-widest">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6">
        @forelse ($applications as $application)
            <div
                class="group bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-sm shadow-sm hover:shadow-md transition-all overflow-hidden relative">
                <div class="absolute top-0 left-0 w-1 h-full bg-brand-600"></div>

                <div class="p-6">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div class="flex items-center gap-4">
                            @if ($application->vacancy->company->companyProfile && $application->vacancy->company->companyProfile->logo_path)
                                <img src="{{ Storage::url($application->vacancy->company->companyProfile->logo_path) }}"
                                    class="w-12 h-12 rounded-lg object-cover bg-gray-50" alt="">
                            @else
                                <div
                                    class="w-12 h-12 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-xl font-black text-brand-600">
                                    {{ substr($application->vacancy->company->companyProfile->company_name ?? $application->vacancy->company->name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <h3 class="font-bold text-lg text-gray-900 dark:text-white leading-tight">
                                    <a href="{{ route('jobs.show', $application->vacancy->slug) }}">
                                        {{ $application->vacancy->title }}
                                    </a>
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $application->vacancy->company->companyProfile->company_name ?? $application->vacancy->company->name }}
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-col items-end gap-2">
                            <span
                                class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                                @if ($application->status === 'pending') bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400
                                @elseif($application->status === 'reviewed') bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400
                                @elseif($application->status === 'accepted') bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400
                                @else bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 @endif">
                                {{ $application->status === 'pending' ? 'Pendiente' : ($application->status === 'reviewed' ? 'Revisada' : ($application->status === 'accepted' ? 'Aceptada' : 'No seleccionado')) }}
                            </span>
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">
                                Postulado {{ $application->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>

                    <div
                        class="mt-6 flex flex-wrap gap-4 items-center justify-between border-t border-gray-50 dark:border-gray-800 pt-6">
                        <div class="flex gap-4">
                            @if ($application->resume_path)
                                <a href="{{ Storage::url($application->resume_path) }}" target="_blank"
                                    class="text-[10px] font-black text-brand-600 uppercase tracking-widest hover:underline flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Ver CV enviado
                                </a>
                            @endif
                        </div>

                        <button wire:click="deleteApplication({{ $application->id }})"
                            wire:confirm="¿Estás seguro de que deseas retirar tu postulación? Esta acción no se puede deshacer."
                            class="text-[10px] font-black text-red-400 hover:text-red-600 uppercase tracking-widest flex items-center gap-1 transition-colors">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Retirar postulación
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div
                class="text-center py-20 bg-white dark:bg-gray-900 rounded-sm border-2 border-dashed border-gray-200 dark:border-gray-800">
                <div
                    class="h-16 w-16 bg-gray-50 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-widest">No tienes
                    postulaciones</h3>
                <p class="mt-2 text-xs text-gray-500 mb-6 font-medium">Aún no te has postulado a ninguna vacante
                    laboral.</p>
                <a href="{{ route('jobs.index') }}"
                    class="inline-flex items-center px-6 py-3 bg-brand-600 text-white text-[10px] font-black uppercase tracking-widest rounded-sm hover:bg-brand-700 transition-all shadow-lg shadow-brand-500/20">
                    Buscar Empleos
                </a>
            </div>
        @endforelse
    </div>
</div>
