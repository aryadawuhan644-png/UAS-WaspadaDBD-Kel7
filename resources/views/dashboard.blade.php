<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Utama') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-blue-500">
                    <p class="text-sm text-gray-500 uppercase font-bold">Total Titik</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $total_titik }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-red-500">
                    <p class="text-sm text-gray-500 uppercase font-bold">Risiko Tinggi</p>
                    <p class="text-3xl font-bold text-red-600">{{ $risiko_tinggi }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-green-500">
                    <p class="text-sm text-gray-500 uppercase font-bold">Pemeriksaan Bulan Ini</p>
                    <p class="text-3xl font-bold text-green-600">{{ $pemeriksaan_bulan_ini }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('titik-risiko.index') }}" class="block p-8 bg-white shadow rounded-lg hover:bg-blue-50 transition border-t-4 border-blue-500">
                    <h3 class="text-xl font-bold text-blue-600">Titik Risiko</h3>
                    <p class="text-sm text-gray-500 mt-2">Kelola data pemetaan lokasi dan risiko</p>
                </a>
                <a href="{{ route('pemeriksaan.index') }}" class="block p-8 bg-white shadow rounded-lg hover:bg-green-50 transition border-t-4 border-green-500">
                <h3 class="text-xl font-bold text-green-600">Pemeriksaan</h3>
                <p class="text-sm text-gray-500 mt-2">Input hasil pengecekan lapangan</p>
                </a>
                <a href="{{ route('risiko-tinggi') }}" class="block p-8 bg-white shadow rounded-lg hover:bg-red-50 transition border-t-4 border-red-500">
                <h3 class="text-xl font-bold text-red-600">Risiko Tinggi</h3>
                <p class="text-sm text-gray-500 mt-2">Daftar lokasi darurat DBD</p>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>