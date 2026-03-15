@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Kesehatan /</span> Detail Rekam Medis
    </h4>

    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm mb-4">
                {{-- Header dengan Status --}}
                <div class="card-header d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="bx bx-file me-1"></i> Resume Medis Siswa
                    </h5>
                    @if ($rekam_medis->status === 'pulang')
                        <span class="badge bg-label-success">Siswa Pulang</span>
                    @elseif ($rekam_medis->status === 'uks')
                        <span class="badge bg-label-info">Istirahat di UKS</span>
                    @else
                        <span class="badge bg-label-primary">Kembali ke Kelas</span>
                    @endif
                </div>

                <div class="card-body mt-4">
                    <div class="row mb-4">
                        {{-- Info Pasien --}}
                        <div class="col-sm-6 mb-3">
                            <small class="text-muted text-uppercase fw-semibold d-block mb-2">Pasien</small>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-md me-3">
                                    <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-user"></i></span>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $rekam_medis->siswa->nama }}</h6>
                                    <small class="text-muted">ID Siswa: #{{ $rekam_medis->siswa->id }}</small>
                                </div>
                            </div>
                        </div>
                        {{-- Info Waktu --}}
                        <div class="col-sm-6 mb-3 text-sm-end">
                            <small class="text-muted text-uppercase fw-semibold d-block mb-2">Waktu Pemeriksaan</small>
                            <h6 class="mb-0 text-dark">
                                <i class="bx bx-calendar me-1"></i> {{ \Carbon\Carbon::parse($rekam_medis->tanggal)->format('d F Y') }}
                            </h6>
                            <small class="text-muted">Oleh: {{ $rekam_medis->user->name }}</small>
                        </div>
                    </div>

                    <div class="row g-4">
                        {{-- Keluhan --}}
                        <div class="col-12">
                            <div class="p-3 bg-label-danger rounded border border-danger border-dashed">
                                <h6 class="fw-bold text-danger mb-2"><i class="bx bx-error-alt me-1"></i> Keluhan Utama</h6>
                                <p class="mb-0 text-dark">{{ $rekam_medis->keluhan }}</p>
                            </div>
                        </div>

                        {{-- Tindakan --}}
                        <div class="col-12">
                            <h6 class="fw-bold mb-2"><i class="bx bx-first-aid me-1 text-success"></i> Tindakan yang Diberikan</h6>
                            <p class="text-muted ps-4 border-start border-2">{{ $rekam_medis->tindakan }}</p>
                        </div>

                        {{-- Obat --}}
                        <div class="col-12">
                            <h6 class="fw-bold mb-3"><i class="bx bx-capsule me-1 text-warning"></i> Pemberian Obat</h6>
                            @if ($rekam_medis->rekam_medis_obat->count())
                                <div class="list-group list-group-flush border rounded">
                                    @foreach ($rekam_medis->rekam_medis_obat as $item)
                                        <div class="list-group-item d-flex justify-content-between align-items-center p-3">
                                            <div class="d-flex align-items-center">
                                                <i class="bx bx-check-circle text-success me-2"></i>
                                                <span>{{ $item->obat->nama_obat }}</span>
                                            </div>
                                            <span class="badge bg-label-secondary fw-bold">
                                                {{ $item->jumlah }} {{ $item->obat->unit }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="p-3 bg-light rounded text-center">
                                    <small class="text-muted">Tidak ada obat yang diberikan.</small>
                                </div>
                            @endif
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- Footer Button --}}
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('backend.rekam_medis.index') }}" class="btn btn-outline-secondary">
                            <i class="bx bx-arrow-back me-1"></i> Kembali
                        </a>
                        <div class="d-flex gap-2">
                            <button onclick="window.print()" class="btn btn-outline-primary">
                                <i class="bx bx-printer me-1"></i> Cetak
                            </button>
                            <a href="{{ route('backend.rekam_medis.edit', $rekam_medis->id) }}" class="btn btn-warning">
                                <i class="bx bx-edit-alt me-1 text-white"></i> Edit Data
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .btn, .navbar, .menu-inner, .footer, .layout-navbar { display: none !important; }
        .card { border: none !important; shadow: none !important; }
        .container-xxl { margin: 0; padding: 0; }
    }
</style>
@endsection