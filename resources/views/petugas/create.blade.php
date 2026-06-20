<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Tambah Petugas & Akun Login</h2>
            
            <form action="{{ route('petugas.store') }}" method="POST" class="bg-white p-8 rounded-lg shadow-sm border border-gray-200">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Role</label>
                        <select name="role" id="role" onchange="toggleWilayah()" class="w-full mt-1 border-gray-300 rounded-lg" required>
                            <option value="petugas">Petugas</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="name" class="w-full mt-1 border-gray-300 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" class="w-full mt-1 border-gray-300 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" class="w-full mt-1 border-gray-300 rounded-lg" required>
                    </div>
                </div>

                <div id="wilayah-container" class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Provinsi</label>
                        <select name="provinsi" id="provinsi" class="w-full mt-1 border-gray-300 rounded-lg">
                            <option value="">-- Pilih --</option>
                            @foreach($provinces as $p) <option value="{{ $p->id }}">{{ $p->name }}</option> @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kabupaten/Kota</label>
                        <select name="kabupaten_kota" id="kabupaten" class="w-full mt-1 border-gray-300 rounded-lg"></select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kecamatan</label>
                        <select name="kecamatan" id="kecamatan" class="w-full mt-1 border-gray-300 rounded-lg"></select>
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 transition">
                    Simpan Petugas
                </button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function toggleWilayah() {
            const role = $('#role').val();
            const container = $('#wilayah-container');
            if (role === 'admin') {
                container.hide();
                container.find('select').prop('required', false);
            } else {
                container.show();
                container.find('select').prop('required', true);
            }
        }

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
    </script>
</x-app-layout>