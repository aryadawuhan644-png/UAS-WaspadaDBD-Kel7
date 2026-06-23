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

        <!-- Scripts -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                        @php
                            $route = Route::currentRouteName() ?? '';
                            $backUrl = null;

                            // If on the main dashboard, hide back button
                            if($route === 'dashboard') {
                                $backUrl = null;
                            }
                            // If on a top-level menu index, back goes to dashboard
                            elseif(in_array($route, ['pemeriksaan.index','titik-risiko.index','titik-risiko.jumlah','edukasi.index','petugas.index'])) {
                                $backUrl = route('dashboard');
                            }
                            // For routes inside menus, send back to that menu's index
                            else {
                                if(\Illuminate\Support\Str::startsWith($route, 'pemeriksaan.')) {
                                    $backUrl = route('pemeriksaan.index');
                                } elseif(\Illuminate\Support\Str::startsWith($route, 'titik-risiko.')) {
                                    $backUrl = route('titik-risiko.index');
                                } elseif(\Illuminate\Support\Str::startsWith($route, 'petugas.')) {
                                    $backUrl = route('petugas.index');
                                } elseif(\Illuminate\Support\Str::startsWith($route, 'edukasi.')) {
                                    $backUrl = route('edukasi.index');
                                } else {
                                    // fallback to previous URL for other pages
                                    $backUrl = url()->previous();
                                }
                            }
                        @endphp

                        @if($backUrl)
                            <div class="mt-3">
                                <a href="{{ $backUrl }}" class="inline-flex items-center px-3 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">&larr; Kembali</a>
                            </div>
                        @endif
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                @if (session('success'))
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
                        <div class="rounded-lg bg-green-50 border border-green-200 text-green-800 p-4">
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
                        <div class="rounded-lg bg-red-50 border border-red-200 text-red-800 p-4">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </body>
</html>
