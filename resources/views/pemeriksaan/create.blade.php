<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-sm">
            <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Tambah Pemeriksaan Baru</h2>
            
            <form action="{{ route('pemeriksaan.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Titik Risiko</label>
                        <select name="titik_risiko_id" class="w-full border-gray-300 rounded-md focus:ring-green-500">
                            @foreach($titikRisikos as $titik)
                                <option value="{{ $titik->id }}">{{ $titik->nama_titik }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Tanggal</label>
                        <input type="date" name="tanggal_pemeriksaan" class="w-full border-gray-300 rounded-md focus:ring-green-500" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">Kondisi Lingkungan</label>
                    <textarea name="kondisi_lingkungan" class="w-full border-gray-300 rounded-md" rows="3"></textarea>
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">Tindakan Dilakukan</label>
                    <textarea name="tindakan_dilakukan" class="w-full border-gray-300 rounded-md" rows="3"></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Jentik Ditemukan?</label>
                        <select name="ditemukan_jentik" class="w-full border-gray-300 rounded-md">
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Status Akhir</label>
                        <select name="status_akhir" class="w-full border-gray-300 rounded-md">
                            <option value="aman">Aman</option>
                            <option value="perlu pemantauan">Perlu Pemantauan</option>
                            <option value="perlu tindakan">Perlu Tindakan</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="w-full bg-green-600 text-green font-bold py-2 rounded-md hover:bg-green-700 transition">Simpan Data</button>
            </form>
        </div>
    </div>
</x-app-layout>