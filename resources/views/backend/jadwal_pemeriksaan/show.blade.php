@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Pemeriksaan /</span> Detail Jadwal
    </h4>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="mb-0 text-info fw-bold">
                        <i class="bx bx-info-circle me-1"></i> Informasi Lengkap Jadwal
                    </h5>
                    <span class="badge bg-label-info">ID: #{{ $jadwal_pemeriksaan->id }}</span>
                </div>
                <div class="card-body mt-4">
                    <div class="info-container">
                        <ul class="list-unstyled">
                            {{-- Tanggal --}}
                            <li class="mb-3 d-flex align-items-center">
                                <span class="fw-bold me-2 text-dark" style="min-width: 150px;">Tanggal:</span>
                                <span class="text-muted">
                                    <i class="bx bx-calendar-event me-1 text-primary"></i>
                                    {{ \Carbon\Carbon::parse($jadwal_pemeriksaan->tanggal)->format('d F Y') }}
                                </span>
                            </li>

                            {{-- Kelas --}}
                            <li class="mb-3 d-flex align-items-center">
                                <span class="fw-bold me-2 text-dark" style="min-width: 150px;">Kelas:</span>
                                <span>
                                    <span class="badge bg-label-primary fw-bold">
                                        {{ $jadwal_pemeriksaan->kelas->nama_kelas }}
                                    </span>
                                </span>
                            </li>

                            {{-- Petugas --}}
                            <li class="mb-3 d-flex align-items-center">
                                <span class="fw-bold me-2 text-dark" style="min-width: 150px;">Petugas Pelaksana:</span>
                                <span class="text-muted">
                                    <i class="bx bx-user-check me-1 text-success"></i>
                                    {{ $jadwal_pemeriksaan->user->name }}
                                </span>
                            </li>

                            {{-- Keterangan --}}
                            <li class="mb-3">
                                <span class="fw-bold text-dark d-block mb-2">Keterangan:</span>
                                <div class="p-3 bg-light rounded border">
                                    {{ $jadwal_pemeriksaan->keterangan ?? 'Tidak ada keterangan tambahan.' }}
                                </div>
                            </li>
                        </ul>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-start gap-2">
                        <a href="{{ route('backend.jadwal_pemeriksaan.index') }}" class="btn btn-outline-secondary">
                            <i class="bx bx-chevron-left me-1"></i> Kembali ke Daftar
                        </a>
                        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'petugas')
                            <a href="{{ route('backend.jadwal_pemeriksaan.edit', $jadwal_pemeriksaan->id) }}" class="btn btn-warning">
                                <i class="bx bx-edit-alt me-1"></i> Edit Jadwal
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection