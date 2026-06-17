<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Edukasi Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <form action="{{ route('edukasi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Artikel</label>
                            <input type="text" name="judul" class="w-full border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan judul yang menarik..." required>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori Topik</label>
                            <select name="kategori" class="w-full border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="pencegahan">Pencegahan</option>
                                <option value="gejala">Gejala & Ciri-ciri</option>
                                <option value="penanganan">Penanganan</option>
                                <option value="fakta unik">Fakta Unik Nyamuk/DBD</option>
                            </select>
                        </div>

                        <div class="mb-6 border border-dashed border-gray-300 p-4 rounded-md bg-gray-50">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Thumbnail (Opsional)</label>
                            <input type="file" name="gambar" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="text-xs text-gray-400 mt-2">Format: JPG, PNG. Maksimal 2MB.</p>
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Isi Konten Edukasi</label>
                            <textarea name="konten" rows="10" class="w-full border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="Tulis narasi edukasi di sini..." required></textarea>
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-md transition shadow-sm">
                                Publikasikan Edukasi
                            </button>
                            <a href="{{ route('edukasi.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 px-6 rounded-md transition">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>