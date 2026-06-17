<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $edukasi->judul }} - Edukasi DBD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 pb-16">

    <div class="max-w-3xl mx-auto px-6 py-10">
        <a href="{{ route('edukasi.publik') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold mb-8 transition">
            &larr; Kembali ke Daftar Edukasi
        </a>

        <article class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
            @if($edukasi->gambar)
                <img src="{{ asset('storage/' . $edukasi->gambar) }}" alt="{{ $edukasi->judul }}" class="w-full h-64 md:h-96 object-cover">
            @endif

            <div class="p-8 md:p-12">
                <div class="flex flex-wrap items-center gap-4 mb-6">
                    <span class="bg-blue-50 text-blue-700 border border-blue-200 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">
                        {{ $edukasi->kategori }}
                    </span>
                    <span class="text-gray-400 text-sm font-medium">
                        Dipublikasikan pada {{ $edukasi->created_at->format('d M Y') }}
                    </span>
                </div>

                <h1 class="text-3xl md:text-4xl font-extrabold mb-8 leading-tight text-gray-900">
                    {{ $edukasi->judul }}
                </h1>

                <div class="text-gray-600 leading-relaxed space-y-6 text-lg">
                    {!! nl2br(e($edukasi->konten)) !!}
                </div>
            </div>
        </article>
    </div>

</body>
</html>