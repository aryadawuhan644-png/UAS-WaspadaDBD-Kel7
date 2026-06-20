<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Titik Risiko Tinggi</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if($titikRisikoTinggi->isEmpty())
                <div class="col-span-full p-8 text-center bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                    <p class="text-gray-500 font-medium">Alhamdulillah, tidak ada titik dengan risiko tinggi saat ini.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($titikRisikoTinggi as $item)
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition flex flex-col justify-between border-l-4 border-l-red-500">
                            <div>
                                <div class="flex justify-between items-center mb-4">

                                    
                                    <span class="px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wide bg-red-100 text-red-800">
                                        {{ $item->level_risiko_awal ?? 'Tinggi' }}
                                    </span>
                                </div>

                                <h3 class="font-bold text-xl text-gray-800 mb-2 line-clamp-2" title="{{ $item->nama_titik ?? '-' }}">
                                    {{ $item->nama_titik ?? '-' }}
                                </h3>
                                
                                <p class="text-sm text-gray-600 flex items-start gap-2 mb-4">
                                    <svg class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                    <span class="font-semibold text-sm leading-relaxed">
                                        {{ $item->alamat ?? 'Alamat tidak tersedia' }}
                                    </span>
                                </p>
                            </div>

                            <div class="mt-4 pt-4 border-t border-gray-50 text-right">
                                <span class="text-[10px] font-bold text-red-500 uppercase flex items-center justify-end gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    Perlu Perhatian Khusus
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>