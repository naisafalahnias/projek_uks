@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 m-0">
            <span class="text-muted fw-light">Kantin /</span> Konsumsi Makanan Siswa
        </h4>
        @auth
            @if(in_array(Auth::user()->role, ['admin', 'petugas']))
                <a href="{{ route('backend.konsumsi_makanan.create') }}" class="btn btn-primary shadow">
                    <i class="bx bx-plus me-1"></i> Catat Konsumsi
                </a>
            @endif
        @endauth
    </div>

    <div class="card shadow-sm">
        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Riwayat Makan Siswa</h5>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Siswa</th>
                        <th>Menu Makanan</th>
                        <th>Waktu</th>
                        <th class="text-center">Jumlah</th>
                        <th>Total Energi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    {{-- PERBAIKAN: Gunakan $konsumsi sesuai Controller --}}
                    @forelse ($konsumsi as $item)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xs me-2">
                                    <span class="avatar-initial rounded-circle bg-label-primary">
                                        {{-- PERBAIKAN: Langsung ke relasi siswa --}}
                                        {{ strtoupper(substr($item->siswa->nama, 0, 1)) }}
                                    </span>
                                </div>
                                <span class="fw-bold text-dark">{{ $item->siswa->nama }}</span>
                            </div>
                        </td>

                        <td>
                            <div class="d-flex flex-column">
                                <span class="text-dark fw-semibold">{{ $item->makanan->nama_makanan }}</span>
                                <small class="text-muted text-capitalize">{{ $item->makanan->jenis }}</small>
                            </div>
                        </td>

                        <td>
                            <small class="text-muted">
                                <i class="bx bx-calendar-event me-1"></i>
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                            </small>
                        </td>

                        <td class="text-center">
                            <span class="badge badge-center rounded-pill bg-label-secondary">{{ $item->jumlah }}</span>
                        </td>

                        <td>
                            <span class="badge bg-label-info fw-bold">
                                <i class="bx bx-bolt-circle me-1"></i> {{ $item->total_kalori }} kcal
                            </span>
                        </td>

                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end shadow">
                                    <a class="dropdown-item" href="{{ route('backend.konsumsi_makanan.show', $item->id) }}">
                                        <i class="bx bx-show me-1 text-info"></i> Detail
                                    </a>
                                    
                                    @if(in_array(Auth::user()->role, ['admin', 'petugas']))
                                    <a class="dropdown-item" href="{{ route('backend.konsumsi_makanan.edit', $item->id) }}">
                                        <i class="bx bx-edit-alt me-1 text-warning"></i> Edit
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <form action="{{ route('backend.konsumsi_makanan.destroy', $item->id) }}" method="POST" >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger btn-delete" data-name="Catatan Konsumsi {{ $item->siswa->nama ?? 'ini' }}">
                                            <i class="bx bx-trash me-1"></i> Hapus
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bx bx-history mb-2 display-6"></i>
                            <p>Belum ada catatan konsumsi makanan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection