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
                "La verdad nunca es propiedad de nadie, pero buscarla es deber de todos."
            </blockquote>
            <p class="text-sm font-sans uppercase tracking-widest text-gray-300">Únete a nuestra comunidad</p>
        </div>
    </div>

    <!-- Lado Derecho: Formulario -->
    <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24 bg-white dark:bg-gray-900 w-full lg:w-1/2">
        <div class="mx-auto w-full max-w-sm lg:w-96">
            <div class="text-center lg:text-left">
                <h2 class="mt-8 text-3xl font-serif font-black tracking-tight text-ink dark:text-white">Crea tu cuenta</h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="font-bold text-brand-600 dark:text-brand-400 hover:underline">Inicia sesión</a>
                </p>
            </div>

            <div class="mt-10">
                <form action="{{ route('register') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">Nombre completo</label>
                        <div class="mt-2">
                            <input id="name" name="name" type="text" autocomplete="name" required value="{{ old('name') }}"
                                class="block w-full rounded-sm border-0 py-2.5 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 dark:bg-gray-800 dark:text-white placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black dark:focus:ring-white sm:text-sm sm:leading-6 transition-all">
                             @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">Email</label>
                        <div class="mt-2">
                            <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                                class="block w-full rounded-sm border-0 py-2.5 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 dark:bg-gray-800 dark:text-white placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black dark:focus:ring-white sm:text-sm sm:leading-6 transition-all">
                            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">Contraseña</label>
                        <div class="mt-2">
                            <input id="password" name="password" type="password" required 
                                class="block w-full rounded-sm border-0 py-2.5 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 dark:bg-gray-800 dark:text-white placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black dark:focus:ring-white sm:text-sm sm:leading-6 transition-all">
                             @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">Confirmar Contraseña</label>
                        <div class="mt-2">
                            <input id="password_confirmation" name="password_confirmation" type="password" required 
                                class="block w-full rounded-sm border-0 py-2.5 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 dark:bg-gray-800 dark:text-white placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black dark:focus:ring-white sm:text-sm sm:leading-6 transition-all">
                        </div>
                    </div>

                    <div>
                        <button type="submit" 
                            class="flex w-full justify-center rounded-sm bg-black dark:bg-white px-3 py-2.5 text-sm font-bold uppercase tracking-wide text-white dark:text-black shadow-sm hover:bg-gray-800 dark:hover:bg-gray-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black transition-all">
                            Registrarse
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
