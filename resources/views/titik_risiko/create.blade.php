<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Tambah Titik Risiko') }}</h2>
    </x-slot>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <div class="py-12">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-sm border border-gray-100">
            
            <form action="{{ route('titik-risiko.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-4">
                    <label class="block font-medium mb-1">Nama Titik / Lokasi</label>
                    <input type="text" name="nama_titik" class="w-full border-gray-300 rounded-md focus:ring-blue-500" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">Provinsi</label>
                    <select name="provinsi" id="provinsi" class="w-full border-gray-300 rounded-md focus:ring-blue-500" required>
                        <option value="">-- Pilih Provinsi --</option>
                        @foreach($provinces as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">Kabupaten / Kota</label>
                    <select name="kabupaten_kota" id="kabupaten" class="w-full border-gray-300 rounded-md focus:ring-blue-500" required>
                        <option value="">-- Pilih Kabupaten/Kota --</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">Kecamatan</label>
                    <select name="kecamatan" id="kecamatan" class="w-full border-gray-300 rounded-md focus:ring-blue-500" required>
                        <option value="">-- Pilih Kecamatan --</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="block font-medium mb-1">Alamat Lengkap</label>
                    <textarea name="alamat" class="w-full border-gray-300 rounded-md focus:ring-blue-500" rows="3" required></textarea>
                </div>
                
                <div class="mb-4">
                    <label class="block font-medium mb-1">RT/RW</label>
                    <input type="text" name="rt_rw" class="w-full border-gray-300 rounded-md focus:ring-blue-500" required>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Jenis Risiko</label>
                        <select name="jenis_risiko" class="w-full border-gray-300 rounded-md focus:ring-blue-500" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="genangan">Genangan</option>
                            <option value="barang bekas">Barang Bekas</option>
                            <option value="saluran air">Saluran Air</option>
                            <option value="tempat sampah">Tempat Sampah</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Level Risiko Awal</label>
                        <select name="level_risiko_awal" class="w-full border-gray-300 rounded-md focus:ring-blue-500" required>
                            <option value="">-- Pilih Level --</option>
                            <option value="rendah">Rendah</option>
                            <option value="sedang">Sedang</option>
                            <option value="tinggi">Tinggi</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4 mt-4">
                    <label class="block font-medium mb-1">Pilih Titik Lokasi di Peta</label>
                    <div id="map" class="w-full h-64 rounded-md border border-gray-300 z-10"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium mb-1">Latitude</label>
                        <input type="text" name="latitude" id="latitude" class="w-full border-gray-300 rounded-md bg-gray-50" readonly />
                    </div>
                    <div>
                        <label class="block font-medium mb-1">Longitude</label>
                        <input type="text" name="longitude" id="longitude" class="w-full border-gray-300 rounded-md bg-gray-50" readonly />
                    </div>
                </div>

                <div class="mb-4 mt-4">
                    <label class="block font-medium mb-1">Foto Kondisi Awal</label>
                    <input type="file" name="foto_awal" accept="image/*" class="w-full border-gray-300 rounded-md p-2 bg-gray-50">
                </div>

                <div class="mb-6 mt-4">
                    <label class="inline-flex items-center">
                        <input type="hidden" name="status_aktif" value="0">
                        <input type="checkbox" name="status_aktif" class="form-checkbox text-blue-600 rounded" value="1" checked>
                        <span class="ml-2">Status Aktif</span>
                    </label>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-lg transition shadow-sm">
                    Simpan Data Titik Risiko
                </button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // --- LOGIKA PETA LEAFLET ---
        var map = L.map('map').setView([-8.1325, 112.5714], 13); // Default awal

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var marker;

        map.on('click', function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker([lat, lng]).addTo(map);
        });

        // --- FUNGSI PENCARIAN LOKASI OTOMATIS (GEOCODING) ---
        function cariLokasiMap(queryPencarian, zoomLevel) {
            // Menggunakan API gratis dari OpenStreetMap untuk mencari koordinat berdasarkan nama wilayah
            $.getJSON('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(queryPencarian), function(data) {
                if (data.length > 0) {
                    var lat = data[0].lat;
                    var lon = data[0].lon;
                    map.setView([lat, lon], zoomLevel); // Pindahkan peta ke titik tersebut
                }
            });
        }

        // --- LOGIKA AJAX WILAYAH ---
        $(document).ready(function () {
            
            // Saat Provinsi Diubah
            $('#provinsi').on('change', function () {
                let provId = $(this).val();
                let provName = $("#provinsi option:selected").text().trim();
                
                $('#kabupaten').empty().append('<option value="">Loading...</option>');
                $('#kecamatan').empty().append('<option value="">-- Pilih Kecamatan --</option>');

                if (provId) {
                    // Geser peta ke Provinsi (Zoom level 7 agar terlihat luas)
                    cariLokasiMap(provName + ", Indonesia", 7);

                    let urlKabupaten = "{{ url('get-kabupaten') }}/" + provId;
                    $.get(urlKabupaten, function (data) {
                        $('#kabupaten').empty().append('<option value="">-- Pilih Kabupaten/Kota --</option>');
                        data.forEach(function (item) {
                            $('#kabupaten').append(`<option value="${item.id}">${item.name}</option>`);
                        });
                    });
                } else {
                    $('#kabupaten').empty().append('<option value="">-- Pilih Kabupaten/Kota --</option>');
                }
            });

            // Saat Kabupaten Diubah
            $('#kabupaten').on('change', function () {
                let regId = $(this).val();
                let provName = $("#provinsi option:selected").text().trim();
                let kabName = $("#kabupaten option:selected").text().trim();
                
                $('#kecamatan').empty().append('<option value="">Loading...</option>');

                if (regId) {
                    // Geser peta ke Kabupaten (Zoom level 11)
                    cariLokasiMap(kabName + ", " + provName + ", Indonesia", 11);

                    let urlKecamatan = "{{ url('get-kecamatan') }}/" + regId;
                    $.get(urlKecamatan, function (data) {
                        $('#kecamatan').empty().append('<option value="">-- Pilih Kecamatan --</option>');
                        data.forEach(function (item) {
                            $('#kecamatan').append(`<option value="${item.id}">${item.name}</option>`);
                        });
                    });
                } else {
                    $('#kecamatan').empty().append('<option value="">-- Pilih Kecamatan --</option>');
                }
            });

            // Saat Kecamatan Diubah
            $('#kecamatan').on('change', function() {
                let provName = $("#provinsi option:selected").text().trim();
                let kabName = $("#kabupaten option:selected").text().trim();
                let kecName = $("#kecamatan option:selected").text().trim();
                
                if ($(this).val()) {
                    // Geser peta menukik ke Kecamatan (Zoom level 14)
                    cariLokasiMap(kecName + ", " + kabName + ", " + provName + ", Indonesia", 14);
                }
            });

        });
    </script>
</x-app-layout>