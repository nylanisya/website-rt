<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Catat Pembayaran Iuran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <p><strong>KK:</strong> {{ $tagihan->keluarga->no_kk }} -
                            {{ $tagihan->keluarga->kepala_keluarga }}</p>
                        <p><strong>Jenis Iuran:</strong>
                            {{ $tagihan->jenisIuran->nama ?? $tagihan->jenis_iuran_lainnya }}</p>
                        <p><strong>Nominal:</strong> Rp {{ number_format($tagihan->nominal, 0, ',', '.') }}</p>
                    </div>

                    <form action="{{ route('iuran.proses-bayar', $tagihan->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Bayar</label>
                            <input type="date" name="tanggal_bayar" value="{{ date('Y-m-d') }}"
                                class="w-full border rounded px-3 py-2" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Metode Pembayaran</label>
                            <select name="metode" class="w-full border rounded px-3 py-2" required>
                                <option value="tunai">Tunai</option>
                                <option value="transfer">Transfer</option>
                            </select>
                        </div>

                        <div class="flex gap-2 mt-4">
                            <button type="submit"
                                style="background-color: #22c55e; color: white; font-weight: bold; padding: 8px 16px; border-radius: 4px; border: none; cursor: pointer;">
                                Simpan Pembayaran
                            </button>
                            <a href="{{ route('iuran.index') }}"
                                style="background-color: #6b7280; color: white; font-weight: bold; padding: 8px 16px; border-radius: 4px; text-decoration: none;">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
