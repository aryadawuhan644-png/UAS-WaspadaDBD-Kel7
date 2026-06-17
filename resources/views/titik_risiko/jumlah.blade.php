<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jumlah Titik Risiko') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-end mb-6">
                <a href="{{ route('titik-risiko.index') }}" class="bg-gray-800 hover:bg-gray-700 text-white px-5 py-2.5 rounded-lg font-bold text-sm shadow-sm transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Kelola Titik (CRUD)
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($titik_risikos as $titik)
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-200">
                    
                    <div class="flex justify-between items-start mb-4">
                        <span class="bg-blue-50 text-blue-700 text-xs px-3 py-1 rounded-md font-bold uppercase tracking-wide">
                            {{ $titik->jenis_risiko }}
                        </span>
                        
                        @php
                            $color = 'gray';
                            if($titik->level_risiko_awal == 'tinggi') $color = 'red';
                            elseif($titik->level_risiko_awal == 'sedang') $color = 'yellow';
                            elseif($titik->level_risiko_awal == 'rendah') $color = 'green';
                        @endphp
                        
                        <span class="bg-{{ $color }}-100 text-{{ $color }}-800 text-xs px-3 py-1 rounded-md font-bold uppercase tracking-wide">
                            {{ $titik->level_risiko_awal }}
                        </span>
                    </div>

                    <h3 class="text-xl font-bold text-gray-800 mb-1 line-clamp-1" title="{{ $titik->nama_titik }}">
                        {{ $titik->nama_titik }}
                    </h3>
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2 min-h-[2.5rem]">
                        {{ $titik->alamat }}
                    </p>
                    
                    <div class="border-t border-gray-100 pt-4 flex justify-between items-center">
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-gray-400 uppercase">RT / RW</span>
                            <span class="text-sm font-semibold text-gray-700">{{ $titik->rt_rw }}</span>
                        </div>
                        <div class="flex flex-col text-right">
                            <span class="text-xs font-bold text-gray-400 uppercase">Status</span>
                            <span class="text-sm font-semibold {{ $titik->status_aktif ? 'text-green-600' : 'text-red-500' }}">
                                {{ $titik->status_aktif ? 'Aktif' : 'Non-aktif' }}
                            </span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full bg-gray-50 p-8 text-center rounded-2xl border-2 border-dashed border-gray-200">
                    <p class="text-gray-500 font-medium">Belum ada titik risiko yang ditambahkan.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>