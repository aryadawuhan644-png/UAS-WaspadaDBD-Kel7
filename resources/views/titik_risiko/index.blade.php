<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Data Titik Risiko</h2>
                    <a href="{{ route('titik-risiko.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-semibold transition">
                        + Tambah Data
                    </a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700 uppercase text-sm">
                                <th class="p-4 border-b">Nama Titik</th>
                                <th class="p-4 border-b">RT/RW</th>
                                <th class="p-4 border-b">Jenis</th>
                                <th class="p-4 border-b">Risiko</th>
                                <th class="p-4 border-b text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($titikRisikos as $titik)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 border-b font-medium">{{ $titik->nama_titik }}</td>
                                <td class="p-4 border-b">{{ $titik->rt_rw }}</td>
                                <td class="p-4 border-b">{{ $titik->jenis_risiko }}</td>
                                <td class="p-4 border-b">
                                    <span class="px-2 py-1 rounded-full text-xs font-bold 
                                        {{ $titik->level_risiko_awal == 'tinggi' ? 'bg-red-100 text-red-700' : 
                                          ($titik->level_risiko_awal == 'sedang' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">
                                        {{ strtoupper($titik->level_risiko_awal) }}
                                    </span>
                                </td>
                                <td class="p-4 border-b text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('titik-risiko.edit', $titik->id) }}" 
                                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm transition">
                                           Edit
                                        </a>
                                        <form action="{{ route('titik-risiko.destroy', $titik->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>