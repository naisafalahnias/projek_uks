@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Laporan /</span> Pemeriksaan Gizi Siswa
    </h4>

    {{-- FILTER CARD --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Filter Pencarian</h5>
            <i class="bx bx-filter-alt"></i>
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Tanggal Awal</label>
                    <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Nama Siswa</label>
                    <select name="siswa_id" class="form-select select2">
                        <option value="">-- Semua Siswa --</option>
                        @foreach($siswas as $siswa)
                            <option value="{{ $siswa->id }}" {{ request('siswa_id') == $siswa->id ? 'selected' : '' }}>
                                {{ $siswa->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="bx bx-search me-1"></i> Filter</button>
                    <a href="{{ route('backend.pemeriksaan_gizi.laporan') }}" class="btn btn-outline-secondary"><i class="bx bx-refresh"></i></a>
                </div>
            </form>
        </div>
    </div>

    {{-- TABEL CARD --}}
    <div class="card shadow-sm">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">No</th>
                        <th>Siswa</th>
                        <th>Tanggal Periksa</th>
                        <th>Tinggi / Berat</th>
                        <th class="text-center">BMI</th>
                        <th class="text-center">Status Kirim</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($pemeriksaan_gizi as $i => $item)
                    <tr>
                        <td class="text-center">{{ $i+1 }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xs me-2">
                                    <span class="avatar-initial rounded-circle bg-label-info">{{ substr($item->siswa->nama, 0, 1) }}</span>
                                </div>
                                <span class="fw-bold">{{ $item->siswa->nama }}</span>
                            </div>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                        <td>
                            <span class="badge bg-label-secondary">{{ $item->tinggi_badan }} cm</span>
                            <span class="badge bg-label-secondary">{{ $item->berat_badan }} kg</span>
                        </td>
                        <td class="text-center">
                            @php
                                // Contoh Logika Warna BMI
                                $bmiColor = 'bg-success';
                                if($item->bmi < 18.5) $bmiColor = 'bg-warning';
                                elseif($item->bmi >= 25) $bmiColor = 'bg-danger';
                            @endphp
                            <span class="fw-bold text-dark">{{ $item->bmi }}</span>
                            <div class="progress mt-1" style="height: 4px;">
                                <div class="progress-bar {{ $bmiColor }}" style="width: {{ min(($item->bmi/40)*100, 100) }}%"></div>
                            </div>
                        </td>
                        <td class="text-center">
                            @if($item->status == 'draft')
                                <span class="badge bg-label-warning"><i class="bx bx-time-five me-1"></i>Draft</span>
                            @else
                                <span class="badge bg-label-success"><i class="bx bx-check-circle me-1"></i>Terbit</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('backend.pemeriksaan_gizi.exportPdf', $item->id) }}"
                                   class="btn btn-icon btn-outline-danger btn-sm" title="Download PDF">
                                    <i class="bx bxs-file-pdf"></i>
                                </a>

                                @if($item->status == 'draft')
                                <form action="{{ route('backend.pemeriksaan_gizi.publish', $item->id) }}"
                                      method="POST" onsubmit="return confirm('Kirim laporan ini ke email siswa?')">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-primary btn-sm">
                                        <i class="bx bx-paper-plane me-1"></i> Publish
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">Data tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection