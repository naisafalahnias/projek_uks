@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 m-0">
            <span class="text-muted fw-light">Kesehatan /</span> Kebutuhan Kalori Siswa
        </h4>
        @auth
            @if(in_array(Auth::user()->role, ['admin', 'petugas']))
                <a href="{{ route('backend.kebutuhan_kalori.create') }}" class="btn btn-primary shadow">
                    <i class="bx bx-plus me-1"></i> Tambah Target Kalori
                </a>
            @endif
        @endauth
    </div>

    <div class="card shadow-sm">
        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Rekomendasi Energi Harian</h5>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Siswa</th>
                        <th>Kebutuhan Harian (BMR/TDEE)</th>
                        <th>Tingkat Aktivitas</th>
                        <th>Update Terakhir</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($kebutuhanKalori as $item)
                    <tr>
                        {{-- Siswa --}}
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xs me-2">
                                    <span class="avatar-initial rounded-circle bg-label-info">
                                        <i class="bx bx-user"></i>
                                    </span>
                                </div>
                                <span class="fw-bold text-dark">{{ $item->siswa->nama }}</span>
                            </div>
                        </td>

                        {{-- Kalori --}}
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-label-primary fs-6">
                                    {{ number_format($item->kebutuhan_harian, 0, ',', '.') }} kcal
                                </span>
                            </div>
                        </td>

                        {{-- Aktivitas dengan Badge Warna Berbeda --}}
                        <td>
                            @php
                                $act = strtolower($item->tingkat_aktivitas);
                                $color = 'bg-label-secondary';
                                if(str_contains($act, 'ringan')) $color = 'bg-label-info';
                                elseif(str_contains($act, 'sedang')) $color = 'bg-label-warning';
                                elseif(str_contains($act, 'berat') || str_contains($act, 'aktif')) $color = 'bg-label-danger';
                            @endphp
                            <span class="badge {{ $color }} text-capitalize">
                                <i class="bx bx-run me-1"></i> {{ $item->tingkat_aktivitas }}
                            </span>
                        </td>

                        {{-- Tanggal --}}
                        <td>
                            <small class="text-muted">
                                <i class="bx bx-time-five me-1"></i>
                                {{ $item->created_at->format('d M Y') }}
                            </small>
                        </td>

                        {{-- Aksi --}}
                        <td class="text-center">
                            @auth
                                @if(in_array(Auth::user()->role, ['admin', 'petugas']))
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end shadow">
                                        <a class="dropdown-item" href="{{ route('backend.kebutuhan_kalori.edit', $item->id) }}">
                                            <i class="bx bx-edit-alt me-1 text-warning"></i> Edit
                                        </a>
                                        <form action="{{ route('backend.kebutuhan_kalori.destroy', $item->id) }}" method="POST">                                            
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger btn-delete" data-name="Hitungan Kalori {{ $item->siswa->nama ?? 'ini' }}">
                                                <i class="bx bx-trash me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endif
                            @endauth
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bx bx-calculation mb-2 display-6"></i>
                            <p>Data kebutuhan kalori siswa belum dikalkulasi.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection