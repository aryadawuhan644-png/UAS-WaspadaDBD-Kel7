<x-app-layout>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 bg-white p-8 shadow-sm rounded-xl">
            <h2 class="text-2xl font-bold mb-2 text-gray-800">Form Pemeriksaan Baru</h2>
            <p class="text-sm text-gray-500 mb-6 italic">Input hasil pemeriksaan untuk lokasi target di bawah ini:</p>

            <div class="mb-8 p-5 bg-blue-50 border border-blue-100 rounded-xl flex flex-col md:flex-row gap-6 items-center shadow-sm">
                <div class="flex-1 w-full">
                    <p class="text-xs text-blue-600 font-bold uppercase tracking-wider mb-2">Target Pemeriksaan</p>
                    <p class="text-2xl font-bold text-gray-800 mb-1">{{ $titik->nama_titik }}</p>
                    <p class="text-sm text-gray-600 mb-3">{{ $titik->alamat }} <span class="mx-2 text-gray-300">|</span> <span class="font-medium">{{ $titik->rt_rw }}</span></p>
                    <span class="bg-blue-200 text-blue-800 text-xs px-3 py-1.5 rounded-md font-bold uppercase tracking-wide">
                        {{ $titik->jenis_risiko ?? 'Titik Risiko' }}
                    </span>
                </div>
                
                <div class="w-full md:w-1/2 h-48 rounded-lg border-2 border-white shadow-md overflow-hidden z-0" id="map-petugas">
                    </div>
            </div>
            
            <form action="{{ route('pemeriksaan.store') }}" method="POST">
                @csrf
                
                <input type="hidden" name="titik_risiko_id" value="{{ $titik->id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pemeriksaan</label>
                        <input type="date" name="tanggal_pemeriksaan" 
                               value="{{ date('Y-m-d') }}" 
                               class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-gray-50" required>
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
            // Ambil koordinat dari database. Jika kosong, default arahkan ke titik tengah Malang (-7.983908, 112.621391)
            var lat = {{ $titik->latitude ?? -7.983908 }};
            var lng = {{ $titik->longitude ?? 112.621391 }};

            // Inisialisasi Peta (zoom level 16 agar jarak pandangnya pas untuk level jalan/RT)
            var mapPetugas = L.map('map-petugas').setView([lat, lng], 16);

            // Load Tile OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(mapPetugas);

            // Pasang Pin Marker di lokasi
            L.marker([lat, lng]).addTo(mapPetugas)
                .bindPopup("<div class='text-center'><b>{{ $titik->nama_titik }}</b><br><span class='text-xs text-gray-500'>Lokasi Target</span></div>")
                .openPopup(); // Otomatis membuka popup nama lokasi saat halaman dimuat
        });
    </script>
</x-app-layout>