<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Daftar Pengguna') }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-end items-center mb-6">
                <a href="{{ route('petugas.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                    + Tambah Pengguna
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="p-4 font-semibold text-gray-600">Nama</th>
                            <th class="p-4 font-semibold text-gray-600">Role</th>
                            <th class="p-4 font-semibold text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $u)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4">{{ $u->name }}</td>
                            <td class="p-4 capitalize">{{ $u->role }}</td>
                            <td class="p-4 flex gap-3">
                                <a href="{{ route('petugas.edit', $u->id) }}" class="text-blue-600 hover:text-blue-900 font-medium">Edit</a>
                                <form action="{{ route('petugas.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Hapus akun?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="p-4 text-center text-gray-500">Belum ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>