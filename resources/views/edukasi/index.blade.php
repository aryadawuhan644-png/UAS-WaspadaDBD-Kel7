<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Edukasi Warga') }}
            </h2>
            <a href="{{ route('edukasi.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md shadow-sm transition">
                + Tulis Artikel Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b bg-gray-50 text-sm uppercase text-gray-600">
                                <th class="p-4">Tanggal</th>
                                <th class="p-4">Judul Artikel</th>
                                <th class="p-4">Kategori</th>
                                <th class="p-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($edukasi as $item)
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="p-4 whitespace-nowrap text-gray-500">{{ $item->created_at->format('d M Y') }}</td>
                                    <td class="p-4 font-semibold text-gray-800">{{ $item->judul }}</td>
                                    <td class="p-4">
                                        <span class="px-2 py-1 bg-blue-50 text-blue-700 border border-blue-200 text-xs font-bold rounded-full uppercase tracking-wide">
                                            {{ $item->kategori }}
                                        </span>
                                    </td>
                                    <td class="p-4 flex gap-2">
                                        <a href="{{ route('edukasi.edit', $item->id) }}" class="bg-yellow-50 hover:bg-yellow-100 text-yellow-700 px-3 py-1 rounded text-sm font-semibold transition border border-yellow-200">Edit</a>
                                        <form action="{{ route('edukasi.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus edukasi ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1 rounded text-sm font-semibold transition border border-red-200">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-12 text-center text-gray-500">
                                        Belum ada artikel edukasi. Klik tombol "Tulis Artikel Baru" untuk mulai.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>