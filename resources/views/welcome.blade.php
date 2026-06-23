<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WaspadaDBD - BAMUK</title>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 antialiased">

    <div class="min-h-screen flex flex-col">
        <header class="w-full p-6 flex justify-between items-center bg-white shadow-sm">
            <div class="flex items-center gap-2">
                <img src="{{ asset('img/logo.png') }}" alt="Logo BAMUK" class="w-12 h-12">
                <span class="font-bold text-xl text-blue-600">BAMUK</span>
            </div>
            
            <nav class="flex gap-4">
                {{-- Tombol Login muncul jika belum masuk --}}
                @guest
                    <a href="{{ route('login') }}" class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                        Log in
                    </a>
                @else
                    {{-- Tombol Dashboard muncul jika sudah login --}}
                    <a href="{{ url('/dashboard') }}" class="px-5 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition font-medium">
                        Dashboard
                    </a>
                @endguest
            </nav>
        </header>

        <main class="flex-grow flex flex-col items-center justify-center p-6 text-center">
            <div class="max-w-2xl">
                <h1 class="text-5xl font-extrabold text-gray-900 mb-6">
                    WaspadaDBD: <span class="text-blue-600">Basmi Nyamuk</span>
                </h1>
                <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                    Sistem informasi pemantauan titik risiko jentik nyamuk untuk lingkungan yang lebih sehat dan bebas DBD. 
                    Mari beraksi bersama membasmi sarang nyamuk di sekitar kita.
                </p>
                
                <div class="flex gap-4 justify-center">
                    {{-- Ganti URL href di bawah ini dengan alamat Laragon Frontend PHP Native Anda --}}
                    <a href="/frontend-zayy" class="px-8 py-3 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 transition shadow-lg">
    Lihat Dashboard Warga
</a>
                </div>
            </div>
        </main>

        <footer class="p-6 text-center text-gray-400 text-sm">
            &copy; {{ date('Y') }} WaspadaDBD BAMUK. All rights reserved.
        </footer>
    </div>
</body>
</html>