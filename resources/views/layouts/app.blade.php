<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'RecoHousing') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100">

<div class="min-h-screen flex flex-col">

    {{-- ✅ Navbar --}}
    @include('layouts.navigation')

    {{-- ✅ Page Heading --}}
    @isset($header)
        <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    {{-- ✅ Global Alerts --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 w-full">
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded-xl shadow-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-200 text-red-800 px-4 py-3 rounded-xl shadow-sm">
                ❌ {{ session('error') }}
            </div>
        @endif
    </div>

    {{-- ✅ Main Content --}}
    <main class="flex-1">
        {{ $slot }}
    </main>

    {{-- ✅ Footer --}}
    <footer class="mt-10 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col md:flex-row justify-between items-center gap-3">
            <p class="text-sm text-gray-500 dark:text-gray-300">
                © {{ date('Y') }} RecoHousing — Système de recommandation immobilier
            </p>

            <div class="flex gap-4 text-sm text-gray-500 dark:text-gray-300">
                <a href="{{ route('dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Dashboard</a>
                <a href="{{ route('listings.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Logements</a>
                <a href="{{ route('recommendations.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Recommandations</a>
            </div>
        </div>
    </footer>

</div>

</body>
</html>
