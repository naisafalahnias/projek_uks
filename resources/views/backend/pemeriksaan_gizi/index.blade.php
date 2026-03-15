@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 m-0">
            <span class="text-muted fw-light">Kesehatan /</span> Pemeriksaan Gizi
        </h4>
        @auth
            @if(in_array(Auth::user()->role, ['admin', 'petugas']))
                <a href="{{ route('backend.pemeriksaan_gizi.create') }}" class="btn btn-primary shadow">
                    <i class="bx bx-plus me-1"></i> Tambah Data Gizi
                </a>
            @endif
        @endauth
    </div>

    <div class="card shadow-sm">
        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Riwayat Antropometri Siswa</h5>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Siswa</th>
                        <th>Tanggal</th>
                        <th>BB (kg)</th>
                        <th>TB (cm)</th>
                        <th>BMI</th>
                        <th>Petugas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($pemeriksaan_gizi as $item)
                    <tr>
                        {{-- Siswa --}}
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xs me-2">
                                    <span class="avatar-initial rounded-circle bg-label-success">
                                        <i class="bx bx-user"></i>
                                    </span>
                                </div>
                                <span class="fw-bold text-dark">{{ $item->siswa->nama }}</span>
                            </div>
                        </td>

                        {{-- Tanggal --}}
                        <td>
                            <div class="small">
                                <i class="bx bx-calendar me-1"></i>
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                            </div>
                        </td>

                        {{-- BB & TB --}}
                        <td><span class="badge bg-label-secondary">{{ $item->berat_badan }} kg</span></td>
                        <td><span class="badge bg-label-secondary">{{ $item->tinggi_badan }} cm</span></td>

                        {{-- BMI dengan logic warna sederhana --}}
                        <td>
                            @php
                                $bmiColor = 'bg-label-primary';
                                if($item->bmi < 18.5) $bmiColor = 'bg-label-warning';
                                elseif($item->bmi >= 18.5 && $item->bmi <= 25) $bmiColor = 'bg-label-success';
                                elseif($item->bmi > 25) $bmiColor = 'bg-label-danger';
                            @endphp
                            <span class="badge {{ $bmiColor }} fw-bold">
                                <i class="bx bx-stats me-1"></i> {{ number_format($item->bmi, 1) }}
                            </span>
                        </td>

                        {{-- Petugas --}}
                        <td>
                            <small class="text-muted text-truncate" style="max-width: 100px; display: inline-block;">
                                {{ $item->petugas->name ?? '-' }}
                            </small>
                        </td>

                        {{-- Aksi --}}
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end shadow">
                                    <a class="dropdown-item" href="{{ route('backend.pemeriksaan_gizi.edit', $item->id) }}">
                                        <i class="bx bx-edit-alt me-1 text-warning"></i> Edit
                                    </a>
                                    <form action="{{ route('backend.pemeriksaan_gizi.destroy', $item->id) }}" method="POST" 
                                          onsubmit="return confirm('Hapus data gizi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bx bx-trash me-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bx bx-dish mb-2 display-6"></i>
                            <p>Belum ada catatan pemeriksaan gizi.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection