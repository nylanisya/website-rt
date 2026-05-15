<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard RT') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Kartu Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-4xl font-bold text-blue-600">{{ $totalKK }}</div>
                        <div class="text-gray-600">Kartu Keluarga</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-4xl font-bold text-green-600">{{ $totalWarga }}</div>
                        <div class="text-gray-600">Total Warga</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-4xl font-bold text-green-500">{{ $iuranLunas }}</div>
                        <div class="text-gray-600">Iuran Lunas</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-4xl font-bold text-red-500">{{ $iuranBelum }}</div>
                        <div class="text-gray-600">Iuran Belum Bayar</div>
                    </div>
                </div>
            </div>

            <!-- Grafik 1: Iuran per Bulan -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="font-bold text-lg mb-4">Grafik Iuran (6 Bulan Terakhir)</h3>
                        <canvas id="iuranChart" height="200"></canvas>
                    </div>
                </div>

                <!-- Grafik 2: Jenis Iuran -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="font-bold text-lg mb-4">Iuran Terbayar per Jenis</h3>
                        <canvas id="jenisChart" height="200"></canvas>
                    </div>
                </div>
            </div>

            <!-- Pengumuman & Tagihan Terbaru -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Pengumuman Terbaru -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold text-lg">Pengumuman Terbaru</h3>
                            <a href="{{ route('pengumuman.index') }}" class="text-blue-500 text-sm">Lihat semua →</a>
                        </div>
                        @forelse($pengumumanTerbaru as $p)
                            <div class="border-b border-gray-200 py-3">
                                <div class="font-semibold">{{ $p->judul }}</div>
                                <div class="text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($p->tanggal_terbit)->format('d/m/Y') }}</div>
                                <div class="text-sm text-gray-600 mt-1">{{ Str::limit($p->isi, 80) }}</div>
                            </div>
                        @empty
                            <div class="text-gray-500 text-center py-4">Belum ada pengumuman</div>
                        @endforelse
                    </div>
                </div>

                <!-- Tagihan Terbaru -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold text-lg">Tagihan Terbaru</h3>
                            <a href="{{ route('iuran.index') }}" class="text-blue-500 text-sm">Lihat semua →</a>
                        </div>
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th class="text-left">KK</th>
                                    <th class="text-left">Jenis</th>
                                    <th class="text-left">Nominal</th>
                                    <th class="text-left">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tagihanTerbaru as $t)
                                    <tr>
                                        <td class="py-2">{{ $t->keluarga->no_kk ?? '-' }}</td>
                                        <td>{{ $t->jenisIuran->nama ?? $t->jenis_iuran_lainnya }}</td>
                                        <td>Rp {{ number_format($t->nominal, 0, ',', '.') }}</td>
                                        <td>
                                            @if ($t->status == 'lunas')
                                                <span
                                                    class="bg-green-500 text-white px-2 py-1 rounded text-xs">Lunas</span>
                                            @else
                                                <span
                                                    class="bg-red-500 text-white px-2 py-1 rounded text-xs">Belum</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">Belum ada tagihan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Grafik Iuran per Bulan
        const ctx1 = document.getElementById('iuranChart').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: @json($bulanLabels),
                datasets: [{
                        label: 'Lunas',
                        data: @json($lunasData),
                        backgroundColor: 'rgba(34, 197, 94, 0.7)',
                        borderColor: 'rgb(34, 197, 94)',
                        borderWidth: 1
                    },
                    {
                        label: 'Belum Bayar',
                        data: @json($belumData),
                        backgroundColor: 'rgba(239, 68, 68, 0.7)',
                        borderColor: 'rgb(239, 68, 68)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Iuran'
                        }
                    }
                }
            }
        });

        // Grafik Jenis Iuran
        const ctx2 = document.getElementById('jenisChart').getContext('2d');
        new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: @json($jenisLabels),
                datasets: [{
                    data: @json($jenisTotal),
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(16, 185, 129, 0.7)',
                        'rgba(245, 158, 11, 0.7)',
                        'rgba(239, 68, 68, 0.7)',
                        'rgba(139, 92, 246, 0.7)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</x-app-layout>
