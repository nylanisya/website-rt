<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Keluarga / KK') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('keluarga.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
                        + Tambah KK
                    </a>

                    <table class="min-w-full border border-gray-200 mt-4">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-4 py-2">No KK</th>
                                <th class="border px-4 py-2">Kepala Keluarga</th>
                                <th class="border px-4 py-2">Alamat</th>
                                <th class="border px-4 py-2">RT/RW</th>
                                <th class="border px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($keluargas as $keluarga)
                            <tr>
                                <td class="border px-4 py-2">{{ $keluarga->no_kk }}</td>
                                <td class="border px-4 py-2">{{ $keluarga->kepala_keluarga }}</td>
                                <td class="border px-4 py-2">{{ $keluarga->alamat }}</td>
                                <td class="border px-4 py-2">{{ $keluarga->rt }}/{{ $keluarga->rw }}</td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('keluarga.edit', $keluarga) }}" class="text-yellow-600 hover:text-yellow-900 mr-2">Edit</a>
                                    <form action="{{ route('keluarga.destroy', $keluarga) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>