<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Utama') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
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

            @if(auth()->user()->role === 'petugas')
                <div class="mt-8">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-800">Daftar Tugas Perlu Pemeriksaan</h3>
                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-bold uppercase">
                            {{ count($titik_risikos) }} Tersisa
                        </span>
                    </div>

                    <div class="space-y-4">
                        @forelse($titik_risikos as $titik)
                            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 flex justify-between items-center hover:shadow-md transition">
                                <div>
                                    <div class="flex items-center gap-3">
                                        <p class="font-bold text-gray-800 text-lg">{{ $titik->nama_titik }}</p>
                                        
                                        <span class="bg-blue-100 text-blue-800 text-xs px-2.5 py-0.5 rounded font-semibold uppercase tracking-wide">
                                            {{ $titik->jenis_risiko }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ $titik->alamat }} <span class="text-gray-400 mx-1">|</span> <span class="font-medium text-gray-700">{{ $titik->rt_rw }}</span>
                                    </p>
                                </div>
                                <a href="{{ route('pemeriksaan.create', ['titik_id' => $titik->id]) }}" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-bold text-sm transition shadow-sm">
                                   Gas Periksa
                                </a>
                            </div>
                        @empty
                            <div class="p-6 bg-green-50 text-green-700 rounded-lg text-center font-bold">
                                Semua titik risiko sudah diperiksa bulan ini! Kerja bagus!
                            </div>
                        @endforelse
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>