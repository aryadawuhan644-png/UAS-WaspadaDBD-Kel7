<x-app-layout>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <div class="py-12">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-sm">
            <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Tambah Titik Risiko Baru</h2>
            
            <form action="{{ route('titik-risiko.store') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label class="block font-medium mb-1">Nama Titik</label>
                    <input type="text" name="nama_titik" class="w-full border-gray-300 rounded-md focus:ring-blue-500" required>
                </div>
                
                <div class="mb-4">
                    <label class="block font-medium mb-1">Alamat</label>
                    <textarea name="alamat" class="w-full border-gray-300 rounded-md focus:ring-blue-500" rows="3" required></textarea>
                </div>
                
                <div class="mb-4">
                    <label class="block font-medium mb-1">RT/RW</label>
                    <input type="text" name="rt_rw" class="w-full border-gray-300 rounded-md focus:ring-blue-500" placeholder="Contoh: 01/05" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Jenis Risiko</label>
                        <select name="jenis_risiko" class="w-full border-gray-300 rounded-md focus:ring-blue-500" required>
                            <option value="genangan">Genangan</option>
                            <option value="barang bekas">Barang Bekas</option>
                            <option value="saluran air">Saluran Air</option>
                            <option value="tempat sampah">Tempat Sampah</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Level Risiko</label>
                        <select name="level_risiko_awal" class="w-full border-gray-300 rounded-md focus:ring-blue-500" required>
                            <option value="rendah">Rendah</option>
                            <option value="sedang">Sedang</option>
                            <option value="tinggi">Tinggi</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4 mt-2">
                    <label class="block font-medium mb-1">Tentukan Lokasi di Peta</label>
                    <p class="text-xs text-gray-500 mb-2">Klik pada area peta di bawah ini untuk menandai lokasi. Latitude dan Longitude akan terisi otomatis.</p>
                    
                    <div id="map" class="w-full h-72 rounded-md border border-gray-300 shadow-inner z-0"></div>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block font-medium mb-1">Latitude</label>
                        <input type="text" id="latitude" name="latitude" class="w-full border-gray-300 rounded-md bg-gray-50" placeholder="-7.983908" readonly required />
                    </div>
                    <div>
                        <label class="block font-medium mb-1">Longitude</label>
                        <input type="text" id="longitude" name="longitude" class="w-full border-gray-300 rounded-md bg-gray-50" placeholder="112.621391" readonly required />
                    </div>
                </div>

                <div class="mb-4 mt-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="status_aktif" class="form-checkbox" checked>
                        <span class="ml-2">Status Aktif</span>
                    </label>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-md transition mt-4">
                    Simpan Data
                </button>
            </form>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set lokasi awal ke Malang (koordinat umum)
            var initialLat = -7.983908;
            var initialLng = 112.621391;

            // Inisialisasi peta
            var map = L.map('map').setView([initialLat, initialLng], 13);

            // Load Tile (Gambar Peta) dari OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            var marker;

            // Event saat Admin klik di area peta
            map.on('click', function(e) {
                var lat = e.latlng.lat;
                var lng = e.latlng.lng;

                // Hapus pin lama jika Admin klik tempat lain
                if (marker) {
                    map.removeLayer(marker);
                }

                // Tambahkan pin baru di lokasi yang diklik
                marker = L.marker([lat, lng]).addTo(map);

                // Masukkan nilai koordinat ke dalam input form
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
            });
        });
    </script>
</x-app-layout>