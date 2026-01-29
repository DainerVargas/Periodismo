<div class="bg-[#f8fafc] dark:bg-gray-950 min-h-screen pb-20">
    <!-- Hero & Search Section -->
    <div class="relative bg-gray-900 dark:bg-gray-900 pt-32 pb-48 overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-[30%] -left-[10%] w-[70%] h-[70%] bg-brand-600/20 blur-[120px] rounded-full"></div>
            <div class="absolute -bottom-[30%] -right-[10%] w-[60%] h-[60%] bg-purple-600/10 blur-[100px] rounded-full">
            </div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="animate-in fade-in slide-in-from-top-4 duration-700">
                <span
                    class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-[0.2em] bg-brand-500/10 text-brand-400 border border-brand-500/20 mb-6">
                    Oportunidades Laborales
                </span>
                <h1 class="text-5xl md:text-7xl font-black text-white tracking-tight mb-6">
                    Encuentra tu próximo <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-400 to-purple-400">gran
                        desafío</span>
                </h1>
                <p class="max-w-2xl mx-auto text-lg text-gray-400 font-medium">
                    Explora vacantes exclusivas en el sector del periodismo, comunicación y tecnología.
                </p>
            </div>

            <!-- Search Bar Floating -->
            <div class="mt-12 max-w-4xl mx-auto animate-in fade-in slide-in-from-bottom-8 duration-1000 delay-300">
                <div
                    class="bg-white/5 dark:bg-white/5 backdrop-blur-2xl p-2 rounded-[2.5rem] border border-white/10 shadow-2xl">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-2">
                        <div class="md:col-span-12 lg:col-span-5 relative">
                            <input wire:model.live.debounce.300ms="search" type="text"
                                placeholder="Cargo, empresa o palabra clave..."
                                class="w-full h-16 pl-14 pr-4 bg-white dark:bg-gray-900 dark:text-white rounded-[2rem] border-0 focus:ring-4 focus:ring-brand-500/20 shadow-inner font-bold placeholder:text-gray-400 transition-all">
                            <div class="absolute left-5 top-1/2 -translate-y-1/2 text-brand-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>

                        <div class="md:col-span-6 lg:col-span-3">
                            <select wire:model.live="selectedCategory"
                                class="w-full h-16 px-6 bg-white dark:bg-gray-900 dark:text-white rounded-[2rem] border-0 focus:ring-4 focus:ring-brand-500/20 shadow-inner font-bold text-sm cursor-pointer transition-all">
                                <option value="">Todas las Categorías</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-6 lg:col-span-3">
                            <select wire:model.live="selectedLocation"
                                class="w-full h-16 px-6 bg-white dark:bg-gray-900 dark:text-white rounded-[2rem] border-0 focus:ring-4 focus:ring-brand-500/20 shadow-inner font-bold text-sm cursor-pointer transition-all">
                                <option value="">Ubicación</option>
                                @foreach ($locations as $loc)
                                    <option value="{{ $loc }}">{{ $loc }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="lg:col-span-1 flex items-center justify-center">
                            <div
                                class="h-12 w-12 bg-brand-600 rounded-full flex items-center justify-center text-white shadow-lg shadow-brand-500/40">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Filter Info -->
                <div
                    class="mt-4 flex items-center justify-center gap-6 text-[10px] font-black uppercase tracking-widest text-gray-500">
                    <span class="flex items-center gap-2">
                        <div class="h-1.5 w-1.5 rounded-full bg-brand-500"></div> {{ $vacancies->total() }} Ofertas
                        encontradas
                    </span>
                    @if ($search || $selectedCategory || $selectedLocation)
                        <button
                            wire:click="$set('search', ''); $set('selectedCategory', ''); $set('selectedLocation', '')"
                            class="text-red-400 hover:text-red-500 transition-colors">Limpiar Filtros</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Job Grid Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-24 relative z-10">
        @if (auth()->check() && auth()->user()->isCompany())
            <div class="mb-10 flex justify-center">
                <a href="{{ route('jobs.create') }}"
                    class="group inline-flex items-center px-8 py-4 bg-white dark:bg-gray-800 rounded-[2rem] shadow-2xl border border-gray-100 dark:border-gray-700 hover:border-brand-500/50 transition-all transform hover:-translate-y-1">
                    <div
                        class="h-10 w-10 bg-brand-600 rounded-2xl flex items-center justify-center text-white mr-4 shadow-lg shadow-brand-500/30 group-hover:rotate-90 transition-transform duration-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <span class="text-sm font-black uppercase tracking-widest text-gray-900 dark:text-white">Publicar
                        Nueva Vacante</span>
                </a>
            </div>
        @endif

        @if ($vacancies->count() > 0)
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($vacancies as $index => $vacancy)
                    <div class="animate-in fade-in slide-in-from-bottom-8 duration-700"
                        style="animation-delay: {{ $index * 100 }}ms">
                        <a href="{{ route('jobs.show', $vacancy->slug) }}"
                            class="group block h-full bg-white dark:bg-gray-900 rounded-[2.5rem] p-1 shadow-xl shadow-gray-200/50 dark:shadow-none border border-gray-50 dark:border-gray-800 hover:border-brand-500/30 transition-all duration-500 transform hover:-translate-y-2">

                            <div class="p-8 h-full flex flex-col">
                                <!-- Card Header -->
                                <div class="flex items-start justify-between mb-8">
                                    <div class="flex items-center gap-4">
                                        @if ($vacancy->company->companyProfile && $vacancy->company->companyProfile->logo_path)
                                            <div
                                                class="p-2 bg-gray-50 dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700">
                                                <img src="{{ Storage::url($vacancy->company->companyProfile->logo_path) }}"
                                                    class="w-12 h-12 rounded-xl object-cover" alt="">
                                            </div>
                                        @else
                                            <div
                                                class="w-14 h-14 rounded-2xl bg-gradient-to-br from-brand-600 to-brand-800 flex items-center justify-center text-2xl font-black text-white shadow-lg shadow-brand-500/20 rotate-3 group-hover:rotate-0 transition-transform">
                                                {{ substr($vacancy->company->companyProfile->company_name ?? $vacancy->company->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="flex items-center gap-2 mb-1">
                                                <span
                                                    class="px-2 py-0.5 rounded-lg text-[8px] font-black uppercase tracking-widest bg-yellow-400 text-yellow-900 shadow-sm">Destacada</span>
                                                <span
                                                    class="text-[10px] font-bold text-gray-400">{{ $vacancy->created_at->diffForHumans() }}</span>
                                            </div>
                                            <h3
                                                class="font-black text-xl text-gray-900 dark:text-white leading-tight group-hover:text-brand-600 transition-colors line-clamp-2">
                                                {{ $vacancy->title }}
                                            </h3>
                                        </div>
                                    </div>
                                </div>

                                <!-- Meta Info -->
                                <div class="space-y-4 mb-8">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="h-8 w-8 bg-blue-50 dark:bg-blue-900/20 rounded-xl flex items-center justify-center text-blue-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            </svg>
                                        </div>
                                        <span
                                            class="text-sm font-bold text-gray-600 dark:text-gray-400 truncate">{{ $vacancy->location ?? 'Remoto' }}</span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="h-8 w-8 bg-green-50 dark:bg-green-900/20 rounded-xl flex items-center justify-center text-green-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2" />
                                            </svg>
                                        </div>
                                        <span
                                            class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ $vacancy->salary_range ?? 'Sueldo a convenir' }}</span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="h-8 w-8 bg-orange-50 dark:bg-orange-900/20 rounded-xl flex items-center justify-center text-orange-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2.5"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        </div>
                                        <span
                                            class="text-sm font-bold text-gray-600 dark:text-gray-400 truncate">{{ $vacancy->company->companyProfile->company_name ?? $vacancy->company->name }}</span>
                                    </div>
                                </div>

                                <!-- Footer -->
                                <div
                                    class="mt-auto pt-6 border-t border-gray-50 dark:border-gray-800 flex items-center justify-between">
                                    <span
                                        class="px-3 py-1 bg-gray-100 dark:bg-gray-800 rounded-lg text-[10px] font-black uppercase tracking-widest text-gray-500">
                                        {{ $vacancy->contract_type }}
                                    </span>
                                    <div
                                        class="flex items-center text-brand-600 font-black text-xs uppercase tracking-widest group-hover:gap-3 gap-2 transition-all">
                                        Postularme
                                        <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="mt-20">
                {{ $vacancies->links() }}
            </div>
        @else
            <div
                class="text-center py-32 bg-white dark:bg-gray-900 rounded-[3rem] shadow-2xl border-4 border-dashed border-gray-100 dark:border-gray-800">
                <div
                    class="h-24 w-24 bg-gray-50 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner">
                    <svg class="h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Vaya, no hay
                    resultados</h3>
                <p class="mt-4 text-gray-500 dark:text-gray-400 max-w-sm mx-auto font-medium">No encontramos vacantes
                    que coincidan con tu búsqueda. Prueba con otros términos.</p>
                <button wire:click="$set('search', '')"
                    class="mt-10 inline-flex items-center px-8 py-4 bg-brand-600 hover:bg-brand-700 text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl shadow-xl shadow-brand-500/20 transition-all active:scale-95">
                    Reiniciar Búsqueda
                </button>
            </div>
        @endif
    </div>
</div>
