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

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="flex min-h-full flex-col text-ink bg-paper transition-colors duration-300">

    <!-- Top Bar: Utilidades -->
    <div
        class="border-b border-gray-200 dark:border-gray-800 py-1 bg-gray-50 dark:bg-gray-900/50 text-xs uppercase tracking-wider font-medium text-gray-500 dark:text-gray-400">
        <div class="mx-auto max-w-7xl px-4 flex justify-between items-center h-8">
            <div class="flex items-center gap-4">
                <span
                    class="hidden sm:inline">{{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</span>
                <span class="hidden sm:inline opacity-30">|</span>
                <div class="flex items-center gap-1">
                    <button id="theme-toggle" class="flex items-center gap-1 hover:text-brand-600 transition-colors"
                        title="Cambiar tema">
                        <!-- Sun Icon -->
                        <svg id="theme-toggle-light-icon" class="hidden w-4 h-4" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                fill-rule="evenodd" clip-rule="evenodd"></path>
                        </svg>
                        <!-- Moon Icon -->
                        <svg id="theme-toggle-dark-icon" class="hidden w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                        <span class="sr-only">Tema</span>
                    </button>
                    <livewire:weather-widget />
                </div>
            </div>

            <div class="flex items-center gap-4">
                @auth
                    <div class="group relative">
                        <button class="flex items-center gap-2 hover:text-brand-600">
                            {{ auth()->user()->name }}
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <!-- Dropdown -->
                        <div
                            class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-sm shadow-xl border border-gray-100 dark:border-gray-700 py-1 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 transform origin-top-right">

                            <!-- Opción: MI PERFIL -->
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-3 text-xs font-bold uppercase tracking-wider text-gray-500 hover:text-brand-600 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white border-b border-gray-100 dark:border-gray-700 transition-colors">
                                Mi Perfil
                            </a>

                            <!-- Opción: Cerrar Sesión -->
                            <form action="{{ route('logout') }}" method="POST" class="block">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-3 text-sm font-medium text-gray-700 hover:text-red-600 hover:bg-gray-50 dark:text-gray-200 dark:hover:text-red-400 dark:hover:bg-gray-700 transition-colors">
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
                <!-- ... Sigue igual el footer ... -->
                <div>
                    <h4 class="font-bold text-sm uppercase tracking-wider mb-6 text-gray-500">Boletín</h4>
                    <p class="text-xs text-gray-400 mb-4">Recibe lo más importante cada mañana.</p>
                    <form class="flex gap-2">
                        <input type="email" placeholder="Tu email"
                            class="bg-gray-800 border-none text-white text-sm px-3 py-2 w-full focus:ring-1 focus:ring-brand-500 rounded-sm">
                        <button
                            class="bg-white text-black font-bold uppercase text-xs px-4 hover:bg-gray-200 rounded-sm transition-colors">OK</button>
                    </form>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 flex justify-between text-xs text-gray-500">
                <p>&copy; {{ date('Y') }} Periodismo Digital S.L.</p>
            </div>
        </div>
    </footer>

    <!-- Botón Volver Arriba -->
    <button id="scroll-to-top"
        class="fixed bottom-8 right-8 bg-black dark:bg-white text-white dark:text-black p-3 rounded-full shadow-lg opacity-0 invisible transition-all duration-300 hover:-translate-y-1 z-50"
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

        function setIcons() {
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                    '(prefers-color-scheme: dark)').matches)) {
                themeToggleLightIcon.classList.remove('hidden');
                themeToggleDarkIcon.classList.add('hidden');
            } else {
                themeToggleLightIcon.classList.add('hidden');
                themeToggleDarkIcon.classList.remove('hidden');
            }
        }
        setIcons();

        themeToggleBtn.addEventListener('click', function() {
            if (localStorage.getItem('theme')) {
                if (localStorage.getItem('theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                }
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                }
            }
            setIcons();
        });

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
