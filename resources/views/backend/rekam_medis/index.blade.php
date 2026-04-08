@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 m-0"><span class="text-muted fw-light">Kesehatan /</span> Rekam Medis</h4>
        @auth
            @if(in_array(Auth::user()->role, ['admin', 'petugas']))
                <a href="{{ route('backend.rekam_medis.create') }}" class="btn btn-primary shadow">
                    <i class="bx bx-plus me-1"></i> Tambah Rekam Medis
                </a>
            @endif
        @endauth
    </div>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-label-success alert-dismissible fade show" role="alert">
            <div class="d-flex">
                <i class="bx bx-check-circle me-2"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-0">Riwayat Kesehatan Siswa</h5>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Siswa</th>
                        <th>Waktu & Petugas</th>
                        <th>Keluhan & Tindakan</th>
                        <th>Pemberian Obat</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($rekam_medis as $data)
                    <tr>
                        {{-- Siswa --}}
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xs me-2">
                                    <span class="avatar-initial rounded-circle bg-label-secondary"><i class="bx bx-user"></i></span>
                                </div>
                                <span class="fw-bold text-dark">{{ $data->siswa->nama ?? '-' }}</span>
                            </div>
                        </td>

                        {{-- Tanggal & Petugas --}}
                        <td>
                            <div class="d-flex flex-column">
                                <small class="fw-semibold text-primary"><i class="bx bx-calendar-alt small"></i> {{ \Carbon\Carbon::parse($data->tanggal)->format('d/m/Y') }}</small>
                                <small class="text-muted"><i class="bx bx-user-voice small"></i> {{ $data->user->name }}</small>
                            </div>
                        </td>

                        {{-- Keluhan & Tindakan --}}
                        <td style="max-width: 250px; white-space: normal;">
                            <div class="mb-1"><strong>K:</strong> <span class="text-muted small">{{ $data->keluhan }}</span></div>
                            <div><strong>T:</strong> <span class="text-muted small">{{ $data->tindakan }}</span></div>
                        </td>

                        {{-- Obat --}}
                        <td>
                            @if ($data->rekam_medis_obat->count())
                                <span class="badge bg-label-warning small">
                                    <i class="bx bx-capsule me-1"></i>
                                    {{ $data->rekam_medis_obat->pluck('obat.nama_obat')->implode(', ') }}
                                </span>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td>
                            @if ($data->status === 'pulang')
                                <span class="badge bg-label-success">Pulang</span>
                            @elseif ($data->status === 'uks')
                                <span class="badge bg-label-info">Di UKS</span>
                            @elseif ($data->status === 'kelas')
                                <span class="badge bg-label-primary">Kembali Ke Kelas</span>
                            @else
                                <span class="badge bg-label-secondary">{{ ucfirst($data->status) }}</span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="text-center">
                            @if(auth()->user()->role !== 'siswa')
                                {{-- Ini tampilan buat Admin/Petugas (Dropdown Edit/Hapus) --}}
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end shadow">
                                        <a class="dropdown-item" href="{{ route('backend.rekam_medis.show', $data->id) }}">
                                            <i class="bx bx-show-alt me-1 text-info"></i> Detail
                                        </a>
                                        <a class="dropdown-item" href="{{ route('backend.rekam_medis.edit', $data->id) }}">
                                            <i class="bx bx-edit-alt me-1 text-warning"></i> Edit
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <form action="{{ route('backend.rekam_medis.destroy', $data->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            {{-- Hapus onsubmit manual, tambahkan class btn-delete dan data-name --}}
                                            <button class="dropdown-item text-danger btn-delete" 
                                                    type="submit" 
                                                    data-name="Rekam Medis {{ $data->siswa->nama ?? 'Siswa' }}">
                                                <i class="bx bx-trash me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                {{-- Ini tampilan buat SISWA (Cuma tombol PDF) --}}
                                <a href="{{ route('siswa.rekam_medis.pdf', $data->id) }}" class="btn btn-sm btn-outline-danger shadow-sm">
                                    <i class="bx bxs-file-pdf me-1"></i> Download PDF
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection