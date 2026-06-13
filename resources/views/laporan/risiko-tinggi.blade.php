<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl font-extrabold text-red-600 mb-6">⚠️ Lokasi Risiko Tinggi</h2>
            
            @if($data->isEmpty())
                <div class="bg-blue-50 p-6 rounded-lg text-blue-700 shadow">
                    Alhamdulillah, tidak ada lokasi dengan risiko tinggi saat ini.
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($data as $titik)
                        <div class="bg-white border-l-8 border-red-500 shadow-lg p-6 rounded-lg transition hover:scale-105">
                            <h3 class="text-xl font-bold text-gray-800">{{ $titik->nama_titik }}</h3>
                            <p class="text-gray-500 mt-2">Alamat: {{ $titik->alamat }}</p>
                            <span class="inline-block mt-4 px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-semibold">
                                Perlu Tindakan Segera
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>