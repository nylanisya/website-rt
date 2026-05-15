<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tagihan Iuran Warga') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Form Buat Tagihan -->
                    <div class="bg-gray-100 p-4 rounded-lg mb-6">
                        <h3 class="font-bold text-lg mb-3">Buat Tagihan Baru</h3>
                        <form action="{{ route('iuran.store-tagihan') }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-bold mb-1">Jenis Iuran</label>
                                    <select name="jenis_iuran_id" id="jenis_iuran_id"
                                        class="w-full border rounded px-3 py-2" required>
                                        <option value="">-- Pilih --</option>
                                        @foreach ($jenisIurans as $j)
                                            <option value="{{ $j->id }}" data-nominal="{{ $j->nominal }}"
                                                data-nama="{{ $j->nama }}">
                                                {{ $j->nama }} - Rp {{ number_format($j->nominal, 0, ',', '.') }}
                                            </option>
                                        @endforeach
                                        <option value="lainnya">Lainnya (isi sendiri)</option>
                                    </select>
                                </div>

                                <div id="lainnya_form" style="display: none;">
                                    <label class="block text-sm font-bold mb-1">Nama Iuran</label>
                                    <input type="text" name="nama_lainnya" class="w-full border rounded px-3 py-2"
                                        placeholder="Misal: Iuran Jalan">
                                </div>

                                <div>
                                    <label class="block text-sm font-bold mb-1">Nominal</label>
                                    <input type="number" name="nominal" id="nominal"
                                        class="w-full border rounded px-3 py-2" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold mb-1">Tanggal Tagihan</label>
                                    <input type="date" name="tanggal_tagihan" value="{{ date('Y-m-d') }}"
                                        class="w-full border rounded px-3 py-2" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold mb-1">Jatuh Tempo</label>
                                    <input type="date" name="tanggal_jatuh_tempo"
                                        value="{{ date('Y-m-d', strtotime('+7 days')) }}"
                                        class="w-full border rounded px-3 py-2" required>
                                </div>

                                <div class="flex items-end">
                                    <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Buat Tagihan untuk Semua KK
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Daftar Tagihan -->
                    <!-- Form Filter & Search -->
                    <div class="bg-gray-50 p-4 rounded-lg mb-4">
                        <form method="GET" action="{{ route('iuran.index') }}"
                            class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-bold mb-1">Cari (No KK / Kepala Keluarga)</label>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Ketik No KK atau nama..." class="w-full border rounded px-3 py-2">
                            </div>

                            <div>
                                <label class="block text-sm font-bold mb-1">Filter Jenis Iuran</label>
                                <select name="jenis_iuran" class="w-full border rounded px-3 py-2">
                                    <option value="">-- Semua Jenis --</option>
                                    @foreach ($jenisIurans as $j)
                                        <option value="{{ $j->id }}"
                                            {{ request('jenis_iuran') == $j->id ? 'selected' : '' }}>
                                            {{ $j->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex items-end">
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    🔍 Cari & Filter
                                </button>
                                <a href="{{ route('iuran.index') }}"
                                    class="ml-2 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    ↻ Reset
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Tombol Hapus Riwayat (pakai style inline) -->
                    <div style="display: flex; justify-content: flex-end; gap: 8px; margin-bottom: 16px;">
                        <button onclick="confirmHapus('lunas')"
                            style="background-color: #eab308; color: white; font-weight: bold; padding: 8px 16px; border-radius: 4px; border: none; cursor: pointer;">
                            🗑️ Hapus Riwayat Lunas
                        </button>
                        <button onclick="confirmHapus('semua')"
                            style="background-color: #ef4444; color: white; font-weight: bold; padding: 8px 16px; border-radius: 4px; border: none; cursor: pointer;">
                            ⚠️ Hapus Semua Tagihan
                        </button>
                    </div>
                    <!-- Form Hapus (hidden) -->
                    <form id="formHapus" action="{{ route('iuran.hapus-riwayat') }}" method="POST"
                        style="display: none;">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="type" id="hapusType">
                    </form>

                    <script>
                        function confirmHapus(type) {
                            let pesan = type == 'lunas' ?
                                'Yakin hapus semua tagihan yang sudah LUNAS? Data tidak bisa dikembalikan!' :
                                'Yakin hapus SEMUA tagihan? Data tidak bisa dikembalikan!';

                            if (confirm(pesan)) {
                                document.getElementById('hapusType').value = type;
                                document.getElementById('formHapus').submit();
                            }
                        }
                    </script>
                    <h3 class="font-bold text-lg mb-3">Daftar Tagihan</h3>
                    <table class="min-w-full border">
                        <thead>
                            <tr>
                                <th class="border px-2 py-1">No KK</th>
                                <th class="border px-2 py-1">Kepala Keluarga</th>
                                <th class="border px-2 py-1">Jenis Iuran</th>
                                <th class="border px-2 py-1">Nominal</th>
                                <th class="border px-2 py-1">Status</th>
                                <th class="border px-2 py-1">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tagihan as $t)
                                <tr>
                                    <td class="border px-2 py-1">{{ $t->keluarga->no_kk ?? '-' }}</td>
                                    <td class="border px-2 py-1">{{ $t->keluarga->kepala_keluarga ?? '-' }}</td>
                                    <td class="border px-2 py-1">{{ $t->jenisIuran->nama ?? $t->jenis_iuran_lainnya }}
                                    </td>
                                    <td class="border px-2 py-1">Rp {{ number_format($t->nominal, 0, ',', '.') }}</td>
                                    <td class="border px-2 py-1">
                                        @if ($t->status == 'lunas')
                                            <span
                                                style="background-color: #22c55e; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">LUNAS</span>
                                        @elseif($t->status == 'belum')
                                            <span
                                                style="background-color: #ef4444; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">BELUM
                                                LUNAS</span>
                                        @else
                                            <span
                                                style="background-color: #6b7280; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">-</span>
                                        @endif
                                    </td>
                                    <td class="border px-2 py-1">
                                        @if ($t->status == 'belum')
                                            <a href="{{ route('iuran.bayar', $t->id) }}"
                                                style="background-color: #3b82f6; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px; text-decoration: none; display: inline-block; margin-right: 5px;">CATAT
                                                PEMBAYARAN</a>
                                        @elseif($t->status == 'lunas')
                                            <a href="{{ route('iuran.batal', $t->id) }}"
                                                style="background-color: #f59e0b; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px; text-decoration: none; display: inline-block;"
                                                onclick="return confirm('Batalkan pembayaran? Status akan kembali ke BELUM')">BATALKAN</a>
                                        @else
                                            <span style="color: #9ca3af;">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">Belum ada tagihan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.getElementById('jenis_iuran_id').addEventListener('change', function() {
        var selected = this.options[this.selectedIndex];
        var nominal = selected.getAttribute('data-nominal');
        var lainnyaForm = document.getElementById('lainnya_form');

        if (this.value == 'lainnya') {
            lainnyaForm.style.display = 'block';
            document.getElementById('nominal').value = '';
        } else {
            lainnyaForm.style.display = 'none';
            if (nominal && nominal != '') {
                document.getElementById('nominal').value = nominal;
            }
        }
    });
</script>
