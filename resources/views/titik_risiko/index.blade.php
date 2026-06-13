<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Titik Risiko') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded-lg shadow-sm mb-6 border-t-4 border-blue-500">
                <form method="GET" action="{{ route('titik-risiko.index') }}" class="flex flex-col md:flex-row gap-4 items-end">
                    
                    <div class="w-full md:w-1/3">
                        <label class="block text-sm font-medium text-gray-700">Filter Wilayah (RT/RW)</label>
                        <input type="text" name="wilayah" value="{{ request('wilayah') }}" placeholder="Contoh: RT 01" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="w-full md:w-1/3">
                        <label class="block text-sm font-medium text-gray-700">Filter Level Risiko</label>
                        <select name="level" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Semua Level --</option>
                            <option value="rendah" {{ request('level') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                            <option value="sedang" {{ request('level') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="tinggi" {{ request('level') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                        </select>
                    </div>

                    <div class="w-full md:w-auto flex gap-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                            Cari
                        </button>
                        <a href="{{ route('titik-risiko.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded shadow text-center flex items-center">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <div class="mb-4 flex justify-end">
                <a href="{{ route('titik-risiko.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">
                    + Tambah Titik Risiko
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="border border-gray-200 px-4 py-2 text-left">Nama Lokasi</th>
                                <th class="border border-gray-200 px-4 py-2 text-left">Wilayah</th>
                                <th class="border border-gray-200 px-4 py-2 text-left">Level Risiko</th>
                                <th class="border border-gray-200 px-4 py-2 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($titikRisikos as $titik)
                                <tr class="hover:bg-gray-50">
                                    <td class="border border-gray-200 px-4 py-2">{{ $titik->nama_titik }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $titik->rt_rw }}</td>
                                    <td class="border border-gray-200 px-4 py-2">
                                        @if($titik->level_risiko_awal == 'tinggi')
                                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded border border-red-400">Tinggi</span>
                                        @elseif($titik->level_risiko_awal == 'sedang')
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded border border-yellow-400">Sedang</span>
                                        @else
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-400">Rendah</span>
                                        @endif
                                    </td>
                                    <td class="border border-gray-200 px-4 py-2">
                                        <div class="flex flex-wrap gap-2">
                                            <a href="{{ route('titik-risiko.edit', $titik->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</a>
                                            <form action="{{ route('titik-risiko.destroy', $titik->id) }}" method="POST" onsubmit="return confirm('Hapus titik risiko ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="border border-gray-200 px-4 py-8 text-center text-gray-500">
                                        Tidak ada data yang ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>