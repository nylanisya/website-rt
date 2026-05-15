<!DOCTYPE html>
<html>

<head>
    <title>Laporan Data Warga RT</title>
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

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Laporan Data Warga RT</h1>
        <p>Tanggal: {{ date('d/m/Y H:i:s') }}</p>
        <p>Total Warga: {{ count($wargas) }} orang</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>No KK</th>
                <th>Jenis Kelamin</th>
                <th>Tempat/Tgl Lahir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($wargas as $key => $w)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $w->nik }}</td>
                    <td>{{ $w->nama }}</td>
                    <td>{{ $w->keluarga->no_kk ?? '-' }}</td>
                    <td>{{ $w->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    <td>{{ $w->tempat_lahir }}, {{ \Carbon\Carbon::parse($w->tanggal_lahir)->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak oleh: {{ auth()->user()->name }}</p>
    </div>
</body>

</html>
