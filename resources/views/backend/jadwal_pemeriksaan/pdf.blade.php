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
        .table-kop {
            width: 100%;
            border: none;
            margin-bottom: 5px;
        }

        .table-kop td {
            border: none !important;
            padding: 0px;
            vertical-align: middle;
        }

        .line-header {
            border-bottom: 3px double #000;
            margin-bottom: 20px;
            width: 100%;
        }

        .nama-instansi {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
            line-height: 1.2;
        }

        .sub-instansi {
            font-size: 14px;
            font-weight: bold;
            margin: 2px 0;
            text-transform: uppercase;
        }

        .alamat-instansi {
            font-size: 10px;
            font-style: italic;
            margin-top: 5px;
            font-weight: normal;
        }

        h3 {
            text-align: center;
            text-transform: uppercase;
            font-size: 13px;
            margin: 10px 0 5px 0;
            text-decoration: underline;
        }

        .periode {
            text-align: center;
            margin-bottom: 25px;
            font-size: 11px;
        }

        /* Table Data Style */
        table.data-table {
            border-collapse: collapse;
            width: 100%;
        }

        table.data-table th {
            background-color: #f2f2f2;
            color: #000;
            padding: 10px 5px;
            border: 1px solid #000;
            text-transform: uppercase;
            font-size: 10px;
        }

        table.data-table td {
            padding: 8px 7px;
            border: 1px solid #000;
            vertical-align: top;
        }

        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }

        /* Tanda Tangan */
        .ttd-container {
            margin-top: 30px;
            width: 100%;
        }
        .ttd-box {
            float: right;
            width: 250px;
            text-align: center;
        }
        .spasi-ttd { height: 60px; }
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
                    <img src="data:image/png;base64,{{ $logo }}" width="80">
                @endif
            </td>
            <td width="85%" align="center" style="padding-right: 10%;">
                <div class="nama-instansi">PEMERINTAH KOTA BANDUNG</div> 
                <div class="sub-instansi">UNIT KESEHATAN SEKOLAH (UKS) SMK ASSALAAM BANDUNG</div> 
                <div class="alamat-instansi">
                    Jl. Situ Tarate, Cibaduyut, Dayeuhkolot, Kota Bandung, Jawa Barat 40265.<br>
                    No Telp : (022) 5420220
                </div>
            </td>
        </tr>
    </table>

    <div class="line-header"></div>

    <h3>LAPORAN JADWAL PEMERIKSAAN KESEHATAN</h3>
    <div class="periode">
        Periode Laporan: <strong>{{ \Carbon\Carbon::parse($awal)->format('d/m/Y') }}</strong> s/d <strong>{{ \Carbon\Carbon::parse($akhir)->format('d/m/Y') }}</strong>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Hari / Tanggal</th>
                <th width="15%">Kelas</th>
                <th width="20%">Petugas Pelaksana</th>
                <th>Keterangan Tugas</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($jadwal as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('dddd, D MMMM Y') }}
                    </td>
                    <td class="text-center fw-bold">{{ $item->kelas->nama_kelas }}</td>
                    <td>{{ $item->user->name ?? '-' }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4"><em>Tidak ada jadwal pemeriksaan pada periode ini.</em></td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="ttd-container">
        <div class="ttd-box">
            Kota Pintar, {{ now()->isoFormat('D MMMM Y') }}<br>
            Koordinator UKS,
            <div class="spasi-ttd"></div>
            <span class="fw-bold">( ............................................ )</span><br>
            NIP. ........................................
        </div>
    </div>

</body>
</html>