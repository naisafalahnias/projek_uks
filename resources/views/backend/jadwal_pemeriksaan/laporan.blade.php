@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Laporan /</span> Jadwal Pemeriksaan
    </h4>

    {{-- Filter Card --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center border-bottom">
            <h5 class="mb-0"><i class="bx bx-filter-alt me-2 text-primary"></i>Filter Periode Jadwal</h5>
        </div>
        <div class="card-body pt-4">
            <form method="GET" action="{{ route('backend.jadwal_pemeriksaan.laporan') }}">
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
                                <i class="bx bx-show me-1"></i> Tampilkan
                            </button>
                            <a href="{{ route('backend.jadwal_pemeriksaan.laporan') }}" class="btn btn-outline-secondary shadow-none">
                                <i class="bx bx-refresh"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if (request('tanggal_awal'))
    {{-- Hasil Laporan Card --}}
    <div class="card shadow-sm">
        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-dark fw-bold">Daftar Jadwal Pemeriksaan</h5>
            @if($jadwal->count() > 0)
            <div class="d-flex gap-2">
                <form action="{{ route('backend.jadwal_pemeriksaan.export.pdf') }}" method="GET" target="_blank">
                    <input type="hidden" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
                    <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                    <button type="submit" class="btn btn-label-danger shadow-sm">
                        <i class="bx bxs-file-pdf me-1"></i> Export PDF
                    </button>
                </form>
            </div>
            @endif
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Tanggal</th>
                        <th>Kelas</th>
                        <th>Petugas Pelaksana</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($jadwal as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="bx bx-calendar-event me-2 text-primary"></i>
                                    <span class="fw-semibold">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-label-info fw-bold">
                                    {{ $item->kelas->nama_kelas }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="bx bx-user-check me-2 text-success"></i>
                                    {{ $item->user->name ?? '-' }}
                                </div>
                            </td>
                            <td>
                                <small class="text-muted">{{ $item->keterangan ?? 'Tidak ada keterangan' }}</small>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="bx bx-info-circle display-4 text-muted mb-2"></i>
                                    <p class="text-muted">Tidak ditemukan jadwal pemeriksaan pada periode ini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="alert alert-primary d-flex align-items-center" role="alert">
        <span class="badge badge-center rounded-pill bg-primary me-3"><i class="bx bx-info-circle"></i></span>
        <span>Silakan pilih rentang tanggal terlebih dahulu untuk menampilkan laporan.</span>
    </div>
    @endif
</div>
@endsection