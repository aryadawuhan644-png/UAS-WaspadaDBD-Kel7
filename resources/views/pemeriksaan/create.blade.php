<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 bg-white p-6 shadow rounded-lg">
            <h2 class="text-xl font-bold mb-6">Form Pemeriksaan Baru</h2>
            
            <form action="{{ route('pemeriksaan.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label>Pilih Titik Risiko</label>
                    <select name="titik_risiko_id" class="w-full border-gray-300 rounded-md">
                        @foreach($titikRisikos as $t)
                            <option value="{{ $t->id }}">{{ $t->nama_titik }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal_pemeriksaan" class="w-full border-gray-300 rounded-md" required>
                </div>

                <div class="mb-4">
                    <label>Ditemukan Jentik?</label>
                    <select name="ditemukan_jentik" class="w-full border-gray-300 rounded-md">
                        <option value="1">Ya</option>
                        <option value="0">Tidak</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label>Kondisi Lingkungan</label>
                    <textarea name="kondisi_lingkungan" class="w-full border-gray-300 rounded-md"></textarea>
                </div>

                <div class="mb-4">
                    <label>Tindakan Dilakukan</label>
                    <textarea name="tindakan_dilakukan" class="w-full border-gray-300 rounded-md"></textarea>
                </div>

                <div class="mb-4">
                    <label>Status Akhir</label>
                    <select name="status_akhir" class="w-full border-gray-300 rounded-md">
                        <option value="aman">Aman</option>
                        <option value="perlu pemantauan">Perlu Pemantauan</option>
                        <option value="perlu tindakan">Perlu Tindakan</option>
                    </select>
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan Pemeriksaan</button>
            </form>
        </div>
    </div>
</x-app-layout>