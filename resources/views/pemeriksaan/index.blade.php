<x-app-layout>
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-4">Data Pemeriksaan Risiko</h2>
        <a href="{{ route('pemeriksaan.create') }}" class="bg-green-600 text-white px-4 py-2 rounded">Tambah Pemeriksaan</a>
        
        <table class="w-full mt-4 bg-white shadow rounded">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-3">Nama Titik</th>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Status</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pemeriksaans as $p)
                <tr>
                    <td class="p-3">{{ $p->titikRisiko->nama_titik ?? 'N/A' }}</td>
                    <td class="p-3">{{ $p->tanggal_pemeriksaan }}</td>
                    <td class="p-3">{{ $p->status_akhir }}</td>
                    
                    <td class="p-3 text-center flex justify-center gap-2">
                        <a href="{{ route('pemeriksaan.edit', $p->id) }}" class="text-blue-600 hover:underline">Edit</a>
    
                    <form action="{{ route('pemeriksaan.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                    </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>