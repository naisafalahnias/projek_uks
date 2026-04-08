@extends('layouts.siswa_backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    
    {{-- Header Profil --}}
    <div class="card mb-4 border-0 shadow-sm bg-primary text-white">
        <div class="card-body d-flex align-items-center p-4">
            <div class="avatar avatar-xl me-3 border border-2 border-white rounded-circle p-1">
                <span class="avatar-initial rounded-circle bg-white text-primary"><i class="bx bx-user fs-1"></i></span>
            </div>
            <div>
                <h4 class="text-white mb-0 fw-bold">{{ $siswa->nama }}</h4>
                <p class="mb-0 opacity-75">Kelas: {{ $siswa->kelas->nama_kelas ?? '-' }}</p>
            </div>
        </div>
    </div>

    {{-- Navigasi Tab --}}
    <div class="nav-align-top mb-4">
        <ul class="nav nav-tabs border-bottom-0 shadow-sm bg-white rounded-top" role="tablist">
            <li class="nav-item">
                <button type="button" class="nav-link active fw-bold" role="tab" data-bs-toggle="tab" data-bs-target="#navs-ringkasan">
                    <i class="bx bx-home-alt me-1"></i> Ringkasan
                </button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link fw-bold" role="tab" data-bs-toggle="tab" data-bs-target="#navs-riwayat">
                    <i class="bx bx-history me-1"></i> Riwayat Medis
                </button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link fw-bold" role="tab" data-bs-toggle="tab" data-bs-target="#navs-kalori">
                    <i class="bx bx-bolt-circle me-1"></i> Kebutuhan Kalori
                </button>
            </li>
        </ul>

        <div class="tab-content bg-white shadow-sm rounded-bottom border-top-0 p-4">
            
            {{-- TAB 1: RINGKASAN --}}
            <div class="tab-pane fade show active" id="navs-ringkasan" role="tabpanel">
                {{-- Alert Kondisi Khusus --}}
                @if($kondisiKesehatan)
                <div class="alert alert-danger d-flex align-items-center mb-4 shadow-sm" role="alert">
                    <span class="badge badge-center rounded-pill bg-danger me-3"><i class="bx bx-error fs-4"></i></span>
                    <div>
                        {{-- Ganti 'kondisi' menjadi 'nama_kondisi' --}}
                        <h6 class="mb-0 text-danger fw-bold">Peringatan Medis: {{ strtoupper($kondisiKesehatan->nama_kondisi) }}</h6>
                        
                        <small class="text-dark">
                            @if($kondisiKesehatan->keterangan && $kondisiKesehatan->keterangan != '-')
                                <strong>Instruksi:</strong> {{ $kondisiKesehatan->keterangan }}
                            @else
                                Harap segera melapor ke petugas UKS jika merasa gejala terkait kondisi ini muncul.
                            @endif
                        </small>
                    </div>
                </div>
                @endif

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h6>Status Gizi Terakhir</h6>
                        <div class="p-3 border rounded bg-light">
                            @if($giziTerakhir)
                                {{-- Badge Status IMT --}}
                                @php
                                    $imt = $giziTerakhir->imt > 0 ? $giziTerakhir->imt : ($giziTerakhir->berat_badan / pow($giziTerakhir->tinggi_badan/100, 2));
                                    $status_label = $imt < 18.5 ? 'Kurus' : ($imt <= 25 ? 'Normal (Ideal)' : 'Kelebihan Berat Badan');
                                    $status_color = $imt < 18.5 ? 'warning' : ($imt <= 25 ? 'success' : 'danger');
                                @endphp
                                <h4 class="fw-bold text-{{ $status_color }} mb-1">{{ $status_label }}</h4>
                                <small class="text-muted">TB: {{ $giziTerakhir->tinggi_badan }}cm | BB: {{ $giziTerakhir->berat_badan }}kg | IMT: {{ number_format($imt, 1) }}</small>
                            @else
                                <p class="mb-0 text-muted">Belum ada data gizi.</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6>Info Personal</h6>
                        <ul class="list-group list-group-flush small">
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span>Jenis Kelamin</span><span class="fw-bold">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span>Usia</span><span class="fw-bold">{{ $siswa->usia }} Tahun</span>
                            </li>
                            {{-- Tambah info wali/orang tua kalau ada --}}
                            <li class="list-group-item d-flex justify-content-between px-0 border-bottom-0 text-primary">
                                <span>Status Akun</span><span class="badge bg-label-primary">Aktif</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- TAB 2: RIWAYAT MEDIS + TOMBOL CETAK --}}
            <div class="tab-pane fade" id="navs-riwayat" role="tabpanel">
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Keluhan</th>
                                <th>Tindakan</th>
                                <th>Status</th>
                                <th class="text-center">Cetak</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rekamMedis as $rm)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($rm->tanggal)->format('d/m/Y') }}</td>
                                <td>{{ Str::limit($rm->keluhan, 25) }}</td>
                                <td>{{ Str::limit($rm->tindakan, 25) }}</td>
                                <td>
                                    @php
                                        $color = $rm->status == 'pulang' ? 'success' : ($rm->status == 'uks' ? 'info' : 'primary');
                                    @endphp
                                    <span class="badge bg-label-{{ $color }}">{{ ucfirst($rm->status) }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('siswa.rekam_medis.pdf', $rm->id) }}" target="_blank" class="btn btn-sm btn-icon btn-outline-danger shadow-sm" title="Cetak PDF">
                                        <i class="bx bxs-file-pdf"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center py-4">Tidak ada riwayat kesehatan yang tercatat.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- TAB 3: ANALISIS KESEHATAN & KALORI --}}
            <div class="tab-pane fade" id="navs-kalori" role="tabpanel">
                @if($giziTerakhir)
                    @php
                        // Perhitungan Kalori
                        if($siswa->jenis_kelamin == 'L') {
                            $bmr = (10 * $giziTerakhir->berat_badan) + (6.25 * $giziTerakhir->tinggi_badan) - (5 * $siswa->usia) + 5;
                        } else {
                            $bmr = (10 * $giziTerakhir->berat_badan) + (6.25 * $giziTerakhir->tinggi_badan) - (5 * $siswa->usia) - 161;
                        }
                        $kaloriHarian = $bmr * 1.375; // Activity factor: Lightly active

                        // Logika Rekomendasi berdasarkan IMT
                        $imt = $giziTerakhir->imt > 0 ? $giziTerakhir->imt : ($giziTerakhir->berat_badan / pow($giziTerakhir->tinggi_badan/100, 2));
                        
                        if ($imt < 18.5) {
                            $saran_makan = "Perbanyak asupan protein (telur, ayam, tempe) dan karbohidrat kompleks.";
                            $kurangi = "Kurangi minuman berkafein yang menekan nafsu makan.";
                            $olahraga = "Latihan beban ringan untuk membentuk massa otot.";
                            $icon = "bx-trending-up text-warning";
                        } elseif ($imt <= 25) {
                            $saran_makan = "Pertahankan pola makan 4 sehat 5 sempurna dengan porsi seimbang.";
                            $kurangi = "Kurangi camilan tinggi gula (ultra-processed food).";
                            $olahraga = "Olahraga rutin 150 menit/minggu (jogging, bersepeda, atau renang).";
                            $icon = "bx-check-double text-success";
                        } else {
                            $saran_makan = "Perbanyak konsumsi serat (sayur & buah) dan kurangi porsi nasi.";
                            $kurangi = "Hindari gorengan, santan berlebih, dan minuman manis.";
                            $olahraga = "Aktivitas kardio (jalan cepat, lompat tali) untuk membakar lemak.";
                            $icon = "bx-trending-down text-danger";
                        }
                    @endphp

                    <div class="text-center mb-4">
                        <h5 class="mb-1">Estimasi Kebutuhan Energi</h5>
                        <div class="display-5 fw-bold text-primary">{{ number_format($kaloriHarian, 0) }} <small class="fs-4 text-muted">kkal/hari</small></div>
                        <p class="text-muted small">Angka ini adalah energi yang kamu butuhkan untuk beraktivitas sehari-hari.</p>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card bg-label-primary border-0 shadow-none">
                                <div class="card-body">
                                    <h6 class="fw-bold d-flex align-items-center"><i class="bx bx-restaurant me-2"></i> Pola Makan</h6>
                                    <ul class="list-unstyled mb-0 small">
                                        <li class="mb-2 text-dark"><i class="bx bx-check me-1 text-success"></i> <strong>Saran:</strong> {{ $saran_makan }}</li>
                                        <li class="text-dark"><i class="bx bx-x me-1 text-danger"></i> <strong>Batasi:</strong> {{ $kurangi }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card bg-label-info border-0 shadow-none">
                                <div class="card-body">
                                    <h6 class="fw-bold d-flex align-items-center"><i class="bx bx-run me-2"></i> Aktivitas Fisik</h6>
                                    <p class="small text-dark mb-0">
                                        <strong>Saran Olahraga:</strong><br>
                                        {{ $olahraga }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 alert alert-warning d-flex align-items-center" role="alert">
                        <i class="bx bx-info-circle me-2"></i>
                        <div class="small">
                            Hasil ini bersifat estimasi. Untuk konsultasi lebih lanjut mengenai diet dan kesehatan, silakan temui petugas di UKS.
                        </div>
                    </div>

                @else
                    <div class="text-center py-5">
                        <i class="bx bx-shield-quarter fs-1 text-muted mb-3"></i>
                        <h5>Data Gizi Belum Lengkap</h5>
                        <p class="text-muted">Sistem tidak bisa memberikan rekomendasi karena kamu belum melakukan pengecekan TB/BB terbaru.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection