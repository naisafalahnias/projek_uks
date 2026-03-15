@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Laporan /</span> Rekap Kunjungan Siswa
    </h4>

    {{-- Filter Card --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center border-bottom">
            <h5 class="mb-0"><i class="bx bx-filter-alt me-2 text-primary"></i>Filter Periode</h5>
        </div>
        <div class="card-body pt-4">
            <form method="GET" action="{{ route('backend.rekam_medis.laporan') }}">
                <div class="row align-items-end g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Dari Tanggal</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                            <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Sampai Tanggal</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="bx bx-calendar-check"></i></span>
                            <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100 shadow">
                                <i class="bx bx-search-alt me-1"></i> Terapkan Filter
                            </button>
                            <a href="{{ route('backend.rekam_medis.laporan') }}" class="btn btn-outline-secondary shadow-none">
                                <i class="bx bx-refresh"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Data Card --}}
    <div class="card shadow-sm">
        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-dark fw-bold">Hasil Rekapitulasi</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('backend.rekam_medis.export.excel', request()->all()) }}" class="btn btn-label-success shadow-sm" target="_blank">
                    <i class="bx bxs-file-export me-1"></i> Excel
                </a>
                <a href="{{ route('backend.rekam_medis.export.pdf', request()->all()) }}" class="btn btn-label-danger shadow-sm" target="_blank">
                    <i class="bx bxs-file-pdf me-1"></i> PDF
                </a>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th>Waktu Kunjungan</th>
                        <th>Keluhan Utama</th>
                        <th class="text-center">Tindak Lanjut</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($rekam_medis as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td><span class="fw-bold text-dark">{{ $item->siswa->nama }}</span></td>
                            <td><span class="badge bg-label-secondary">{{ $item->siswa->kelas->nama_kelas ?? '-' }}</span></td>
                            <td>
                                <small class="text-muted">
                                    <i class="bx bx-time-five me-1"></i>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                                </small>
                            </td>
                            <td><span class="text-truncate" style="max-width: 200px; display: inline-block;">{{ $item->keluhan }}</span></td>
                            <td class="text-center">
                                @php
                                    $badgeClass = 'bg-label-secondary';
                                    $statusText = ucfirst($item->status);
                                    
                                    if ($item->status === 'pulang') {
                                        $badgeClass = 'bg-label-success';
                                        $statusText = 'Dipulangkan';
                                    } elseif ($item->status === 'uks') {
                                        $badgeClass = 'bg-label-info';
                                        $statusText = 'Istirahat di UKS';
                                    } elseif ($item->status === 'kelas') {
                                        $badgeClass = 'bg-label-primary';
                                        $statusText = 'Kembali ke Kelas';
                                    }
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $statusText }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <img src="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/img/illustrations/page-misc-error-light.png" width="120" class="mb-3" alt="No data">
                                <p class="text-muted">Ops! Tidak ditemukan data kunjungan pada periode ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection