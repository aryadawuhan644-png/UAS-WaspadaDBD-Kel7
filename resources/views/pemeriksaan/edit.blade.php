<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-sm">
            <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Edit Data Pemeriksaan</h2>
            
            <form action="{{ route('pemeriksaan.update', $pemeriksaan->id) }}" method="POST">
                @csrf
                @method('PUT') <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Titik Risiko</label>
                        <select name="titik_risiko_id" class="w-full border-gray-300 rounded-md">
                            @foreach($titikRisikos as $titik)
                                <option value="{{ $titik->id }}" {{ $pemeriksaan->titik_risiko_id == $titik->id ? 'selected' : '' }}>
                                    {{ $titik->nama_titik }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Tanggal</label>
                        <input type="date" name="tanggal_pemeriksaan" value="{{ $pemeriksaan->tanggal_pemeriksaan }}" class="w-full border-gray-300 rounded-md" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">Kondisi Lingkungan</label>
                    <textarea name="kondisi_lingkungan" class="w-full border-gray-300 rounded-md" rows="3">{{ $pemeriksaan->kondisi_lingkungan }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">Tindakan Dilakukan</label>
                    <textarea name="tindakan_dilakukan" class="w-full border-gray-300 rounded-md" rows="3">{{ $pemeriksaan->tindakan_dilakukan }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Jentik Ditemukan?</label>
                        <select name="ditemukan_jentik" class="w-full border-gray-300 rounded-md">
                            <option value="1" {{ $pemeriksaan->ditemukan_jentik == 1 ? 'selected' : '' }}>Ya</option>
                            <option value="0" {{ $pemeriksaan->ditemukan_jentik == 0 ? 'selected' : '' }}>Tidak</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Status Akhir</label>
                        <select name="status_akhir" class="w-full border-gray-300 rounded-md">
                            <option value="aman" {{ $pemeriksaan->status_akhir == 'aman' ? 'selected' : '' }}>Aman</option>
                            <option value="perlu pemantauan" {{ $pemeriksaan->status_akhir == 'perlu pemantauan' ? 'selected' : '' }}>Perlu Pemantauan</option>
                            <option value="perlu tindakan" {{ $pemeriksaan->status_akhir == 'perlu tindakan' ? 'selected' : '' }}>Perlu Tindakan</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="w-full bg-yellow-500 text-green font-bold py-2 rounded-md hover:bg-yellow-600 transition">Update Data</button>
            </form>
        </div>
    </div>
</x-app-layout>