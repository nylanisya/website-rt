<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Warga') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('warga.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
                        + Tambah Warga
                    </a>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="min-w-full border border-gray-200 mt-4">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-4 py-2">NIK</th>
                                <th class="border px-4 py-2">Nama</th>
                                <th class="border px-4 py-2">JK</th>
                                <th class="border px-4 py-2">No KK</th>
                                <th class="border px-4 py-2">Status Keluarga</th>
                                <th class="border px-4 py-2">Pendidikan</th>
                                <th class="border px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($wargas as $warga)
                            <tr>
                                <td class="border px-4 py-2">{{ $warga->nik }}</td>
                                <td class="border px-4 py-2">{{ $warga->nama }}</td>
                                <td class="border px-4 py-2">{{ $warga->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                <td class="border px-4 py-2">{{ $warga->keluarga->no_kk ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $warga->status_dalam_keluarga }}</td>
                                <td class="border px-4 py-2">{{ $warga->pendidikan }}</td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('warga.edit', $warga) }}" class="text-yellow-600 hover:text-yellow-900 mr-2">Edit</a>
                                    <form action="{{ route('warga.destroy', $warga) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin ingin menghapus warga ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="border px-4 py-2 text-center">Belum ada data warga</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>