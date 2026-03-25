<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Rekam Medis</title>
    <style>
        @page { 
            margin: 1.2cm; 
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.5;
        }

        /* Teknik 3 Kolom agar simetris sempurna */
        .table-kop {
            width: 100%;
            border: none;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .table-kop td {
            border: none !important;
            padding: 0;
            vertical-align: middle;
        }
        .nama-instansi {
            font-size: 16px; /* Sedikit dikecilkan agar muat satu baris */
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
            line-height: 1.2;
        }
        .alamat-instansi {
            font-size: 9px;
            font-style: italic;
            margin-top: 5px;
        }

        h4 {
            text-align: center;
            text-transform: uppercase;
            font-size: 14px;
            margin: 10px 0 5px 0;
            color: #000;
        }

        .periode {
            text-align: center;
            margin-bottom: 25px;
            font-size: 11px;
            color: #444;
        }

        .table-data {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
        }
        .table-data th {
            background-color: #f8f9fa;
            color: #000;
            padding: 10px 5px;
            border: 1px solid #333;
            text-transform: uppercase;
            font-size: 10px;
        }
        .table-data td {
            padding: 8px 5px;
            border: 1px solid #333;
            vertical-align: top;
            word-wrap: break-word;
        }

        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }

        .footer-container {
            margin-top: 30px;
            width: 100%;
        }
        .ttd-wrapper {
            float: right;
            width: 200px;
            text-align: center;
        }
        .spasi-ttd { height: 70px; }
    </style>
</head>
<body>

    <table class="table-kop">
        <tr>
            <td width="15%" class="text-center">
                @php
                    $path = public_path('assets/backend/img/avatars/logo.png');
                    $logo = file_exists($path) ? base64_encode(file_get_contents($path)) : '';
                @endphp
                @if($logo)
                    <img src="data:image/png;base64,{{ $logo }}" width="70">
                @endif
            </td>
            
            <td width="70%" class="text-center">
                <div class="nama-instansi">MediSchool (UKS)</div>
                <div class="nama-instansi">SMK ASSALAAM BANDUNG</div>
                <div class="alamat-instansi">
                    Jl. Situ Tarate, Cibaduyut, Dayeuhkolot, Kota Bandung, Jawa Barat 40265.<br>
                    No Telp : (022) 5420220
                </div>
            </td>

            <td width="15%"></td>
        </tr>
    </table>

    <h4>Laporan Rekapitulasi Kunjungan Siswa</h4>
    <div class="periode">
        @if(isset($awal) && isset($akhir))
            Periode: <strong>{{ \Carbon\Carbon::parse($awal)->format('d/m/Y') }}</strong> s/d <strong>{{ \Carbon\Carbon::parse($akhir)->format('d/m/Y') }}</strong>
        @else
            <span class="fw-bold">DATA REKAM MEDIS SISWA</span>
        @endif
    </div>

    <table class="table-data">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Nama Siswa</th>
                <th width="12%">Kelas</th>
                <th width="13%">Tanggal</th>
                <th width="35%">Keluhan / Tindakan</th>
                <th width="15%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rekam_medis as $data)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="fw-bold">{{ $data->siswa->nama }}</td>
                    <td class="text-center">{{ $data->siswa->kelas->nama_kelas ?? '-' }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($data->tanggal)->format('d/m/Y') }}</td>
                    <td>
                        <strong>Keluhan:</strong> {{ $data->keluhan }}<br>
                        @if(!empty($data->tindakan))
                            <small><strong>Tindakan:</strong> {{ $data->tindakan }}</small>
                        @endif
                    </td>
                    <td class="text-center" style="text-transform: uppercase;">
                        {{ $data->status }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer-container">
        <div class="ttd-wrapper">
            Dicetak pada: {{ now()->translatedFormat('d F Y H:i') }}<br>
            Petugas UKS,
            <div class="spasi-ttd"></div>
            <strong>( .................................... )</strong><br>
            NIP. ...........................
        </div>
    </div>

</body>
</html>