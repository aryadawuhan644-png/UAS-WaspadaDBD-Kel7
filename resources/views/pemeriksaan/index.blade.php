<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Riwayat Pemeriksaan') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white p-6 rounded-lg shadow-sm mb-6 border-l-4 border-green-500">
                <form method="GET" action="{{ route('pemeriksaan.index') }}" class="flex flex-col md:flex-row gap-4 items-end">
                    <div>
                        <label class="block text-sm font-bold text-gray-700">Filter Status</label>
                        <select name="status" class="rounded-md border-gray-300">
                            <option value="">-- Semua --</option>
                            <option value="aman" {{ request('status') == 'aman' ? 'selected' : '' }}>Aman</option>
                            <option value="perlu pemantauan" {{ request('status') == 'perlu pemantauan' ? 'selected' : '' }}>Pemantauan</option>
                            <option value="perlu tindakan" {{ request('status') == 'perlu tindakan' ? 'selected' : '' }}>Tindakan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700">Filter Tanggal</label>
                        <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="rounded-md border-gray-300">
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded shadow">Cari</button>
                    <a href="{{ route('pemeriksaan.index') }}" class="text-gray-500 underline">Reset</a>
                </form>
            </div>

            <div class="mb-4">
                <a href="{{ route('pemeriksaan.create') }}" class="bg-green-600 text-white px-4 py-2 rounded shadow">+ Input Pemeriksaan Baru</a>
            </div>

            <div class="bg-white p-6 shadow rounded-lg overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="p-3">Tanggal</th>
                            <th class="p-3">Lokasi</th>
                            <th class="p-3">Petugas</th>
                            <th class="p-3">Jentik</th>
                            <th class="p-3">Status Akhir</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pemeriksaans as $p)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">{{ $p->tanggal_pemeriksaan }}</td>
                            <td class="p-3">{{ $p->titikRisiko->nama_titik ?? 'N/A' }}</td>
                            <td class="p-3">{{ $p->petugas->name ?? 'N/A' }}</td>
                            <td class="p-3">{{ $p->ditemukan_jentik ? 'Ya' : 'Tidak' }}</td>
                            <td class="p-3">
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                    {{ $p->status_akhir == 'aman' ? 'bg-green-100 text-green-800' : 
                                       ($p->status_akhir == 'perlu pemantauan' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $p->status_akhir }}
                                </span>
                            </td>
                            <td class="p-3">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('pemeriksaan.edit', $p->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</a>
                                    <form action="{{ route('pemeriksaan.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus data pemeriksaan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-500">Tidak ada data yang ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>