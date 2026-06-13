<x-app-layout>
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

                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block font-medium mb-1">Latitude</label>
                        <input type="text" name="latitude" class="w-full border-gray-300 rounded-md" placeholder="-7.99" />
                    </div>
                    <div>
                        <label class="block font-medium mb-1">Longitude</label>
                        <input type="text" name="longitude" class="w-full border-gray-300 rounded-md" placeholder="112.62" />
                    </div>
                </div>

                <div class="mb-4 mt-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="status_aktif" class="form-checkbox" checked>
                        <span class="ml-2">Status Aktif</span>
                    </label>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-md transition">
                    Simpan Data
                </button>
            </form>
        </div>
    </div>
</x-app-layout>