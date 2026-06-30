<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Bootstrap Icons (untuk ikon bi-* di halaman) -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

        <!-- SweetAlert2 (konfirmasi hapus) -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css">

        @stack('styles')

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Flash Messages -->
            @if (session('success') || session('error') || session('info'))
                <div id="flash-messages" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 transition-opacity duration-500">
                    @if (session('success'))
                        <div class="mb-2 px-4 py-3 rounded-lg bg-green-100 text-green-800 border border-green-200">
                            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-2 px-4 py-3 rounded-lg bg-red-100 text-red-800 border border-red-200">
                            <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                        </div>
                    @endif
                    @if (session('info'))
                        <div class="mb-2 px-4 py-3 rounded-lg bg-blue-100 text-blue-800 border border-blue-200">
                            <i class="bi bi-info-circle-fill"></i> {{ session('info') }}
                        </div>
                    @endif
                </div>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- SweetAlert2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>

        @if (session('success') || session('error') || session('info'))
        <script>
            // Auto hide flash messages after 3 seconds
            setTimeout(function () {
                let flash = document.getElementById('flash-messages');
                if (flash) {
                    flash.style.opacity = '0';
                    setTimeout(() => flash.remove(), 500);
                }
            }, 3000);
        </script>
        @endif

        @stack('scripts')
    </body>
</html>
