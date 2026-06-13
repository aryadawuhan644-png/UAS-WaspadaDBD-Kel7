<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Utama') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <a href="{{ route('titik-risiko.index') }}" class="block bg-white p-6 rounded-lg shadow-sm hover:shadow-md hover:bg-blue-50 transition border-l-4 border-blue-500 cursor-pointer">
                    <p class="text-sm text-gray-500 uppercase font-bold">Total Titik</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $total_titik }}</p>
                    <p class="text-xs text-blue-500 mt-2">Lihat semua data &rarr;</p>
                </a>

                <a href="{{ route('risiko-tinggi') }}" class="block bg-white p-6 rounded-lg shadow-sm hover:shadow-md hover:bg-red-50 transition border-l-4 border-red-500 cursor-pointer">
                    <p class="text-sm text-gray-500 uppercase font-bold">Risiko Tinggi</p>
                    <p class="text-3xl font-bold text-red-600 mt-2">{{ $risiko_tinggi }}</p>
                    <p class="text-xs text-red-500 mt-2">Tindak lanjuti segera &rarr;</p>
                </a>

                <a href="{{ route('pemeriksaan.index') }}" class="block bg-white p-6 rounded-lg shadow-sm hover:shadow-md hover:bg-green-50 transition border-l-4 border-green-500 cursor-pointer">
                    <p class="text-sm text-gray-500 uppercase font-bold">Pemeriksaan Bulan Ini</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ $pemeriksaan_bulan_ini }}</p>
                    <p class="text-xs text-green-500 mt-2">Kelola riwayat &rarr;</p>
                </a>

            </div>

        </div>
    </div>
</x-app-layout>