<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Rekam Medis</title>
    <style>
        @page { margin: 1cm; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
        }

        /* Kop Surat Style */
        .kop-surat {
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
            overflow: hidden;
        }
        .logo-wadah {
            float: left;
            width: 15%;
        }
        .judul-wadah {
            float: left;
            width: 85%;
            text-align: center;
        }
        .nama-instansi {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }
        .alamat-instansi {
            font-size: 10px;
            margin: 5px 0 0 0;
            font-style: italic;
        }

        h4 {
            text-align: center;
            text-transform: uppercase;
            font-size: 14px;
            margin: 20px 0 5px 0;
            color: #000;
        }

        .periode {
            text-align: center;
            margin-bottom: 20px;
            font-size: 11px;
            color: #555;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table th {
            background-color: #f2f2f2;
            color: #000;
            padding: 10px 5px;
            border: 1px solid #444;
            text-transform: uppercase;
            font-size: 10px;
        }

        table td {
            padding: 8px 5px;
            border: 1px solid #444;
            vertical-align: top;
        }

        .text-center { text-align: center; }

        .badge {
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .footer-ttd {
            margin-top: 40px;
            float: right;
            width: 200px;
            text-align: center;
        }
        .spasi-ttd { height: 60px; }
    </style>
</head>
<body>

    <div class="kop-surat">
        <div class="logo-wadah">
            @php
                $path = public_path('assets/backend/img/avatars/logo.png');
                $logo = file_exists($path) ? base64_encode(file_get_contents($path)) : '';
            @endphp
            @if($logo)
                <img src="data:image/png;base64,{{ $logo }}" width="70">
            @endif
        </div>
        <div class="judul-wadah">
            <div class="nama-instansi">Unit Kesehatan Sekolah (UKS)</div>
            <div class="nama-instansi">SMK NEGERI CONTOH</div>
            <div class="alamat-instansi">Jl. Pendidikan No. 123, Kota Anda. Telp: (021) 1234567</div>
        </div>
    </div>

    <h4>Laporan Rekapitulasi Kunjungan Siswa</h4>
    <div class="periode">
        Periode: <strong>{{ \Carbon\Carbon::parse($awal)->format('d/m/Y') }}</strong> s/d <strong>{{ \Carbon\Carbon::parse($akhir)->format('d/m/Y') }}</strong>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Nama Siswa</th>
                <th width="10%">Kelas</th>
                <th width="15%">Tanggal</th>
                <th>Keluhan</th>
                <th width="15%">Status Akhir</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rekam_medis as $data)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $data->siswa->nama }}</td>
                    <td class="text-center">{{ $data->siswa->kelas->nama_kelas ?? '-' }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($data->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $data->keluhan }}</td>
                    <td class="text-center">{{ ucfirst($data->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data kunjungan ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer-ttd">
        Dicetak pada: {{ now()->format('d/m/Y H:i') }}<br>
        Petugas UKS,
        <div class="spasi-ttd"></div>
        ( .................................... )
    </div>

</body>
</html>