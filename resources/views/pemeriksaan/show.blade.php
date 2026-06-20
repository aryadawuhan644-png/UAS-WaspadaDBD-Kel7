<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Pemeriksaan Lapangan') }}
            </h2>
            <a href="{{ route('pemeriksaan.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm border border-gray-200">
                &larr; Kembali ke Riwayat
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-10 mb-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-blue-50 rounded-full opacity-50"></div>
                
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center relative z-10">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <span class="bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                                {{ \Carbon\Carbon::parse($pemeriksaan->tanggal_pemeriksaan)->isoFormat('dddd, D MMMM Y') }}
                            </span>
                        </div>
                        <h1 class="text-3xl font-extrabold text-gray-900 mb-1">
                            {{ $pemeriksaan->titikRisiko->nama_titik ?? 'Lokasi Dihapus' }}
                        </h1>
                        <p class="text-gray-500 font-medium flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            Lihat detail wilayah pada card di bawah
                        </p>
                    </div>

                    @php
                        $bgStatus = 'bg-green-50 border-green-200 text-green-700';
                        $iconStatus = '<svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                        
                        if($pemeriksaan->status_akhir == 'perlu pemantauan') {
                            $bgStatus = 'bg-yellow-50 border-yellow-200 text-yellow-700';
                            $iconStatus = '<svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                        } elseif($pemeriksaan->status_akhir == 'perlu tindakan') {
                            $bgStatus = 'bg-red-50 border-red-200 text-red-700';
                            $iconStatus = '<svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                        }
                    @endphp

                    <div class="mt-6 md:mt-0 px-6 py-4 rounded-xl border {{ $bgStatus }} flex items-center gap-4 shadow-sm">
                        {!! $iconStatus !!}
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider mb-0.5 opacity-80">Status Akhir</p>
                            <p class="text-lg font-bold capitalize">{{ $pemeriksaan->status_akhir }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-6">
                    
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            <h3 class="font-bold text-gray-800 text-lg">Hasil Observasi Lapangan</h3>
                        </div>
                        <div class="p-6">
                            
                            <div class="mb-6 p-4 rounded-xl border {{ $pemeriksaan->ditemukan_jentik ? 'bg-red-50 border-red-200' : 'bg-green-50 border-green-200' }} flex justify-between items-center">
                                <span class="font-bold text-gray-700">Ditemukan Jentik Nyamuk?</span>
                                <span class="text-lg font-extrabold {{ $pemeriksaan->ditemukan_jentik ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $pemeriksaan->ditemukan_jentik ? 'YA, DITEMUKAN' : 'TIDAK DITEMUKAN' }}
                                </span>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Kondisi Lingkungan</h4>
                                    <p class="text-gray-800 bg-gray-50 p-4 rounded-lg leading-relaxed border border-gray-100">
                                        {{ $pemeriksaan->kondisi_lingkungan ?? 'Tidak ada catatan kondisi lingkungan.' }}
                                    </p>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Tindakan Yang Dilakukan</h4>
                                    <p class="text-gray-800 bg-gray-50 p-4 rounded-lg leading-relaxed border border-gray-100">
                                        {{ $pemeriksaan->tindakan_dilakukan ?? 'Tidak ada tindakan yang dicatat.' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <h3 class="font-bold text-gray-800 text-lg">Informasi Lokasi & Wilayah</h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Kecamatan</p>
                                    <p class="text-gray-800 font-bold text-base">{{ $pemeriksaan->titikRisiko->kecamatan ?? '-' }}</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Kabupaten / Kota</p>
                                    <p class="text-gray-800 font-bold text-base">{{ $pemeriksaan->titikRisiko->kabupaten_kota ?? '-' }}</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Provinsi</p>
                                    <p class="text-gray-800 font-bold text-base">{{ $pemeriksaan->titikRisiko->provinsi ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex items-center p-6 gap-4">
                        <div class="bg-blue-100 p-3 rounded-full text-blue-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-400 uppercase tracking-wider">Petugas Pemeriksa</p>
                            <p class="text-lg font-bold text-gray-800">{{ $pemeriksaan->petugas->name ?? 'Petugas Tidak Diketahui' }}</p>
                        </div>
                    </div>

                </div>

                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-6">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <h3 class="font-bold text-gray-800 text-lg">Dokumentasi</h3>
                        </div>
                        <div class="p-6 space-y-6">
                            
                            <div>
                                <p class="text-sm font-bold text-gray-500 mb-2 flex justify-between">
                                    <span>Foto Awal (Data Titik)</span>
                                </p>
                                @if($pemeriksaan->titikRisiko && $pemeriksaan->titikRisiko->foto_awal)
                                    <a href="{{ asset('storage/' . $pemeriksaan->titikRisiko->foto_awal) }}" target="_blank" class="block overflow-hidden rounded-xl border border-gray-200 shadow-sm hover:opacity-90 transition">
                                        <img src="{{ asset('storage/' . $pemeriksaan->titikRisiko->foto_awal) }}" alt="Foto Awal" class="w-full h-48 object-cover">
                                    </a>
                                @else
                                    <div class="w-full h-48 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200 flex flex-col items-center justify-center text-gray-400">
                                        <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span class="text-sm font-medium">Tidak Ada Foto</span>
                                    </div>
                                @endif
                            </div>

                            <hr class="border-gray-100">

                            <div>
                                <p class="text-sm font-bold text-gray-500 mb-2 flex justify-between">
                                    <span>Foto Pemeriksaan (Akhir)</span>
                                </p>
                                @if($pemeriksaan->foto)
                                    <a href="{{ asset('storage/' . $pemeriksaan->foto) }}" target="_blank" class="block overflow-hidden rounded-xl border border-gray-200 shadow-sm hover:opacity-90 transition">
                                        <img src="{{ asset('storage/' . $pemeriksaan->foto) }}" alt="Foto Pemeriksaan" class="w-full h-48 object-cover">
                                    </a>
                                @else
                                    <div class="w-full h-48 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200 flex flex-col items-center justify-center text-gray-400">
                                        <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span class="text-sm font-medium">Tidak Ada Foto</span>
                                    </div>
                                @endif
                            </div>

                            <p class="text-xs text-center text-gray-400 mt-2 italic">*Klik pada gambar untuk memperbesar</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>