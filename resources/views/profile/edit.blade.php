@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-2 sm:px-6 lg:px-8" x-data="{ activeTab: new URLSearchParams(window.location.search).get('tab') || 'profile', mobileMenuOpen: false }">

        <div class="mb-8 animate-enter">
            <h1 class="font-serif text-3xl font-bold text-ink dark:text-white">Mi Cuenta</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Gestiona tu información personal, seguridad y suscripción.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 relative">

            <!-- Botón Hamburguesa Móvil -->
            <div class="lg:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="w-full flex items-center justify-between px-4 py-3 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-sm shadow-sm hover:border-brand-500 transition-colors group">
                    <div class="flex items-center gap-3">
                        <div class="flex flex-col gap-1 w-5">
                            <span class="h-0.5 w-full bg-brand-600 transition-all duration-300"
                                :class="mobileMenuOpen ? 'rotate-45 translate-y-1.5' : ''"></span>
                            <span class="h-0.5 w-full bg-brand-600 transition-all duration-300"
                                :class="mobileMenuOpen ? 'opacity-0' : ''"></span>
                            <span class="h-0.5 w-full bg-brand-600 transition-all duration-300"
                                :class="mobileMenuOpen ? '-rotate-45 -translate-y-1.5' : ''"></span>
                        </div>
                        <span class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-widest">Navegar
                            Secciones</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] text-gray-400 font-bold uppercase"
                            x-text="activeTab === 'profile' ? 'Perfil' : (activeTab === 'security' ? 'Seguridad' : (activeTab === 'subscription' ? 'Suscripción' : (activeTab === 'applications' ? 'Postulaciones' : (activeTab === 'jobs' ? 'Empleo' : 'Admin'))))"></span>
                        <svg class="h-4 w-4 text-gray-400 transition-transform duration-300"
                            :class="{ 'rotate-180': mobileMenuOpen }" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </button>
            </div>

            <!-- Sidebar Menú -->
            <div class="lg:col-span-3 transition-all duration-300 overflow-hidden lg:overflow-visible"
                :class="mobileMenuOpen ? 'max-h-[1000px] opacity-100 mt-2' :
                    'max-h-0 opacity-0 lg:max-h-none lg:opacity-100 lg:mt-0 lg:block hidden'">
                <div class="mb-6 hidden lg:block">
                    <a href="/"
                        class="group flex items-center px-3 py-2 text-xs font-black uppercase tracking-widest text-gray-500 hover:text-brand-600 transition-all">
                        <svg class="mr-2 h-4 w-4 transform group-hover:-translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Volver al Inicio
                    </a>
                </div>
                <nav class="space-y-1">
                    <button
                        @click.prevent="activeTab = 'profile'; window.history.replaceState({}, '', '?tab=profile'); mobileMenuOpen = false"
                        :class="{ 'bg-gray-100 border-brand-600 text-brand-600 dark:bg-gray-800 dark:text-white': activeTab === 'profile', 'text-gray-900 border-transparent hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-800': activeTab !== 'profile' }"
                        class="w-full group flex items-center px-3 py-2 text-sm font-bold rounded-sm border-l-4 transition-colors">
                        <svg class="mr-3 h-5 w-5 flex-shrink-0"
                            :class="{ 'text-brand-600 dark:text-white': activeTab === 'profile', 'text-gray-400': activeTab !== 'profile' }"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Perfil Público
                    </button>

                    <button
                        @click.prevent="activeTab = 'security'; window.history.replaceState({}, '', '?tab=security'); mobileMenuOpen = false"
                        :class="{ 'bg-gray-100 border-brand-600 text-brand-600 dark:bg-gray-800 dark:text-white': activeTab === 'security', 'text-gray-900 border-transparent hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-800': activeTab !== 'security' }"
                        class="w-full group flex items-center px-3 py-2 text-sm font-medium rounded-sm border-l-4 transition-colors">
                        <svg class="mr-3 h-5 w-5 flex-shrink-0"
                            :class="{ 'text-brand-600 dark:text-white': activeTab === 'security', 'text-gray-400': activeTab !== 'security' }"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                        Seguridad
                    </button>

                    <button
                        @click.prevent="activeTab = 'subscription'; window.history.replaceState({}, '', '?tab=subscription'); mobileMenuOpen = false"
                        :class="{ 'bg-gray-100 border-brand-600 text-brand-600 dark:bg-gray-800 dark:text-white': activeTab === 'subscription', 'text-gray-900 border-transparent hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-800': activeTab !== 'subscription' }"
                        class="w-full group flex items-center px-3 py-2 text-sm font-medium rounded-sm border-l-4 transition-colors">
                        <svg class="mr-3 h-5 w-5 flex-shrink-0"
                            :class="{ 'text-brand-600 dark:text-white': activeTab === 'subscription', 'text-gray-400': activeTab !== 'subscription' }"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                            </path>
                        </svg>
                        Suscripción
                    </button>

                    <button
                        @click.prevent="activeTab = 'applications'; window.history.replaceState({}, '', '?tab=applications'); mobileMenuOpen = false"
                        :class="{ 'bg-gray-100 border-brand-600 text-brand-600 dark:bg-gray-800 dark:text-white': activeTab === 'applications', 'text-gray-900 border-transparent hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-800': activeTab !== 'applications' }"
                        class="w-full group flex items-center px-3 py-2 text-sm font-medium rounded-sm border-l-4 transition-colors">
                        <svg class="mr-3 h-5 w-5 flex-shrink-0"
                            :class="{ 'text-brand-600 dark:text-white': activeTab === 'applications', 'text-gray-400': activeTab !== 'applications' }"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01m-.01 4h.01" />
                        </svg>
                        Mis Postulaciones
                    </button>

                    @if (auth()->user()->isCompany())
                        <button
                            @click.prevent="activeTab = 'company'; window.history.replaceState({}, '', '?tab=company'); mobileMenuOpen = false"
                            :class="{ 'bg-gray-100 border-brand-600 text-brand-600 dark:bg-gray-800 dark:text-white': activeTab === 'company', 'text-gray-900 border-transparent hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-800': activeTab !== 'company' }"
                            class="w-full group flex items-center px-3 py-2 text-sm font-bold rounded-sm border-l-4 transition-colors">
                            <svg class="mr-3 h-5 w-5 flex-shrink-0"
                                :class="{ 'text-brand-600 dark:text-white': activeTab === 'company', 'text-gray-400': activeTab !== 'company' }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4a1 1 0 011-1h2a1 1 0 011 1v3M12 7h1m-1 4h1m-5 10H3a2 2 0 01-2-2V7a2 2 0 012-2h2m4 0h6a2 2 0 012 2v10a2 2 0 01-2 2h-3" />
                            </svg>
                            Perfil de Empresa
                        </button>

                        <button
                            @click.prevent="activeTab = 'jobs'; window.history.replaceState({}, '', '?tab=jobs'); mobileMenuOpen = false"
                            :class="{ 'bg-gray-100 border-brand-600 text-brand-600 dark:bg-gray-800 dark:text-white': activeTab === 'jobs', 'text-gray-900 border-transparent hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-800': activeTab !== 'jobs' }"
                            class="w-full group flex items-center px-3 py-2 text-sm font-bold rounded-sm border-l-4 transition-colors">
                            <svg class="mr-3 h-5 w-5 flex-shrink-0"
                                :class="{ 'text-brand-600 dark:text-white': activeTab === 'jobs', 'text-gray-400': activeTab !== 'jobs' }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Gestión de Empleo
                        </button>
                    @endif

                    @if (auth()->user()->role === 'admin' || !empty(auth()->user()->permissions))
                        <button @click.prevent="activeTab = 'admin'; mobileMenuOpen = false"
                            :class="{ 'bg-brand-600 text-white border-brand-800': activeTab === 'admin', 'text-gray-900 border-transparent hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-800': activeTab !== 'admin' }"
                            class="w-full group flex items-center px-3 py-2 text-sm font-bold rounded-sm border-l-4 transition-colors mt-6">
                            <svg class="mr-3 h-5 w-5 flex-shrink-0"
                                :class="{ 'text-white': activeTab === 'admin', 'text-gray-400': activeTab !== 'admin' }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Administración
                        </button>
                        @if (auth()->user()->role === 'admin')
                            <div class="pl-8 pt-1">
                                <a href="#" @click.prevent="activeTab = 'audit_log'; mobileMenuOpen = false"
                                    class="text-[10px] font-bold uppercase tracking-widest transition-colors"
                                    :class="activeTab === 'audit_log' ? 'text-brand-600' :
                                        'text-gray-400 hover:text-gray-600 dark:hover:text-gray-200'">
                                    Historial de Acciones
                                </a>
                            </div>
                        @endif
                    @endif


                </nav>
            </div>

            <!-- Contenido Central -->
            <div class="lg:col-span-9 space-y-6">

                <!-- TAB 1: PERFIL PÚBLICO -->
                <div x-show="activeTab === 'profile'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0"
                    class="bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 rounded-sm">

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"
                        class="divide-y divide-gray-200 dark:divide-gray-800">
                        @csrf
                        @method('PATCH')

                        <div class="px-6 py-6">
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Información Básica</h2>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Esta información será pública en tu
                                perfil de autor o comentarista.</p>
                        </div>

                        <div class="px-6 py-6 space-y-8">

                            <div x-data="{ photoName: null, photoPreview: null }" class="flex items-center gap-6">
                                <input type="file" name="avatar" id="avatar" class="hidden" x-ref="photo"
                                    x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                                ">

                                <div class="relative group cursor-pointer" x-on:click.prevent="$refs.photo.click()">
                                    <div
                                        class="h-24 w-24 rounded-full overflow-hidden bg-gray-100 ring-4 ring-white dark:ring-gray-800 shadow-sm relative">
                                        <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random' }}"
                                            alt="Avatar"
                                            class="h-full w-full object-cover transition-opacity duration-300"
                                            x-show="! photoPreview">
                                        <img x-bind:src="photoPreview" class="h-full w-full object-cover"
                                            x-show="photoPreview" style="display: none;">
                                        <div
                                            class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div
                                        class="absolute bottom-0 right-0 bg-white dark:bg-gray-700 p-1.5 rounded-full shadow-md border border-gray-200 dark:border-gray-600 transition-transform group-hover:scale-110">
                                        <svg class="w-4 h-4 text-gray-600 dark:text-gray-300" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>

                                <div>
                                    <h3 class="font-medium text-gray-900 dark:text-white">Tu foto</h3>
                                    <p class="text-xs text-gray-500 mt-1">Soporta JPG, PNG, GIF. (Max 2MB)</p>
                                    <button type="button"
                                        class="mt-2 text-xs font-bold text-brand-600 hover:text-brand-500"
                                        x-on:click.prevent="$refs.photo.click()">
                                        Cambiar imagen
                                    </button>
                                </div>
                            </div>

                            <!-- Grid de inputs -->
                            <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-6 sm:gap-x-6">
                                <div class="sm:col-span-3">
                                    <label for="name"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre
                                        completo</label>
                                    <input type="text" name="name" id="name"
                                        value="{{ old('name', $user->name) }}"
                                        class="mt-1 block w-full rounded-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm p-2">
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="email"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Correo
                                        electrónico</label>
                                    <input type="email" name="email" id="email"
                                        value="{{ old('email', $user->email) }}"
                                        class="mt-1 block w-full rounded-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm p-2">
                                </div>

                                <div class="sm:col-span-6">
                                    <label for="bio"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Biografía</label>
                                    <textarea id="bio" name="bio" rows="4"
                                        class="block w-full rounded-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm p-2">{{ old('bio', $user->bio) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 flex justify-end">
                            <button type="submit"
                                class="bg-black dark:bg-white text-white dark:text-black font-bold uppercase text-xs px-6 py-2.5 cursor-pointer rounded-sm hover:opacity-90 shadow-sm transition-all focus:ring-2 focus:ring-offset-2 focus:ring-black">
                                Guardar cambios
                            </button>
                        </div>
                    </form>
                </div>

                <!-- TAB 2: SEGURIDAD -->
                <div x-show="activeTab === 'security'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0"
                    style="display: none;"
                    class="bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 rounded-sm">

                    <form action="{{ route('password.update') }}" method="POST"
                        class="divide-y divide-gray-200 dark:divide-gray-800">
                        @csrf
                        @method('PUT')

                        <div class="px-6 py-6">
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Cambiar Contraseña</h2>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Asegúrate de usar una contraseña larga
                                y única.</p>
                        </div>

                        <div class="px-6 py-6 space-y-6">
                            <div>
                                <label for="current_password"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contraseña
                                    Actual</label>
                                <input type="password" name="current_password" placeholder="********"
                                    id="current_password"
                                    class="mt-1 block w-full rounded-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm p-2">
                            </div>

                            <div>
                                <label for="password"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nueva
                                    Contraseña</label>
                                <input type="password" name="password" placeholder="********" id="password"
                                    class="mt-1 block w-full rounded-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm p-2">
                            </div>

                            <div>
                                <label for="password_confirmation"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirmar Nueva
                                    Contraseña</label>
                                <input type="password" name="password_confirmation" placeholder="********"
                                    id="password_confirmation"
                                    class="mt-1 block w-full rounded-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm p-2">
                            </div>
                        </div>

                        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 flex justify-end">
                            <button type="submit"
                                class="bg-black dark:bg-white text-white dark:text-black font-bold uppercase text-xs px-6 py-2.5 rounded-sm hover:opacity-90 shadow-sm transition-all focus:ring-2 focus:ring-offset-2 focus:ring-black">
                                Actualizar Contraseña
                            </button>
                        </div>
                    </form>

                    <!-- Sesiones Activas (Placeholder) -->
                    <div class="border-t border-gray-200 dark:border-gray-800 px-6 py-6">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-4">Dispositivos y Sesiones</h3>
                        <div class="flex items-center gap-4 text-sm">
                            <div class="p-2 bg-gray-100 dark:bg-gray-800 rounded-sm">
                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">Windows PC - Chrome</p>
                                <p class="text-xs text-green-500 font-bold">Sesión actual</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 3: SUSCRIPCIÓN -->
                <div x-show="activeTab === 'subscription'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0"
                    style="display: none;" class="space-y-6">

                    <!-- Plan Actual -->
                    <div
                        class="bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 rounded-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Tu Plan Actual</h2>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Estás disfrutando del plan
                                    gratuito con acceso limitado.</p>
                            </div>
                            <span
                                class="bg-gray-100 text-gray-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">Gratis</span>
                        </div>
                    </div>

                    <!-- Planes Disponibles -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Premium -->
                        <div
                            class="border border-brand-200 dark:border-brand-900 bg-brand-50 dark:bg-brand-900/20 rounded-sm p-6 relative overflow-hidden">
                            <div
                                class="absolute top-0 right-0 bg-brand-600 text-white text-[10px] uppercase font-bold px-3 py-1">
                                Recomendado</div>
                            <h3 class="text-xl font-serif font-bold text-brand-900 dark:text-brand-300">Premium Digital
                            </h3>
                            <div class="mt-4 flex items-baseline">
                                <span class="text-3xl font-black text-brand-900 dark:text-white">€4.99</span>
                                <span class="ml-1 text-sm text-brand-700 dark:text-brand-400">/mes</span>
                            </div>
                            <ul class="mt-6 space-y-3 text-sm text-brand-800 dark:text-gray-300">
                                <li class="flex items-center gap-2"><svg class="w-4 h-4 text-brand-600"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg> Sin publicidad</li>
                                <li class="flex items-center gap-2"><svg class="w-4 h-4 text-brand-600"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg> Acceso ilimitado a artículos</li>
                                <li class="flex items-center gap-2"><svg class="w-4 h-4 text-brand-600"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg> Newsletter exclusiva</li>
                            </ul>
                            <button
                                class="mt-8 w-full bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm py-2.5 rounded-sm transition-colors">
                                Mejorar Plan
                            </button>
                        </div>

                        <!-- Supporter -->
                        <div class="border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 rounded-sm p-6">
                            <h3 class="text-xl font-serif font-bold text-gray-900 dark:text-white">Supporter</h3>
                            <div class="mt-4 flex items-baseline">
                                <span class="text-3xl font-black text-gray-900 dark:text-white">€9.99</span>
                                <span class="ml-1 text-sm text-gray-500">/mes</span>
                            </div>
                            <ul class="mt-6 space-y-3 text-sm text-gray-600 dark:text-gray-400">
                                <li class="flex items-center gap-2"><svg class="w-4 h-4 text-gray-400"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg> Todo lo de Premium</li>
                                <li class="flex items-center gap-2"><svg class="w-4 h-4 text-gray-400"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg> Comentarios destacados</li>
                                <li class="flex items-center gap-2"><svg class="w-4 h-4 text-gray-400"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg> Apoyo al periodismo libre</li>
                            </ul>
                            <button
                                class="mt-8 w-full border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white font-bold text-sm py-2.5 rounded-sm hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                Elegir Supporter
                            </button>
                        </div>
                    </div>
                </div>

                <!-- TAB 3.5: MIS POSTULACIONES -->
                <div x-show="activeTab === 'applications'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0"
                    style="display: none;" class="space-y-6">

                    <livewire:jobs.my-applications />

                </div>

                <!-- TAB 4: GESTIÓN DE EMPLEO -->
                @if (auth()->user()->isCompany())
                    <div x-show="activeTab === 'jobs'" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-x-4"
                        x-transition:enter-end="opacity-100 translate-x-0" style="display: none;" class="space-y-6">

                        <livewire:jobs.admin.manage-vacancies />

                    </div>

                    <div x-show="activeTab === 'company'" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-x-4"
                        x-transition:enter-end="opacity-100 translate-x-0" style="display: none;" class="space-y-6">

                        <livewire:jobs.admin.company-profile-form />

                    </div>
                @endif

                <!-- TAB 5: ADMINISTRACIÓN -->
                @if (auth()->user()->role === 'admin' || !empty(auth()->user()->permissions))
                    <div x-show="activeTab === 'admin'" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-x-4"
                        x-transition:enter-end="opacity-100 translate-x-0" style="display: none;" class="space-y-6">

                        <livewire:admin.admin-dashboard wire:key="admin-dashboard-default" />

                    </div>
                    @if (auth()->user()->role === 'admin')
                        <div x-show="activeTab === 'audit_log'" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-x-4"
                            x-transition:enter-end="opacity-100 translate-x-0" style="display: none;" class="space-y-6">

                            <livewire:admin.admin-dashboard tab="audit" wire:key="admin-dashboard-audit" />

                        </div>
                    @endif
                @endif

                <!-- Toast Notifications -->
                @if (session('status'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                        class="fixed bottom-4 right-4 bg-green-900 text-white px-4 py-3 rounded-md shadow-lg flex items-center gap-2 animate-enter z-50">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        <span class="font-medium text-sm">
                            @if (session('status') === 'profile-updated')
                                Perfil actualizado correctamente
                            @endif
                            @if (session('status') === 'password-updated')
                                Contraseña cambiada correctamente
                            @endif
                        </span>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
