<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-paper antialiased scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Periodismo Digital' }} - La verdad ante todo</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,900;1,400&display=swap"
        rel="stylesheet">

    <!-- Script para evitar flash of light mode -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>

    <!-- PWA -->
    <meta name="theme-color" content="#000000">
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="/android-chrome-192x192.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="ComercioGuajiro">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').then((registration) => {
                    console.log('SW registered:', registration);
                }).catch((error) => {
                    console.log('SW registration failed:', error);
                });
            });
        }
    </script>
</head>

<body class="flex min-h-full flex-col text-ink bg-paper transition-colors duration-300">

    <!-- Top Bar: Utilidades (Fixed) -->
    <div
        class="fixed top-0 left-0 right-0 z-[60] border-b border-gray-200 dark:border-gray-800 py-1 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md text-xs uppercase tracking-wider font-medium text-gray-500 dark:text-gray-400">
        <div class="mx-auto max-w-7xl px-4 flex justify-between items-center h-8">
            <div class="flex items-center gap-4">
                <span
                    class="hidden sm:inline">{{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</span>
                <span class="hidden sm:inline opacity-30">|</span>
                <div class="flex items-center gap-3">
                    <button id="theme-toggle"
                        class="flex items-center justify-center w-6 h-6 rounded-full hover:bg-gray-200 dark:hover:bg-gray-800 transition-colors"
                        title="Cambiar tema">
                        <!-- Sun Icon -->
                        <svg id="theme-toggle-light-icon" class="hidden w-4 h-4 text-yellow-500" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                fill-rule="evenodd" clip-rule="evenodd"></path>
                        </svg>
                        <!-- Moon Icon -->
                        <svg id="theme-toggle-dark-icon" class="hidden w-4 h-4 text-brand-600" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                    </button>
                    <span class="opacity-20">|</span>
                    <livewire:weather-widget />
                </div>
            </div>

            <div class="flex items-center gap-4">
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false"
                            class="flex items-center gap-2 hover:text-brand-600 transition-colors">
                            {{ auth()->user()->name }}
                            <svg class="w-3 h-3 transition-transform duration-200" :class="{ 'rotate-180': open }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <!-- Dropdown -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-sm shadow-xl border border-gray-100 dark:border-gray-700 py-1 z-50 transform origin-top-right"
                            style="display: none;">

                            <!-- Opción: MI PERFIL -->
                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center gap-3 px-4 py-3 text-xs font-bold uppercase tracking-wider text-gray-500 hover:text-brand-600 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white border-b border-gray-100 dark:border-gray-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Mi Perfil
                            </a>

                            <!-- Botón Modo Oscuro dentro del Dropdown -->
                            <button onclick="document.getElementById('theme-toggle').click(); event.stopPropagation();"
                                class="w-full flex items-center justify-between px-4 py-3 text-xs font-bold uppercase tracking-wider text-gray-500 hover:text-brand-600 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white border-b border-gray-100 dark:border-gray-700 transition-colors">
                                <div class="flex items-center gap-3">
                                    <svg class="w-4 h-4 dark:hidden" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                                        </path>
                                    </svg>
                                    <svg class="w-4 h-4 hidden dark:block text-yellow-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 3v1m0 16v1m9-9h-1M4 9H3m3.343-5.657l-.707.707m12.728 12.728l-.707.707M6.343 17.657l-.707-.707M17.657 6.343l-.707-.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                                        </path>
                                    </svg>
                                    Modo <span class="dark:hidden">Oscuro</span><span
                                        class="hidden dark:inline">Claro</span>
                                </div>
                                <div class="w-8 h-4 bg-gray-200 dark:bg-gray-600 rounded-full relative">
                                    <div class="absolute w-3 h-3 bg-white rounded-full top-0.5 transition-all duration-200"
                                        :class="document.documentElement.classList.contains('dark') ? 'left-4' : 'left-0.5'">
                                    </div>
                                </div>
                            </button>

                            <!-- Opción: Cerrar Sesión -->
                            <form action="{{ route('logout') }}" method="POST" class="block">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 hover:text-red-600 hover:bg-gray-50 dark:text-gray-200 dark:hover:text-red-400 dark:hover:bg-gray-700 transition-colors">
                                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="hover:text-brand-600 transition-colors link-underline">Ingresar</a>
                    <span class="opacity-30">|</span>
                    <a href="{{ route('register') }}"
                        class="font-bold text-gray-900 dark:text-white hover:text-brand-600 transition-colors">Registrarse</a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Div espaciador para compensar el Top Bar fijo (Altura: 8 + padding ≈ 10/12) -->
    <div class="h-10"></div>

    <!-- Header Principal -->
    @unless (request()->routeIs(['profile.edit', 'jobs.create', 'jobs.manage']))
        <header
            class="border-b-4 border-black dark:border-white pt-8 pb-4 bg-white dark:bg-gray-900 transition-colors duration-300">
            <div class="mx-auto max-w-7xl px-4 text-center">
                <a href="/" class="group inline-block">
                    @if (request()->routeIs('jobs.*'))
                        <h1
                            class="font-serif text-4xl sm:text-6xl font-black tracking-tighter mb-2 group-hover:text-brand-600 transition-colors">
                            Bolsa de Empleo
                        </h1>
                    @else
                        <h1
                            class="font-serif text-5xl sm:text-7xl font-black tracking-tighter mb-2 group-hover:opacity-80 transition-opacity">
                            Periodismo Digital
                        </h1>
                        <div
                            class="flex items-center justify-center gap-3 text-sm font-sans font-medium tracking-[0.2em] uppercase text-gray-500 dark:text-gray-400">
                            <span class="w-2 h-2 bg-brand-600 rounded-full"></span>
                            <span>Independiente • Verdad • Análisis</span>
                            <span class="w-2 h-2 bg-brand-600 rounded-full"></span>
                        </div>
                    @endif
                </a>
            </div>

            <!-- Navbar -->
            <nav
                class="mt-6 border-t border-b border-gray-200 dark:border-gray-800 py-3 sticky top-0 bg-white/90 dark:bg-gray-900/90 backdrop-blur z-40">
                <div class="mx-auto max-w-7xl px-4 overflow-x-auto">
                    <ul
                        class="flex justify-center items-center gap-x-8 gap-y-2 text-sm font-bold uppercase tracking-wide whitespace-nowrap min-w-max mx-auto px-4">
                        <li><a href="/"
                                class="text-black dark:text-white hover:text-brand-600 transition-colors link-underline pb-0.5">Portada</a>
                        </li>
                        <li><a href="{{ route('jobs.index') }}"
                                class="text-black dark:text-white hover:text-brand-600 transition-colors link-underline pb-0.5">Empleos</a>
                        </li>
                        @foreach ($globalCategories as $category)
                            <li>
                                <a href="{{ route('category.show', $category->slug) }}"
                                    class="text-gray-600 dark:text-gray-400 hover:text-brand-600 dark:hover:text-brand-400 transition-colors link-underline pb-0.5"
                                    style="--hover-color: {{ $category->color }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </nav>
        </header>
    @endunless

    <!-- Main Content -->
    <main class="flex-grow py-8 bg-paper dark:bg-gray-950 transition-colors duration-300">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-black text-white pt-16 pb-8 border-t-8 border-brand-600">
        <div class="mx-auto max-w-7xl px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-1">
                    <h3 class="font-serif text-2xl font-bold mb-6">Periodismo.</h3>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6">
                        Comprometidos con la verdad y el análisis profundo de los hechos que transforman nuestro mundo.
                    </p>
                </div>
            </div>
            <div
                class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-gray-500">
                <p>&copy; {{ date('Y') }} ComercioGuajiro. Todos los derechos reservados.</p>
                <p>Desarrollado por: <a href="#"
                        class="text-white hover:text-brand-600 transition-colors font-bold uppercase tracking-widest">Dainer
                        Vargas</a></p>
            </div>
        </div>
    </footer>

    <!-- Botón Volver Arriba -->
    <button id="scroll-to-top"
        class="fixed bottom-14 right-8 bg-black dark:bg-white text-white dark:text-black p-3 rounded-full shadow-lg opacity-0 invisible transition-all duration-300 hover:-translate-y-1 z-50"
        aria-label="Volver arriba">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18">
            </path>
        </svg>
    </button>

    <!-- Script de Funcionalidad UI -->
    <script>
        // Dark Mode Logic
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        function updateThemeUI() {
            const isDark = document.documentElement.classList.contains('dark');

            // Actualizar iconos del botón principal
            if (isDark) {
                themeToggleLightIcon.classList.remove('hidden');
                themeToggleDarkIcon.classList.add('hidden');
            } else {
                themeToggleLightIcon.classList.add('hidden');
                themeToggleDarkIcon.classList.remove('hidden');
            }

            // Notificar cambios para otros componentes
            window.dispatchEvent(new CustomEvent('dark-mode-updated', {
                detail: {
                    isDark
                }
            }));
        }

        themeToggleBtn.addEventListener('click', function() {
            document.documentElement.classList.toggle('dark');
            const isDark = document.documentElement.classList.contains('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            updateThemeUI();
        });

        // Inicializar UI al cargar
        updateThemeUI();

        // Scroll to Top Logic
        const scrollBtn = document.getElementById('scroll-to-top');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                scrollBtn.classList.remove('opacity-0', 'invisible');
            } else {
                scrollBtn.classList.add('opacity-0', 'invisible');
            }
        });
        scrollBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
    @livewireScripts
</body>

</html>
