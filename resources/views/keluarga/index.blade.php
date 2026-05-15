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
                    <a href="{{ route('keluarga.create') }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
                        + Tambah KK
                    </a>

                    <!-- Container dengan overflow horizontal untuk scroll di mobile -->
                    <div style="overflow-x: auto; width: 100%; -webkit-overflow-scrolling: touch;" class="mt-4">
                        <table style="min-width: 700px; width: 100%; border-collapse: collapse;">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th
                                        style="border: 1px solid #ddd; padding: 8px 12px; text-align: left; white-space: nowrap;">
                                        No KK</th>
                                    <th
                                        style="border: 1px solid #ddd; padding: 8px 12px; text-align: left; white-space: nowrap;">
                                        Kepala Keluarga</th>
                                    <th
                                        style="border: 1px solid #ddd; padding: 8px 12px; text-align: left; white-space: nowrap;">
                                        Alamat</th>
                                    <th
                                        style="border: 1px solid #ddd; padding: 8px 12px; text-align: left; white-space: nowrap;">
                                        RT/RW</th>
                                    <th
                                        style="border: 1px solid #ddd; padding: 8px 12px; text-align: left; white-space: nowrap;">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($keluargas as $keluarga)
                                    <tr>
                                        <td style="border: 1px solid #ddd; padding: 8px 12px; white-space: nowrap;">
                                            {{ $keluarga->no_kk }}</td>
                                        <td style="border: 1px solid #ddd; padding: 8px 12px; white-space: nowrap;">
                                            {{ $keluarga->kepala_keluarga }}</td>
                                        <td style="border: 1px solid #ddd; padding: 8px 12px; white-space: nowrap;">
                                            {{ $keluarga->alamat }}</td>
                                        <td style="border: 1px solid #ddd; padding: 8px 12px; white-space: nowrap;">
                                            {{ $keluarga->rt }}/{{ $keluarga->rw }}</td>
                                        <td style="border: 1px solid #ddd; padding: 8px 12px; white-space: nowrap;">
                                            <a href="{{ route('keluarga.edit', $keluarga) }}"
                                                style="color: #eab308; text-decoration: none; margin-right: 12px;">Edit</a>
                                            <form action="{{ route('keluarga.destroy', $keluarga) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    style="color: #ef4444; background: none; border: none; cursor: pointer;"
                                                    onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Tambahkan CSS untuk memastikan scroll muncul di mobile -->
                    <style>
                        @media (max-width: 768px) {
                            div[style*="overflow-x: auto"] {
                                overflow-x: auto !important;
                            }

                            table {
                                display: table !important;
                            }
                        }
                    </style>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
