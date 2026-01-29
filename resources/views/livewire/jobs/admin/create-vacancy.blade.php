<div class="bg-gray-50 dark:bg-gray-900 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Crear Nueva Vacante</h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Publica una nueva oferta de empleo para tu
                        empresa</p>
                </div>
                <a href="{{ route('jobs.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
            <form wire:submit.prevent="save" class="p-6 space-y-6">

                <!-- Título -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Título de la Vacante <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="title" id="title"
                        class="mt-1 block w-full rounded-md border-gray-300 p-4 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm"
                        placeholder="Ej: Desarrollador Full Stack">
                    @error('title')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Categoría y Ubicación -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="job_category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Categoría <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="job_category_id" id="job_category_id"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white p-4 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                            <option value="">Selecciona una categoría</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('job_category_id')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Ubicación <span class="text-red-500">*</span>
                        </label>
                        <input type="text" wire:model="location" id="location"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white p-4 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm"
                            placeholder="Ej: Bogotá, Colombia o Remoto">
                        @error('location')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Descripción -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Descripción del Puesto <span class="text-red-500">*</span>
                    </label>
                    <textarea wire:model="description" id="description" rows="8"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white p-4 shadow-sm focus:border-brand-500  focus:ring-brand-500 sm:text-sm"
                        placeholder="Describe las responsabilidades, requisitos y beneficios del puesto..."></textarea>
                    @error('description')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Tipo de Contrato y Horario -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="contract_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Tipo de Contrato <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="contract_type" id="contract_type"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white p-4 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                            <option value="Indefinido">Indefinido</option>
                            <option value="Temporal">Temporal</option>
                            <option value="Prestación de Servicios">Prestación de Servicios</option>
                            <option value="Remoto">Remoto</option>
                            <option value="Freelance">Freelance</option>
                        </select>
                        @error('contract_type')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="schedule" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Horario <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="schedule" id="schedule"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white p-4 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                            <option value="Tiempo Completo">Tiempo Completo</option>
                            <option value="Medio Tiempo">Medio Tiempo</option>
                            <option value="Por Horas">Por Horas</option>
                            <option value="Flexible">Flexible</option>
                        </select>
                        @error('schedule')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Salario y Fecha de Expiración -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="salary_range" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Rango Salarial
                        </label>
                        <input type="text" wire:model="salary_range" id="salary_range"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white p-4 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm"
                            placeholder="Ej: $3.000.000 - $5.000.000">
                        @error('salary_range')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="expires_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Fecha de Expiración
                        </label>
                        <input type="date" wire:model="expires_at" id="expires_at"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white p-4 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                        @error('expires_at')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Estado -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Estado <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="status" id="status"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white p-4 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                        <option value="active">Activa</option>
                        <option value="inactive">Inactiva</option>
                        <option value="closed">Cerrada</option>
                    </select>
                    @error('status')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Botones -->
                <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('jobs.index') }}"
                        class="px-6 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-brand-600 cursor-pointer hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="save">Publicar Vacante</span>
                        <span wire:loading wire:target="save">Publicando...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
