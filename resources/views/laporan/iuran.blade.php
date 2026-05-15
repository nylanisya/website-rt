<!DOCTYPE html>
<html>

<head>
    <title>Laporan Iuran RT</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .total {
            margin-top: 20px;
            font-weight: bold;
        }

        .lunas {
            color: green;
        }

        .belum {
            color: red;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Laporan Iuran Bulanan RT</h1>
        <p>Periode: {{ $bulan }}/{{ $tahun }}</p>
        <p>Tanggal Cetak: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No KK</th>
                <th>Kepala Keluarga</th>
                <th>Jenis Iuran</th>
                <th>Nominal</th>
                <th>Status</th>
                <th>Tgl Bayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($iuran as $key => $i)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $i->keluarga->no_kk ?? '-' }}</td>
                    <td>{{ $i->keluarga->kepala_keluarga ?? '-' }}</td>
                    <td>{{ $i->jenisIuran->nama ?? $i->jenis_iuran_lainnya }}</td>
                    <td>Rp {{ number_format($i->nominal, 0, ',', '.') }}</td>
                    <td class="{{ $i->status == 'lunas' ? 'lunas' : 'belum' }}">
                        {{ strtoupper($i->status) }}
                    </td>
                    <td>{{ $i->pembayaran ? \Carbon\Carbon::parse($i->pembayaran->tanggal_bayar)->format('d/m/Y') : '-' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <p>💰 Total Lunas: Rp {{ number_format($totalLunas, 0, ',', '.') }}</p>
        <p>⚠️ Total Belum: Rp {{ number_format($totalBelum, 0, ',', '.') }}</p>
    </div>

    <div class="footer">
        <p>Dicetak oleh: {{ auth()->user()->name }}</p>
    </div>
</body>

</html>
