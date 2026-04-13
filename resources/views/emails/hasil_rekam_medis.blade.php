<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f9; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #696CFF, #8183FF); padding: 32px 30px; text-align: center; }
        .header h1 { color: white; margin: 0; font-size: 24px; font-weight: 800; }
        .header p { color: rgba(255,255,255,0.85); margin: 6px 0 0; font-size: 14px; }
        .body { padding: 30px; }
        .greeting { font-size: 16px; color: #333; margin-bottom: 8px; }
        .greeting strong { color: #696CFF; }
        .desc { font-size: 14px; color: #566A7F; margin-bottom: 24px; }
        .info-box { background: #f5f5f9; border-radius: 10px; padding: 16px 20px; margin-bottom: 24px; border-left: 4px solid #696CFF; }
        .info-box p { margin: 5px 0; color: #566A7F; font-size: 14px; }
        .info-box strong { color: #333; }
        .section-title { font-size: 15px; font-weight: 700; color: #333; margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 24px; border-radius: 10px; overflow: hidden; }
        th { background: #696CFF; color: white; padding: 12px 14px; text-align: left; font-size: 13px; font-weight: 600; }
        td { padding: 11px 14px; border-bottom: 1px solid #f0f0f0; font-size: 13px; color: #566A7F; vertical-align: top; }
        tr:last-child td { border-bottom: none; }
        tr:nth-child(even) td { background: #fafafa; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; }
        .badge-green { background: #e8fadf; color: #5cb85c; }
        .badge-orange { background: #fff2d6; color: #FFAB00; }
        .badge-red { background: #ffe5e0; color: #FF3E1D; }
        .badge-blue { background: #e7e7ff; color: #696CFF; }
        .empty-state { text-align: center; padding: 30px; color: #aaa; font-size: 14px; }
        .footer { text-align: center; padding: 20px 30px; color: #aaa; font-size: 12px; border-top: 1px solid #f0f0f0; background: #fafafa; }
        .footer p { margin: 3px 0; }
        .divider { height: 1px; background: #f0f0f0; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🏥 MediSchool</h1>
            <p>Laporan Rekam Medis Siswa</p>
        </div>

        <!-- Body -->
        <div class="body">
            <p class="greeting">Halo, <strong>{{ $siswa->nama }}</strong>!</p>
            <p class="desc">
                Berikut adalah riwayat lengkap rekam medis kamu di UKS MediSchool. 
                Dokumen ini dikirim oleh petugas UKS sekolah.
            </p>

            <!-- Info Siswa -->
            <div class="info-box">
                <p><strong>Nama Lengkap:</strong> {{ $siswa->nama }}</p>
                <p><strong>Kelas:</strong> {{ $siswa->kelas->nama_kelas ?? '-' }}</p>
                <p><strong>Total Kunjungan:</strong> {{ count($rekamMedis) }} kali</p>
                <p><strong>Tanggal Dikirim:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }} WIB</p>
            </div>

            <!-- Tabel Rekam Medis -->
            <p class="section-title">📋 Riwayat Rekam Medis</p>

            @if(count($rekamMedis) > 0)
            <table>
                <thead>
                    <tr>
                        <th style="width:15%">Tanggal</th>
                        <th style="width:30%">Keluhan</th>
                        <th style="width:35%">Tindakan</th>
                        <th style="width:20%">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rekamMedis as $rekam)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($rekam->tanggal)->format('d/m/Y') }}</td>
                        <td>{{ $rekam->keluhan }}</td>
                        <td>{{ $rekam->tindakan }}</td>
                        <td>
                            @php
                                $status = strtolower($rekam->status ?? '');
                            @endphp
                            @if(str_contains($status, 'pulang'))
                                <span class="badge badge-red">Pulang</span>
                            @elseif(str_contains($status, 'uks') || str_contains($status, 'istirahat'))
                                <span class="badge badge-orange">UKS</span>
                            @elseif(str_contains($status, 'kelas'))
                                <span class="badge badge-green">Kelas</span>
                            @else
                                <span class="badge badge-blue">{{ $rekam->status }}</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <p>📭 Belum ada rekam medis yang tercatat.</p>
            </div>
            @endif

            <div class="divider"></div>
            <p style="font-size:13px;color:#888;text-align:center">
                Jika ada pertanyaan mengenai data ini, silakan hubungi petugas UKS sekolah.
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Email ini dikirim otomatis oleh sistem <strong>MediSchool</strong>.</p>
            <p>Jangan balas email ini langsung.</p>
            <p style="margin-top:8px">© {{ date('Y') }} MediSchool. All rights reserved.</p>
        </div>
    </div>
</body>
</html>