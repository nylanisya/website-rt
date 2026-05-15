<!DOCTYPE html>
<html>

<head>
    <title>Laporan Keuangan RT</title>
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
            font-size: 18px;
            font-weight: bold;
            color: green;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Laporan Keuangan RT</h1>
        <p>Semua Pemasukan dari Iuran Warga</p>
        <p>Tanggal Cetak: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Bayar</th>
                <th>No KK</th>
                <th>Kepala Keluarga</th>
                <th>Jenis Iuran</th>
                <th>Jumlah</th>
                <th>Metode</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pembayaran as $key => $p)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal_bayar)->format('d/m/Y') }}</td>
                    <td>{{ $p->iuran->keluarga->no_kk ?? '-' }}</td>
                    <td>{{ $p->iuran->keluarga->kepala_keluarga ?? '-' }}</td>
                    <td>{{ $p->iuran->jenisIuran->nama ?? $p->iuran->jenis_iuran_lainnya }}</td>
                    <td>Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($p->metode) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <p>💰 Total Pemasukan: Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
    </div>

    <div class="footer">
        <p>Dicetak oleh: {{ auth()->user()->name }}</p>
    </div>
</body>

</html>
