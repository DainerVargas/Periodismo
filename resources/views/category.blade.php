@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="border-b border-black dark:border-white pb-4 mb-8">
        <h1 class="font-serif text-4xl sm:text-6xl font-black tracking-tight text-gray-900 dark:text-white uppercase">
            {{ $category }}
        </h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Placeholder content for category -->
        <div class="md:col-span-2 space-y-8">
            <p class="text-xl text-gray-500">Noticias destacadas de {{ $category }}...</p>
            <!-- Aquí iría el bucle de noticias filtradas por categoría -->
             <div class="p-12 bg-gray-100 dark:bg-gray-800 text-center rounded-sm">
                <p class="opacity-50">No hay artículos disponibles en este momento.</p>
            </div>
        </div>
        
        <div class="md:col-span-1 border-l border-gray-100 dark:border-gray-800 pl-0 md:pl-8">
             <h3 class="font-bold text-sm uppercase tracking-wider mb-4">Más en {{ $category }}</h3>
             <!-- Sidebar content -->
        </div>
    </div>
</div>
@endsection
