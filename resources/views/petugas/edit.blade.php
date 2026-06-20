<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4">
            <h2 class="text-2xl font-bold mb-6">Edit Data Pengguna</h2>
            
            <form action="{{ route('petugas.update', $user->id) }}" method="POST" class="bg-white p-8 rounded-lg shadow-sm border border-gray-200">
                @csrf @method('PUT')
                
                <div class="mb-4">
                    <label class="block font-medium">Role</label>
                    <select name="role" id="role" onchange="toggleWilayah()" class="w-full mt-1 border-gray-300 rounded-lg">
                        <option value="petugas" {{ $user->role == 'petugas' ? 'selected' : '' }}>Petugas</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Nama</label>
                    <input type="text" name="name" value="{{ $user->name }}" class="w-full mt-1 border-gray-300 rounded-lg" required>
                </div>

                <div class="mb-4">
    <label class="block font-medium">Email</label>
    <input type="email" name="email" value="{{ $user->email }}" class="w-full mt-1 border-gray-300 rounded-lg" required>
</div>

                <div class="mb-4">
    <label class="block font-medium">Password Baru (Kosongkan jika tidak ingin diubah)</label>
    <input type="password" name="password" class="w-full mt-1 border-gray-300 rounded-lg">
</div>

                <div id="wilayah-container" class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label class="block font-medium">Provinsi</label>
                        <select name="provinsi" id="provinsi" class="w-full mt-1 border-gray-300 rounded-lg">
                            <option value="">-- Pilih --</option>
                            @foreach($provinces as $p) 
                                <option value="{{ $p->id }}" {{ ($petugas && $petugas->provinsi == $p->id) ? 'selected' : '' }}>{{ $p->name }}</option> 
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block font-medium">Kabupaten</label>
                        <select name="kabupaten_kota" id="kabupaten" class="w-full mt-1 border-gray-300 rounded-lg"></select>
                    </div>
                    <div>
                        <label class="block font-medium">Kecamatan</label>
                        <select name="kecamatan" id="kecamatan" class="w-full mt-1 border-gray-300 rounded-lg"></select>
                    </div>
                </div>

                <button type="submit" class="bg-yellow-500 text-white px-6 py-2 rounded-lg font-bold hover:bg-yellow-600">Update Data</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function toggleWilayah() {
            if ($('#role').val() === 'admin') {
                $('#wilayah-container').hide();
            } else {
                $('#wilayah-container').show();
            }
        }

        $(document).ready(function() {
            toggleWilayah();

            // Memuat data awal jika petugas sudah ada
            @if($petugas)
                // Trigger loading kabupaten dan kecamatan saat halaman dimuat
                $.get("{{ url('get-kabupaten') }}/{{ $petugas->provinsi }}", function(data) {
                    $('#kabupaten').empty().append('<option value="">-- Pilih --</option>');
                    data.forEach(i => {
                        let selected = i.id == {{ $petugas->kabupaten_kota }} ? 'selected' : '';
                        $('#kabupaten').append(`<option value="${i.id}" ${selected}>${i.name}</option>`);
                    });
                    $('#kabupaten').trigger('change');
                });
                
                // Load kecamatan setelah kabupaten terpilih
                $('#kabupaten').on('change', function() {
                    $.get("{{ url('get-kecamatan') }}/" + $(this).val(), function(data) {
                        $('#kecamatan').empty().append('<option value="">-- Pilih --</option>');
                        data.forEach(i => {
                            let selected = i.id == {{ $petugas->kecamatan }} ? 'selected' : '';
                            $('#kecamatan').append(`<option value="${i.id}" ${selected}>${i.name}</option>`);
                        });
                    });
                });
            @endif

            $('#provinsi').on('change', function() {
                $.get("{{ url('get-kabupaten') }}/" + $(this).val(), function(data) {
                    $('#kabupaten').empty().append('<option value="">-- Pilih --</option>');
                    data.forEach(i => $('#kabupaten').append(`<option value="${i.id}">${i.name}</option>`));
                });
            });

            $('#kabupaten').on('change', function() {
                $.get("{{ url('get-kecamatan') }}/" + $(this).val(), function(data) {
                    $('#kecamatan').empty().append('<option value="">-- Pilih --</option>');
                    data.forEach(i => $('#kecamatan').append(`<option value="${i.id}">${i.name}</option>`));
                });
            });
        });
    </script>
</x-app-layout>