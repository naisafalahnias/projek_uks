<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pemeriksaan Gizi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
        }

        .header h2 {
            margin: 0;
        }

        .header p {
            margin: 2px 0;
        }

        hr {
            border: 1px solid black;
            margin: 10px 0 20px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 6px;
            vertical-align: top;
        }

        .label {
            width: 30%;
        }

        .value {
            width: 70%;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
        }

        .ttd {
            margin-top: 60px;
        }
    </style>
</head>
<body>

    {{-- HEADER SEKOLAH --}}
    <div class="header">
        <h2>SD NEGERI CONTOH</h2>
        <p>Jl. Pendidikan No. 123</p>
        <p>Telp: 0812-xxxx-xxxx</p>
    </div>

    <hr>

    <h3 style="text-align:center;">LAPORAN PEMERIKSAAN GIZI</h3>

    <br>

    {{-- DATA SISWA --}}
    <table>
        <tr>
            <td class="label">Nama Siswa</td>
            <td class="value">: {{ $pemeriksaan->siswa->nama }}</td>
        </tr>
        <tr>
            <td class="label">NIS</td>
            <td class="value">: {{ $pemeriksaan->siswa->nis }}</td>
        </tr>
        <tr>
            <td class="label">Kelas</td>
            <td class="value">: {{ $pemeriksaan->siswa->kelas }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Pemeriksaan</td>
            <td class="value">: {{ \Carbon\Carbon::parse($pemeriksaan->tanggal)->format('d/m/Y') }}</td>
        </tr>
    </table>

    <br><br>

    {{-- DATA PEMERIKSAAN --}}
    <table border="1">
        <tr>
            <td><strong>Tinggi Badan</strong></td>
            <td>{{ $pemeriksaan->tinggi_badan }} cm</td>
        </tr>
        <tr>
            <td><strong>Berat Badan</strong></td>
            <td>{{ $pemeriksaan->berat_badan }} kg</td>
        </tr>
        <tr>
            <td><strong>BMI</strong></td>
            <td>{{ $pemeriksaan->bmi }}</td>
        </tr>
        <tr>
            <td><strong>Status Gizi</strong></td>
            <td>{{ $pemeriksaan->status_gizi }}</td>
        </tr>
        <tr>
            <td><strong>Keterangan</strong></td>
            <td>{{ $pemeriksaan->keterangan ?? '-' }}</td>
        </tr>
    </table>

    {{-- TTD --}}
    <div class="footer">
        <p>{{ \Carbon\Carbon::now()->format('d F Y') }}</p>
        <p>Petugas UKS</p>

        <div class="ttd">
            _______________________
        </div>
    </div>

</body>
</html>
