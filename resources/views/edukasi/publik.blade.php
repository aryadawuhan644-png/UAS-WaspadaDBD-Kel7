<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edukasi Waspada DBD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 pb-16">

    <div class="bg-blue-600 text-white py-12 px-6 text-center shadow-md">
        <h1 class="text-3xl md:text-4xl font-bold mb-4">Pusat Edukasi Waspada DBD</h1>
        <p class="text-blue-100 max-w-xl mx-auto">Pelajari cara pencegahan, penanganan, dan fakta-fakta penting seputar Demam Berdarah Dengue untuk melindungi lingkungan Anda.</p>
    </div>

    <div class="max-w-6xl mx-auto px-6 mt-8">
        <div class="flex flex-wrap gap-2 mb-8 justify-center">
            <a href="{{ route('edukasi.publik') }}" class="px-4 py-2 rounded-full text-sm font-medium {{ !request('kategori') ? 'bg-blue-600 text-white shadow' : 'bg-white text-gray-600 hover:bg-gray-100 border' }}">
                Semua
            </a>
            <a href="{{ route('edukasi.publik', ['kategori' => 'pencegahan']) }}" class="px-4 py-2 rounded-full text-sm font-medium {{ request('kategori') == 'pencegahan' ? 'bg-blue-600 text-white shadow' : 'bg-white text-gray-600 hover:bg-gray-100 border' }}">
                Pencegahan
            </a>
            <a href="{{ route('edukasi.publik', ['kategori' => 'gejala']) }}" class="px-4 py-2 rounded-full text-sm font-medium {{ request('kategori') == 'gejala' ? 'bg-blue-600 text-white shadow' : 'bg-white text-gray-600 hover:bg-gray-100 border' }}">
                Gejala
            </a>
            <a href="{{ route('edukasi.publik', ['kategori' => 'penanganan']) }}" class="px-4 py-2 rounded-full text-sm font-medium {{ request('kategori') == 'penanganan' ? 'bg-blue-600 text-white shadow' : 'bg-white text-gray-600 hover:bg-gray-100 border' }}">
                Penanganan
            </a>
            <a href="{{ route('edukasi.publik', ['kategori' => 'fakta unik']) }}" class="px-4 py-2 rounded-full text-sm font-medium {{ request('kategori') == 'fakta unik' ? 'bg-blue-600 text-white shadow' : 'bg-white text-gray-600 hover:bg-gray-100 border' }}">
                Fakta Unik
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($edukasi as $item)
                <a href="{{ route('edukasi.show', $item->id) }}" class="bg-white rounded-xl shadow-sm hover:shadow-md transition duration-200 overflow-hidden group flex flex-col">
                    <div class="h-48 bg-gray-200 w-full overflow-hidden relative">
                        @if($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                Tanpa Gambar
                            </div>
                        @endif
                        <span class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-blue-600 uppercase tracking-wide">
                            {{ $item->kategori }}
                        </span>
                    </div>
                    
                    <div class="p-6 flex-1 flex flex-col">
                        <h2 class="text-xl font-bold text-gray-800 mb-2 line-clamp-2">{{ $item->judul }}</h2>
                        <p class="text-gray-500 text-sm mb-4 line-clamp-3">{{ \Illuminate\Support\Str::limit(strip_tags($item->konten), 100) }}</p>
                        <div class="mt-auto text-blue-600 text-sm font-semibold flex items-center">
                            Baca selengkapnya <span class="ml-1">&rarr;</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-12 bg-white rounded-xl shadow-sm border border-dashed border-gray-300">
                    <p class="text-gray-500">Belum ada materi edukasi yang dipublikasikan.</p>
                </div>
            @endforelse
        </div>
    </div>
</body>
</html>