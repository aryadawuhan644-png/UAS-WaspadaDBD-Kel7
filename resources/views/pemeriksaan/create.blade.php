<x-app-layout>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 bg-white p-8 shadow-sm rounded-xl">
            <h2 class="text-2xl font-bold mb-2 text-gray-800">Form Pemeriksaan Baru</h2>
            <p class="text-sm text-gray-500 mb-6 italic">Input hasil pemeriksaan untuk lokasi target di bawah ini:</p>

            <div class="mb-8 p-6 bg-blue-50 border border-blue-100 rounded-xl flex flex-col md:flex-row gap-8 shadow-sm">
                
                <div class="flex-1 w-full flex flex-col justify-between">
                    <div>
                        <p class="text-xs text-blue-600 font-bold uppercase tracking-wider mb-2">Target Pemeriksaan</p>
                        <p class="text-2xl font-bold text-gray-800 mb-1">{{ $titik->nama_titik }}</p>
                        <p class="text-sm text-gray-600 mb-3">{{ $titik->alamat }} <span class="mx-2 text-gray-300">|</span> <span class="font-medium">{{ $titik->rt_rw }}</span></p>
                        <span class="bg-blue-200 text-blue-800 text-xs px-3 py-1.5 rounded-md font-bold uppercase tracking-wide inline-block mb-4">
                            {{ $titik->jenis_risiko ?? 'Titik Risiko' }}
                        </span>
                    </div>

                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase mb-2">Foto Kondisi Awal (Referensi):</p>
                        @if($titik->foto_awal)
                            <img src="{{ asset('storage/' . $titik->foto_awal) }}" alt="Foto Awal" class="w-full md:max-w-xs h-32 object-cover rounded-lg border-2 border-white shadow-sm hover:scale-105 transition duration-300 cursor-pointer">
                        @else
                            <div class="w-full md:max-w-xs h-32 bg-blue-100/50 flex flex-col items-center justify-center rounded-lg border-2 border-dashed border-blue-200">
                                <svg class="w-6 h-6 text-blue-300 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="text-xs text-blue-400 font-medium">Tidak ada foto awal</span>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="w-full md:w-1/2 h-64 md:h-auto min-h-[250px] rounded-lg border-2 border-white shadow-md overflow-hidden z-0" id="map-petugas">
                    </div>
            </div>
            
            <form action="{{ route('pemeriksaan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="titik_risiko_id" value="{{ $titik->id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pemeriksaan</label>
                        <input type="date" name="tanggal_pemeriksaan" value="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-gray-50" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ditemukan Jentik?</label>
                        <select name="ditemukan_jentik" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="0">Tidak</option>
                            <option value="1">Ya</option>
                        </select>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kondisi Lingkungan</label>
                    <textarea name="kondisi_lingkungan" rows="3" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Jelaskan kondisi lokasi saat diperiksa..." required></textarea>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tindakan Dilakukan</label>
                    <textarea name="tindakan_dilakukan" rows="3" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Apa yang dilakukan petugas?" required></textarea>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto Kondisi Akhir (Bukti Pemeriksaan)</label>
                    <input type="file" name="foto" accept="image/*" class="w-full border-gray-300 rounded-lg p-2 bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Unggah foto terbaru setelah pemeriksaan. Maksimal ukuran 2MB.</p>
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Akhir</label>
                    <select name="status_akhir" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-gray-50">
                        <option value="aman">Aman</option>
                        <option value="perlu pemantauan">Perlu Pemantauan</option>
                        <option value="perlu tindakan">Perlu Tindakan</option>
                    </select>
                </div>

                <div class="flex justify-end border-t pt-6">
                    <a href="{{ route('dashboard') }}" class="mr-4 text-gray-500 hover:text-gray-800 py-2.5 px-4 font-medium transition">Batal</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-lg font-bold shadow-sm transition">
                        Simpan Pemeriksaan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var lat = {{ $titik->latitude ?? -7.983908 }};
            var lng = {{ $titik->longitude ?? 112.621391 }};

            var mapPetugas = L.map('map-petugas').setView([lat, lng], 16);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(mapPetugas);

            L.marker([lat, lng]).addTo(mapPetugas)
                .bindPopup("<div class='text-center'><b>{{ $titik->nama_titik }}</b><br><span class='text-xs text-gray-500'>Lokasi Target</span></div>")
                .openPopup();
        });
    </script>
</x-app-layout>