@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 m-0"><span class="text-muted fw-light">Pemeriksaan /</span> Jadwal</h4>
        @auth
            @if(in_array(Auth::user()->role, ['admin', 'petugas']))
                <a href="{{ route('backend.jadwal_pemeriksaan.create') }}" class="btn btn-primary shadow">
                    <i class="bx bx-calendar-plus me-1"></i> Tambah Jadwal
                </a>
            @endif
        @endauth
    </div>

    <div class="card shadow-sm">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-0">Agenda Pemeriksaan Kesehatan</h5>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th style="width: 15%">Tanggal</th>
                        <th>Kelas</th>
                        <th>Petugas Pelaksana</th>
                        <th>Keterangan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($jadwal_pemeriksaan as $data)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="bx bx-calendar text-primary me-2"></i>
                                <span class="fw-bold">{{ \Carbon\Carbon::parse($data->tanggal)->format('d M Y') }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-label-info fw-bold">
                                <i class="bx bx-buildings me-1"></i> {{ $data->kelas->nama_kelas }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xs me-2">
                                    <span class="avatar-initial rounded-circle bg-label-primary small">
                                        {{ strtoupper(substr($data->user->name, 0, 1)) }}
                                    </span>
                                </div>
                                <span>{{ $data->user->name }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="text-muted small">{{ Str::limit($data->keterangan, 40) }}</span>
                        </td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="{{ route('backend.jadwal_pemeriksaan.edit', $data->id) }}">
                                        <i class="bx bx-edit-alt me-1 text-warning"></i> Edit
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <form action="{{ route('backend.jadwal_pemeriksaan.destroy', $data->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="dropdown-item text-danger btn-delete" 
                                                data-name="Jadwal {{ $data->nama_kegiatan }}">
                                            <i class="bx bx-trash me-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bx bx-calendar-x mb-2 display-6"></i>
                            <p>Belum ada jadwal pemeriksaan yang dibuat.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection