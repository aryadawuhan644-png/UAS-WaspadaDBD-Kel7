<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Riwayat Pemeriksaan') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(auth()->user()->role === 'admin')
                
                <div class="bg-white p-6 rounded-2xl shadow-sm mb-8 border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Filter Riwayat</h3>
                        <p class="text-sm text-gray-500">Pilih bulan untuk melihat riwayat pemeriksaan lapangan.</p>
                    </div>
                    <form method="GET" action="{{ route('pemeriksaan.index') }}" class="flex items-center gap-3">
                        <input type="month" name="bulan" value="{{ $filterBulan }}" class="border-gray-300 rounded-lg focus:ring-blue-500 text-gray-700 font-medium">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-bold transition shadow-sm">Tampilkan</button>
                    </form>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($pemeriksaans as $p)
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-xs font-bold text-gray-400 uppercase">{{ \Carbon\Carbon::parse($p->tanggal_pemeriksaan)->format('d M Y') }}</span>
                                @php
                                    $bgStatus = 'bg-green-100 text-green-800';
                                    if($p->status_akhir == 'perlu pemantauan') $bgStatus = 'bg-yellow-100 text-yellow-800';
                                    elseif($p->status_akhir == 'perlu tindakan') $bgStatus = 'bg-red-100 text-red-800';
                                @endphp
                                <span class="px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wide {{ $bgStatus }}">
                                    {{ $p->status_akhir }}
                                </span>
                            </div>

                            <h3 class="font-bold text-xl text-gray-800 mb-1 line-clamp-1" title="{{ $p->titikRisiko->nama_titik ?? 'N/A' }}">
                                {{ $p->titikRisiko->nama_titik ?? 'Lokasi Dihapus' }}
                            </h3>
                            <p class="text-sm text-gray-600 mb-5 flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Petugas: <span class="font-semibold">{{ $p->petugas->name ?? 'N/A' }}</span>
                            </p>

                            <div class="bg-gray-50 p-3 rounded-lg mb-5 border border-gray-100 flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-600">Ditemukan Jentik?</span>
                                <span class="font-bold {{ $p->ditemukan_jentik ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $p->ditemukan_jentik ? 'Ya, Ada' : 'Tidak Ada' }}
                                </span>
                            </div>

                            <a href="{{ route('pemeriksaan.show', $p->id) }}" class="block w-full text-center border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white font-bold py-2 rounded-lg transition">
                                Lihat Detail
                            </a>
                        </div>
                    @empty
                        <div class="col-span-full p-8 text-center bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                            <p class="text-gray-500 font-medium">Belum ada riwayat pemeriksaan pada bulan ini.</p>
                        </div>
                    @endforelse
                </div>

            @else
                
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
                    <a href="{{ route('dashboard') }}" class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 transition">
                        &larr; Kembali ke Dashboard untuk Input Data
                    </a>
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

            @endif

        </div>
    </div>
</x-app-layout>