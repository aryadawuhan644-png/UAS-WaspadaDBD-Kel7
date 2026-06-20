<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Riwayat Pemeriksaan') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(auth()->user()->role === 'admin')
                
                <div class="bg-white p-6 rounded-2xl shadow-sm mb-8 border border-gray-100">
                    <div class="mb-4">
                        <h3 class="text-lg font-bold text-gray-800">Filter Riwayat</h3>
                        <p class="text-sm text-gray-500">Pilih bulan dan lokasi wilayah untuk melihat riwayat.</p>
                    </div>
                    <form method="GET" action="{{ route('pemeriksaan.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-3 items-end">
                        <input type="month" name="bulan" value="{{ $filterBulan }}" class="border-gray-300 rounded-lg focus:ring-blue-500 text-gray-700 font-medium">
                        
                        <select name="provinsi" id="provinsi" class="border-gray-300 rounded-lg text-sm">
                            <option value="">-- Provinsi --</option>
                            @foreach($provinces as $prov)
                                <option value="{{ $prov->name }}" {{ request('provinsi') == $prov->name ? 'selected' : '' }}>{{ $prov->name }}</option>
                            @endforeach
                        </select>
                        <select name="kabupaten_kota" id="kabupaten_kota" class="border-gray-300 rounded-lg text-sm">
                            <option value="{{ request('kabupaten_kota') }}">{{ request('kabupaten_kota') ?: '-- Pilih Kota/Kab --' }}</option>
                        </select>
                        <select name="kecamatan" id="kecamatan" class="border-gray-300 rounded-lg text-sm">
                            <option value="{{ request('kecamatan') }}">{{ request('kecamatan') ?: '-- Pilih Kecamatan --' }}</option>
                        </select>

                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-bold transition shadow-sm">Tampilkan</button>
                    </form>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($pemeriksaans as $p)
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition flex flex-col justify-between">
                            <div>
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
                                
                                <p class="text-sm text-gray-600 flex items-center gap-2 mb-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    Petugas: <span class="font-semibold">{{ $p->petugas->name ?? 'N/A' }}</span>
                                </p>
                                
                                <p class="text-sm text-gray-600 mb-4 flex items-start gap-2">
                                    <svg class="w-4 h-4 text-gray-400 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                    <span class="font-semibold text-xs">
                                        {{ $p->titikRisiko->kecamatan ?? 'N/A' }}, {{ $p->titikRisiko->kabupaten_kota ?? 'N/A' }}, {{ $p->titikRisiko->provinsi ?? 'N/A' }}
                                    </span>
                                </p>

                                <div class="mt-2 mb-4 p-3 rounded-lg border-l-4 bg-gray-50 {{ $p->warna_risiko == 'red' ? 'border-red-500' : ($p->warna_risiko == 'yellow' ? 'border-yellow-500' : 'border-green-500') }}">
                                    <div class="flex justify-between items-center">
                                        <p class="text-[10px] font-bold text-gray-400 uppercase">Skor Risiko: 
                                            <span class="text-lg font-black {{ $p->warna_risiko == 'red' ? 'text-red-600' : ($p->warna_risiko == 'yellow' ? 'text-yellow-600' : 'text-green-600') }}">
                                                {{ $p->skor_risiko }}
                                            </span>
                                        </p>
                                        <span class="px-2 py-1 rounded-full text-[9px] font-bold uppercase {{ $p->warna_risiko == 'red' ? 'bg-red-100 text-red-700' : ($p->warna_risiko == 'yellow' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">
                                            Risiko {{ $p->level_risiko }}
                                        </span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-2 mb-4">
                                    <div class="text-center">
                                        <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Foto Awal</p>
                                        @if($p->titikRisiko && $p->titikRisiko->foto_awal)
                                            <img src="{{ asset('storage/' . $p->titikRisiko->foto_awal) }}" class="w-full h-24 object-cover rounded-lg border shadow-sm">
                                        @else
                                            <div class="w-full h-24 bg-gray-100 text-gray-400 text-xs flex items-center justify-center rounded-lg border border-dashed">No Image</div>
                                        @endif
                                    </div>
                                    <div class="text-center">
                                        <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Foto Akhir</p>
                                        @if($p->foto)
                                            <img src="{{ asset('storage/' . $p->foto) }}" class="w-full h-24 object-cover rounded-lg border shadow-sm">
                                        @else
                                            <div class="w-full h-24 bg-gray-100 text-gray-400 text-xs flex items-center justify-center rounded-lg border border-dashed">No Image</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="bg-gray-50 p-3 rounded-lg mb-5 border border-gray-100 flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-600">Ditemukan Jentik?</span>
                                    <span class="font-bold {{ $p->ditemukan_jentik ? 'text-red-600' : 'text-green-600' }}">
                                        {{ $p->ditemukan_jentik ? 'Ya, Ada' : 'Tidak Ada' }}
                                    </span>
                                </div>
                            </div>

                            <a href="{{ route('pemeriksaan.show', $p->id) }}" class="block w-full text-center border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white font-bold py-2 rounded-lg transition">
                                Lihat Detail
                            </a>
                        </div>
                    @empty
                        <div class="col-span-full p-8 text-center bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                            <p class="text-gray-500 font-medium">Belum ada riwayat pemeriksaan.</p>
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
                        &larr; Kembali ke Dashboard
                    </a>
                </div>

                <div class="bg-white p-6 shadow rounded-lg overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="p-3">Tanggal</th>
                                <th class="p-3">Lokasi</th>
                                <th class="p-3">Skor</th>
                                <th class="p-3">Level</th>
                                <th class="p-3">Status</th>
                                <th class="p-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pemeriksaans as $p)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3 text-sm">{{ $p->tanggal_pemeriksaan->format('d/m/y') }}</td>
                                <td class="p-3 font-bold text-sm">{{ $p->titikRisiko->nama_titik ?? 'N/A' }}</td>
                                <td class="p-3 font-bold {{ $p->warna_risiko == 'red' ? 'text-red-600' : ($p->warna_risiko == 'yellow' ? 'text-yellow-600' : 'text-green-600') }}">
                                    {{ $p->skor_risiko }}
                                </td>
                                <td class="p-3">
                                    <span class="px-2 py-1 rounded-full text-[9px] font-bold uppercase {{ $p->warna_risiko == 'red' ? 'bg-red-100 text-red-700' : ($p->warna_risiko == 'yellow' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">
                                        {{ $p->level_risiko }}
                                    </span>
                                </td>
                                <td class="p-3">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ $p->status_akhir == 'aman' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $p->status_akhir }}
                                    </span>
                                </td>
                                <td class="p-3">
                                    <a href="{{ route('pemeriksaan.edit', $p->id) }}" class="bg-yellow-500 text-white px-2 py-1 rounded text-xs">Edit</a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="p-8 text-center text-gray-500">Tidak ada data ditemukan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            @endif
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#provinsi').on('change', function() {
                var provVal = $(this).val();
                if(provVal) {
                    $.ajax({
                        url: '/get-kabupaten/' + provVal, 
                        type: 'GET',
                        success: function(data) {
                            $('#kabupaten_kota').empty().append('<option value="">-- Pilih Kota/Kab --</option>');
                            $('#kecamatan').empty().append('<option value="">-- Pilih Kecamatan --</option>');
                            $.each(data, function(key, value) {
                                $('#kabupaten_kota').append('<option value="'+ value.name +'">'+ value.name +'</option>');
                            });
                        }
                    });
                }
            });

            $('#kabupaten_kota').on('change', function() {
                var cityVal = $(this).val();
                if(cityVal) {
                    $.ajax({
                        url: '/get-kecamatan/' + cityVal, 
                        type: 'GET',
                        success: function(data) {
                            $('#kecamatan').empty().append('<option value="">-- Pilih Kecamatan --</option>');
                            $.each(data, function(key, value) {
                                $('#kecamatan').append('<option value="'+ value.name +'">'+ value.name +'</option>');
                            });
                        }
                    });
                }
            });
        });
    </script>
</x-app-layout>