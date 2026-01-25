<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Rekam Medis</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #000;
        }

        .header-logo {
            text-align: center;
            margin-bottom: 10px;
        }

        .header-logo img {
            width: 200px;
        }

        h4 {
            text-align: center;
            margin-bottom: 5px;
            color: #003366;
        }

        p {
            text-align: center;
            margin-top: 0;
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table th {
            background-color: #003366;
            color: #fff;
            padding: 8px;
            border: 1px solid #000;
        }

        table td {
            padding: 6px;
            border: 1px solid #000;
        }

        tbody tr:nth-child(even) {
            background-color: #f1f6ff;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-style: italic;
            font-size: 11px;
        }
    </style>
</head>
<body>

    <div class="header-logo">
        @php
            $logo = base64_encode(file_get_contents(public_path('assets/backend/img/avatars/logo.png')));
        @endphp

        <img src="data:image/png;base64,{{ $logo }}" width="80" alt="Logo UKS"> 
    </div>

    <h4>Laporan Rekam Medis Siswa</h4>
    <p>Dari: {{ \Carbon\Carbon::parse($awal)->format('d M Y') }} - 
       Sampai: {{ \Carbon\Carbon::parse($akhir)->format('d M Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Tanggal</th>
                <th>Keluhan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rekam_medis as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data->siswa->nama }}</td>
                    <td>{{ $data->siswa->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d M Y') }}</td>
                    <td>{{ $data->keluhan }}</td>
                    <td>{{ ucfirst($data->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" align="center">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d M Y H:i') }}
    </div>

</body>
</html>
