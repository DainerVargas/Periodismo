@extends('layouts.app')

@section('content')
<div class="flex min-h-[calc(100vh-16rem)]">
    
    <!-- Lado Izquierdo: Imagen Editorial -->
    <div class="hidden lg:block lg:w-1/2 relative overflow-hidden bg-black">
        <img class="absolute inset-0 h-full w-full object-cover opacity-80" 
             src="https://images.unsplash.com/photo-1504711434969-e33886168f5c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80" 
             alt="News background">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent flex flex-col justify-end p-12 text-white">
            <blockquote class="font-serif text-3xl font-bold italic mb-6">
                "El periodismo es lo que mantiene la democracia viva."
            </blockquote>
            <p class="text-sm font-sans uppercase tracking-widest text-gray-300">Periodismo Digital • Desde 2025</p>
        </div>
    </div>

    <!-- Lado Derecho: Formulario -->
    <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24 bg-white dark:bg-gray-900 w-full lg:w-1/2">
        <div class="mx-auto w-full max-w-sm lg:w-96">
            <div class="text-center lg:text-left">
                <h2 class="mt-8 text-3xl font-serif font-black tracking-tight text-ink dark:text-white">Bienvenido de nuevo</h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    ¿Aún no eres suscriptor? <a href="#" class="font-bold text-brand-600 dark:text-brand-400 hover:underline">Comienza tu prueba gratis</a>
                </p>
            </div>

            <div class="mt-10">
                <form action="#" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">Email</label>
                        <div class="mt-2">
                            <input id="email" name="email" type="email" autocomplete="email" required 
                                class="block w-full rounded-sm border-0 py-2.5 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 dark:bg-gray-800 dark:text-white placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black dark:focus:ring-white sm:text-sm sm:leading-6 transition-all">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">Contraseña</label>
                        <div class="mt-2">
                            <input id="password" name="password" type="password" autocomplete="current-password" required 
                                class="block w-full rounded-sm border-0 py-2.5 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 dark:bg-gray-800 dark:text-white placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black dark:focus:ring-white sm:text-sm sm:leading-6 transition-all">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox" 
                                class="h-4 w-4 rounded border-gray-300 text-black focus:ring-black">
                            <label for="remember-me" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Recordarme</label>
                        </div>

                        <div class="text-sm leading-6">
                            <a href="#" class="font-semibold text-brand-600 dark:text-brand-400 hover:text-brand-500">¿Olvidaste la contraseña?</a>
                        </div>
                    </div>

                    <div>
                        <button type="submit" 
                            class="flex w-full justify-center rounded-sm bg-black dark:bg-white px-3 py-2.5 text-sm font-bold uppercase tracking-wide text-white dark:text-black shadow-sm hover:bg-gray-800 dark:hover:bg-gray-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black transition-all">
                            Iniciar sesión
                        </button>
                    </div>
                </form>

                <div class="mt-10">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-200 dark:border-gray-700"></div>
                        </div>
                        <div class="relative flex justify-center text-sm font-medium leading-6">
                            <span class="bg-white dark:bg-gray-900 px-6 text-gray-900 dark:text-gray-400 uppercase text-xs tracking-wider">O continúa con</span>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-4">
                        <a href="#" class="flex w-full items-center justify-center gap-3 rounded-sm bg-white dark:bg-gray-800 px-3 py-2 text-sm font-semibold text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <svg class="h-5 w-5" aria-hidden="true" viewBox="0 0 24 24"><path d="M12.0003 20.45c-5.0645 0-9.2598-3.7937-9.9231-8.6813-.021-.155-.0315-.3123-.0315-.4706 0-1.8966.606-3.6558 1.6389-5.1054.3414-.4792.0009-1.1345-.558-1.258C1.5137 4.542 0 6.643 0 9.0737 0 14.928 4.75 20 12.0003 20c2.6133 0 5.0384-.9198 6.9429-2.4343.4385-.3487.3524-1.0423-.1537-1.2384-.3682-.1427-1.55-.5727-2.3486-.8894-1.2982 1.9567-3.4117 3.0121-4.4406 3.0121z" fill="currentColor"/></svg>
                            <span class="text-sm font-semibold leading-6">Google</span>
                        </a>
                        <a href="#" class="flex w-full items-center justify-center gap-3 rounded-sm bg-[#1877F2] px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#1864D9] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1877F2] transition-colors">
                            <svg class="h-5 w-5 fill-white" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M20 10c0-5.523-4.477-10-10-10S0 4.477 0 10c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V10h2.54V7.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V10h2.773l-.443 2.89h-2.33v6.988C16.343 19.128 20 14.991 20 10z" clip-rule="evenodd" /></svg>
                            <span class="text-sm font-semibold leading-6">Facebook</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
