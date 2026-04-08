<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pemeriksaan Gizi - {{ $pemeriksaan->siswa->nama }}</title>
    <style>
        @page { margin: 1.5cm; }
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11pt;
            color: #000;
            line-height: 1.5;
        }

        /* Kop Surat Standar Formal */
        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h2 { margin: 0; font-size: 16pt; text-transform: uppercase; }
        .header p { margin: 2px 0; font-size: 9pt; }

        .title {
            text-align: center;
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 25px;
            text-decoration: underline;
        }

        /* Tabel Info Siswa (Tanpa Border) */
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table td { padding: 3px 0; }

        /* Tabel Data Hasil (Border Hitam Pekat) */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        .data-table th, .data-table td {
            border: 1px solid #000;
            padding: 8px 10px;
            text-align: left;
        }
        .bg-gray {
            background-color: #f2f2f2; /* Abu-abu sangat muda buat kontras saat print */
            font-weight: bold;
            width: 40%;
        }

        .footer {
            margin-top: 50px;
            width: 100%;
        }
        .ttd-box {
            float: right;
            width: 200px;
            text-align: center;
        }
        .spasi-ttd { height: 70px; }
    </style>
</head>
<body>

    <div class="header">
        <h2>SMK ASSALAAM BANDUNG</h2>
        <p>Jl. Situ Tarate, Cibaduyut, Dayeuhkolot, Kota Bandung, Jawa Barat 40265.</p>
        <p>Telepon: (022) 5420220 | Email: info@smkassalaam.sch.id</p>
    </div>

    <div class="title">LAPORAN HASIL PEMERIKSAAN STATUS GIZI</div>

    <table class="info-table">
        <tr>
            <td width="20%">Nama Siswa</td>
            <td width="80%">: <strong>{{ $pemeriksaan->siswa->nama }}</strong></td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td>: {{ $pemeriksaan->siswa->kelas->nama_kelas ?? '-' }}</td>
        </tr>
        <tr>
            <td>Tanggal Periksa</td>
            <td>: {{ \Carbon\Carbon::parse($pemeriksaan->tanggal)->isoFormat('D MMMM Y') }}</td>
        </tr>
    </table>

    <table class="data-table">
        @php
            $tinggiMeter = $pemeriksaan->tinggi_badan / 100;
            $bmi = $pemeriksaan->berat_badan / ($tinggiMeter * $tinggiMeter);
            
            if ($bmi < 18.5) {
                $status = 'Kekurangan Berat Badan (Kurus)';
            } elseif ($bmi >= 18.5 && $bmi <= 24.9) {
                $status = 'Normal (Ideal)';
            } elseif ($bmi >= 25 && $bmi <= 29.9) {
                $status = 'Kelebihan Berat Badan (Gemuk)';
            } else {
                $status = 'Obesitas';
            }
        @endphp
        <tr>
            <td class="bg-gray">Tinggi Badan</td>
            <td>{{ $pemeriksaan->tinggi_badan }} cm</td>
        </tr>
        <tr>
            <td class="bg-gray">Berat Badan</td>
            <td>{{ $pemeriksaan->berat_badan }} kg</td>
        </tr>
        <tr>
            <td class="bg-gray">Indeks Massa Tubuh (BMI)</td>
            <td>{{ number_format($bmi, 1) }}</td>
        </tr>
        <tr>
            <td class="bg-gray">Status Gizi</td>
            <td><strong>{{ $status }}</strong></td>
        </tr>
        <tr>
            <td class="bg-gray">Keterangan / Saran</td>
            <td>
                @if($bmi < 18.5)
                    Disarankan meningkatkan asupan nutrisi protein dan karbohidrat.
                @elseif($bmi >= 18.5 && $bmi <= 24.9)
                    Kondisi sangat baik. Pertahankan pola makan sehat dan olahraga.
                @else
                    Disarankan mengurangi asupan gula/lemak dan rutin beraktivitas fisik.
                @endif
            </td>
        </tr>
    </table>

    <div class="footer">
        <div class="ttd-box">
            Bandung, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}<br>
            Petugas Kesehatan UKS,
            <div class="spasi-ttd"></div>
            
            {{-- PAKAI TABEL BIAR PASTI SATU BARIS --}}
            <table style="width: 100%; border: none !important; margin: 0 auto;">
                <tr>
                    <td style="border: none !important; padding: 0; width: 5px;">(</td>
                    <td style="border: none !important; padding: 0; border-bottom: 1px solid #000 !important; text-align: center;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                    <td style="border: none !important; padding: 0; width: 5px;">)</td>
                </tr>
            </table>

            <div style="margin-top: 5px;">
                NIP. ........................................
            </div>
        </div>
    </div>

</body>
</html>