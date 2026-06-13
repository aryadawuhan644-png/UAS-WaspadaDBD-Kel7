<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-sm">
            <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Edit Titik Risiko</h2>
            
            <form action="{{ route('titik-risiko.update', $titik->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="block font-medium mb-1">Nama Titik</label>
                    <input type="text" name="nama_titik" value="{{ $titik->nama_titik }}" class="w-full border-gray-300 rounded-md focus:ring-blue-500" required>
                </div>
                
                <div class="mb-4">
                    <label class="block font-medium mb-1">Alamat</label>
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

                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block font-medium mb-1">Latitude</label>
                        <input type="text" name="latitude" value="{{ $titik->latitude }}" class="w-full border-gray-300 rounded-md" />
                    </div>
                    <div>
                        <label class="block font-medium mb-1">Longitude</label>
                        <input type="text" name="longitude" value="{{ $titik->longitude }}" class="w-full border-gray-300 rounded-md" />
                    </div>
                </div>

                <div class="mb-4 mt-4">
                    <label class="inline-flex items-center">
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
</x-app-layout>