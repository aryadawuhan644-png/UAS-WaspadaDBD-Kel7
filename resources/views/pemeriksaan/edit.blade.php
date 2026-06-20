<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-sm">
            <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Edit Data Pemeriksaan</h2>
            
            <form action="{{ route('pemeriksaan.update', $pemeriksaan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                        <input type="date" name="tanggal_pemeriksaan" value="{{ \Carbon\Carbon::parse($pemeriksaan->tanggal_pemeriksaan)->format('Y-m-d') }}" class="w-full border-gray-300 rounded-md" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">Kondisi Lingkungan</label>
                    <textarea name="kondisi_lingkungan" class="w-full border-gray-300 rounded-md" rows="3" required>{{ $pemeriksaan->kondisi_lingkungan }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">Tindakan Dilakukan</label>
                    <textarea name="tindakan_dilakukan" class="w-full border-gray-300 rounded-md" rows="3" required>{{ $pemeriksaan->tindakan_dilakukan }}</textarea>
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

                <div class="mb-4 mt-4">
                    <label class="block font-medium mb-1">Foto Akhir</label>
                    @if($pemeriksaan->foto)
                        <div class="mb-3">
                            <p class="text-xs text-gray-500 mb-1">Foto Saat Ini:</p>
                            <img src="{{ asset('storage/' . $pemeriksaan->foto) }}" class="w-32 h-32 object-cover rounded border shadow-sm" alt="Foto Akhir">
                        </div>
                    @endif
                    <input type="file" name="foto_akhir" accept="image/*" class="w-full border-gray-300 rounded-md p-2 bg-gray-50">
                    <p class="text-xs text-gray-500 mt-1">Unggah file baru hanya jika ingin mengganti foto akhir.</p>
                </div>

                <button type="submit" class="w-full bg-yellow-500 text-white font-bold py-2 rounded-md hover:bg-yellow-600 transition shadow-sm">Update Data</button>
            </form>
        </div>
    </div>
</x-app-layout>