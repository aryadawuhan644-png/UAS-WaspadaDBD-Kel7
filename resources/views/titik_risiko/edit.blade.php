<x-app-layout>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <div class="py-12">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-sm border border-gray-100">
            <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Edit Titik Risiko</h2>
            
            <form action="{{ route('titik-risiko.update', $titik->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="block font-medium mb-1">Nama Titik</label>
                    <input type="text" name="nama_titik" value="{{ $titik->nama_titik }}" class="w-full border-gray-300 rounded-md focus:ring-blue-500" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">Provinsi</label>
                    <select name="provinsi" id="provinsi" class="w-full border-gray-300 rounded-md focus:ring-blue-500" required>
                        <option value="">-- Pilih Provinsi --</option>
                        @foreach($provinces as $p)
                            <option value="{{ $p->id }}" {{ ($currentProvinsi && $currentProvinsi->id == $p->id) ? 'selected' : '' }}>
                                {{ $p->name }}
                            </option>
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
                    <textarea name="alamat" class="w-full border-gray-300 rounded-md focus:ring-blue-500" rows="3" required>{{ $titik->alamat }}</textarea>
                </div>
                
                <div class="mb-4">
                    <label class="block font-medium mb-1">RT/RW</label>
                    <input type="text" name="rt_rw" value="{{ $titik->rt_rw }}" class="w-full border-gray-300 rounded-md focus:ring-blue-500" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Jenis Risiko</label>
                        <select name="jenis_risiko" class="w-full border-gray-300 rounded-md focus:ring-blue-500">
                            @foreach(['genangan', 'barang bekas', 'saluran air', 'tempat sampah'] as $opsi)
                                <option value="{{ $opsi }}" {{ $titik->jenis_risiko == $opsi ? 'selected' : '' }}>
                                    {{ ucfirst($opsi) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Level Risiko</label>
                        <select name="level_risiko_awal" class="w-full border-gray-300 rounded-md focus:ring-blue-500">
                            @foreach(['rendah', 'sedang', 'tinggi'] as $level)
                                <option value="{{ $level }}" {{ $titik->level_risiko_awal == $level ? 'selected' : '' }}>
                                    {{ ucfirst($level) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-4 mt-4">
                    <label class="block font-medium mb-1">Pilih Titik Lokasi di Peta</label>
                    <div id="map" class="w-full h-64 rounded-md border border-gray-300 z-10"></div>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block font-medium mb-1">Latitude</label>
                        <input type="text" name="latitude" id="latitude" value="{{ $titik->latitude }}" class="w-full border-gray-300 rounded-md bg-gray-50" readonly />
                    </div>
                    <div>
                        <label class="block font-medium mb-1">Longitude</label>
                        <input type="text" name="longitude" id="longitude" value="{{ $titik->longitude }}" class="w-full border-gray-300 rounded-md bg-gray-50" readonly />
                    </div>
                </div>

                <div class="mb-4 mt-4">
                    <label class="block font-medium mb-1">Foto Kondisi Awal</label>
                    @if($titik->foto_awal)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $titik->foto_awal) }}" class="w-32 h-32 object-cover rounded border" alt="Foto Awal">
                        </div>
                    @endif
                    <input type="file" name="foto_awal" accept="image/*" class="w-full border-gray-300 rounded-md p-2 bg-gray-50">
                    <p class="text-xs text-gray-500 mt-1">Unggah ulang hanya jika ingin mengganti foto awal.</p>
                </div>

                <div class="mb-4 mt-4">
                    <label class="inline-flex items-center">
                        <input type="hidden" name="status_aktif" value="0">
                        <input type="checkbox" name="status_aktif" class="form-checkbox" {{ $titik->status_aktif ? 'checked' : '' }}>
                        <span class="ml-2">Status Aktif</span>
                    </label>
                </div>

                <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 rounded-md transition">
                    Update Data
                </button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // --- LOGIKA PETA LEAFLET ---
        var oldLat = "{{ $titik->latitude ?? -8.1325 }}";
        var oldLng = "{{ $titik->longitude ?? 112.5714 }}";

        var map = L.map('map').setView([oldLat, oldLng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var marker;

        if ("{{ $titik->latitude }}" !== "") {
            marker = L.marker([oldLat, oldLng]).addTo(map);
        }

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
            $.getJSON('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(queryPencarian), function(data) {
                if (data.length > 0) {
                    var lat = data[0].lat;
                    var lon = data[0].lon;
                    map.setView([lat, lon], zoomLevel); 
                }
            });
        }

        // --- LOGIKA AJAX WILAYAH ---
        $(document).ready(function () {
            let oldProvId = "{{ $currentProvinsi->id ?? '' }}";
            let oldKabId  = "{{ $currentKabupaten->id ?? '' }}";
            let oldKecId  = "{{ $currentKecamatan->id ?? '' }}";

            if (oldProvId) {
                loadKabupaten(oldProvId, oldKabId);
            }
            if (oldKabId) {
                loadKecamatan(oldKabId, oldKecId);
            }

            // Saat Provinsi Diubah Manual
            $('#provinsi').on('change', function () {
                let provId = $(this).val();
                let provName = $("#provinsi option:selected").text().trim();
                
                if (provId) cariLokasiMap(provName + ", Indonesia", 7);
                
                loadKabupaten(provId, null);
                $('#kecamatan').empty().append('<option value="">-- Pilih Kecamatan --</option>');
            });

            // Saat Kabupaten Diubah Manual
            $('#kabupaten').on('change', function () {
                let regId = $(this).val();
                let provName = $("#provinsi option:selected").text().trim();
                let kabName = $("#kabupaten option:selected").text().trim();
                
                if (regId) cariLokasiMap(kabName + ", " + provName + ", Indonesia", 11);
                
                loadKecamatan(regId, null);
            });

            // Saat Kecamatan Diubah Manual
            $('#kecamatan').on('change', function() {
                let provName = $("#provinsi option:selected").text().trim();
                let kabName = $("#kabupaten option:selected").text().trim();
                let kecName = $("#kecamatan option:selected").text().trim();
                
                if ($(this).val()) cariLokasiMap(kecName + ", " + kabName + ", " + provName + ", Indonesia", 14);
            });

            function loadKabupaten(provId, selectedId) {
                if (!provId) return;
                $('#kabupaten').empty().append('<option value="">Loading...</option>');
                
                let urlKabupaten = "{{ url('get-kabupaten') }}/" + provId;
                $.get(urlKabupaten, function (data) {
                    $('#kabupaten').empty().append('<option value="">-- Pilih Kabupaten/Kota --</option>');
                    data.forEach(function (item) {
                        let selected = (selectedId && selectedId == item.id) ? 'selected' : '';
                        $('#kabupaten').append(`<option value="${item.id}" ${selected}>${item.name}</option>`);
                    });
                });
            }

            function loadKecamatan(regId, selectedId) {
                if (!regId) return;
                $('#kecamatan').empty().append('<option value="">Loading...</option>');
                
                let urlKecamatan = "{{ url('get-kecamatan') }}/" + regId;
                $.get(urlKecamatan, function (data) {
                    $('#kecamatan').empty().append('<option value="">-- Pilih Kecamatan --</option>');
                    data.forEach(function (item) {
                        let selected = (selectedId && selectedId == item.id) ? 'selected' : '';
                        $('#kecamatan').append(`<option value="${item.id}" ${selected}>${item.name}</option>`);
                    });
                });
            }
        });
    </script>
</x-app-layout>