<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Hablame!') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('head-scripts')
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <!-- Container principal -->
        <div class="min-h-screen flex flex-col">
            <!-- HEADER FIXO NO TOPO (sempre) -->
            <div class="fixed top-0 inset-x-0 z-50 bg-white shadow-lg">
                <!-- Navigation do Breeze -->
                @include('layouts.navigation')

                <!-- Título da página (se existir) -->
                @if (isset($header))
                    <div class="border-t border-gray-200 bg-white">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div class="py-3">
                                {{ $header }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- ESPAÇO PARA O HEADER FIXO -->
            <!--
                Altura total do header:
                - Navigation: 64px (h-16)
                - Header title: ~48px (py-3 = 12px top + 12px bottom + conteúdo)
                Total: ~112px
            -->
            <div class="h-28"></div> <!-- Espaçamento fixo -->

            <!-- CONTEÚDO PRINCIPAL -->
            <main class="flex-1">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    {{ $slot }}
                </div>
            </main>
        </div>

        @stack('scripts')
    </body>
</html>
