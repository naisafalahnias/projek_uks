@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Kantin /</span> Detail Riwayat Konsumsi
    </h4>

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-primary">Ringkasan Asupan Gizi</h5>
                    <i class="bx bx-receipt fs-4 text-muted"></i>
                </div>
                <div class="card-body pt-4">
                    {{-- Profil Singkat Siswa --}}
                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                        <div class="avatar avatar-md me-3">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bx-user fs-3"></i>
                            </span>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">{{ $konsumsi->siswa->nama }}</h5>
                            <small class="text-muted">Tanggal: {{ \Carbon\Carbon::parse($konsumsi->tanggal)->format('d F Y') }}</small>
                        </div>
                    </div>

                    {{-- Detail Nutrisi --}}
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless">
                            <tbody>
                                <tr>
                                    <td class="py-2 text-muted" width="40%">Menu Makanan</td>
                                    <td class="py-2 fw-bold text-dark">: {{ $konsumsi->makanan->nama_makanan }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-muted">Kategori</td>
                                    <td class="py-2">: <span class="text-capitalize">{{ $konsumsi->makanan->jenis }}</span></td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-muted">Kalori per Porsi</td>
                                    <td class="py-2">: {{ $konsumsi->makanan->kalori }} kcal</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-muted">Jumlah Dikonsumsi</td>
                                    <td class="py-2">: {{ $konsumsi->jumlah }} Porsi</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Total Highlight --}}
                    <div class="mt-4 p-3 bg-label-success rounded border border-success border-dashed text-center">
                        <p class="mb-1 small text-uppercase fw-bold">Total Asupan Energi</p>
                        <h3 class="mb-0 fw-bold text-success">{{ $konsumsi->total_kalori }} <span class="fs-6 fw-normal text-muted">kcal</span></h3>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4 pt-2">
                        <a href="{{ route('backend.konsumsi_makanan.index') }}" class="btn btn-outline-secondary">
                            <i class="bx bx-chevron-left me-1"></i> Kembali
                        </a>

                        @auth
                            @if(in_array(Auth::user()->role, ['admin', 'petugas']))
                                <a href="{{ route('backend.konsumsi_makanan.edit', $konsumsi->id) }}" class="btn btn-warning shadow">
                                    <i class="bx bx-edit-alt me-1"></i> Edit Data
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
            
            <div class="text-center">
                <small class="text-muted">
                    <i class="bx bx-info-circle me-1"></i> 
                    Data ini digunakan untuk pemantauan gizi harian siswa melalui UKS.
                </small>
            </div>
        </div>
    </div>
</div>
@endsection