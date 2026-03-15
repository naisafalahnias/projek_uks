<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Jadwal Pemeriksaan</title>
    <style>
        @page { margin: 1.2cm; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.5;
        }

        /* Kop Surat Style */
        .kop-surat {
            width: 100%;
            margin-bottom: 20px;
            padding-bottom: 5px;
            border-bottom: 3px double #000;
            display: block;
            clear: both; /* Memastikan tidak ada float yang nyangkut */
        }

        .logo-wadah {
            float: left;
            width: 70px; /* Ukuran tetap agar presisi */
            margin-right: -70px; /* Teknik penyeimbang float */
        }

        .judul-wadah {
            width: 100%;
            text-align: center;
        }

        /* Tambahkan ini untuk memaksa konten selesai sebelum garis digambar */
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        /* Kop Surat menggunakan Table agar lebih stabil */
        .table-kop {
            width: 100%;
            border: none;
            margin-bottom: 5px;
        }

        .table-kop td {
            border: none !important; /* Menghilangkan border tabel kop */
            padding: 0px;
            vertical-align: middle;
        }

        .line-header {
            border-bottom: 3px double #000;
            margin-bottom: 20px;
            width: 100%;
        }

        .nama-instansi {
            font-size: 18px; /* Lebih besar */
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }

        .sub-instansi {
            font-size: 16px; /* Lebih besar */
            font-weight: bold;
            margin: 0;
        }

        .alamat-instansi {
            font-size: 10px;
            font-style: italic;
            margin-top: 5px;
        }

        h3 {
            text-align: center;
            text-transform: uppercase;
            font-size: 14px;
            margin: 20px 0 5px 0;
            text-decoration: underline;
        }

        .periode {
            text-align: center;
            margin-bottom: 25px;
            font-size: 11px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table th {
            background-color: #f8f9fa;
            color: #000;
            padding: 10px 5px;
            border: 1px solid #333;
            text-transform: uppercase;
            font-size: 10px;
        }

        table td {
            padding: 8px 7px;
            border: 1px solid #333;
            vertical-align: middle;
        }

        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }

        /* Tanda Tangan */
        .ttd-container {
            margin-top: 40px;
            width: 100%;
        }
        .ttd-box {
            float: right;
            width: 220px;
            text-align: center;
        }
        .spasi-ttd { height: 70px; }
    </style>
</head>
<body>

    <table class="table-kop">
        <tr>
            <td width="15%" align="left">
                @php
                    $path = public_path('assets/backend/img/avatars/logo.png');
                    $logo = file_exists($path) ? base64_encode(file_get_contents($path)) : '';
                @endphp
                @if($logo)
                    {{-- Ukuran dinaikkan ke 85 atau 90 agar terlihat lebih besar --}}
                    <img src="data:image/png;base64,{{ $logo }}" width="90">
                @endif
            </td>
            <td width="85%" align="center">
                <div class="nama-instansi">PEMERINTAH KOTA ADMINISTRASI</div> 
                <div class="sub-instansi">UNIT KESEHATAN SEKOLAH (UKS) SMK NEGERI 1</div> 
                <div class="alamat-instansi">
                    Jl. Merdeka Belajar No. 45, Kec. Cerdas, Kota Pintar.  <br>
                    Kode Pos: 12345 [cite: 14]
                </div>
            </td>
        </tr>
    </table>

{{-- Garis pemisah diletakkan di luar tabel agar tidak memotong logo --}}
<div class="line-header"></div>

<h3>LAPORAN JADWAL PEMERIKSAAN KESEHATAN</h3> [cite: 15]
<div class="periode">
    Periode Laporan: <strong>{{ $awal }}</strong> s/d <strong>{{ $akhir }}</strong> [cite: 16]
</div>

    <h3>LAPORAN JADWAL PEMERIKSAAN KESEHATAN</h3>
    <div class="periode">
        Periode Laporan: <strong>{{ \Carbon\Carbon::parse($awal)->format('d/m/Y') }}</strong> s/d <strong>{{ \Carbon\Carbon::parse($akhir)->format('d/m/Y') }}</strong>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="18%">Hari / Tanggal</th>
                <th width="15%">Kelas</th>
                <th width="22%">Petugas Pelaksana</th>
                <th>Keterangan Tugas</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($jadwal as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('dddd, D MMM Y') }}
                    </td>
                    <td class="text-center fw-bold">{{ $item->kelas->nama_kelas }}</td>
                    <td>{{ $item->user->name ?? '-' }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center"><em>Tidak ada jadwal pemeriksaan pada periode ini.</em></td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="ttd-container">
        <div class="ttd-box">
            Dicetak pada: {{ now()->format('d/m/Y H:i') }}<br>
            Koordinator UKS,
            <div class="spasi-ttd"></div>
            <span class="fw-bold">( ............................................ )</span><br>
            NIP. ........................................
        </div>
    </div>

</body>
</html>