@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 m-0">
            <span class="text-muted fw-light">Siswa /</span> Kondisi Kesehatan
        </h4>
        @auth
            @if(in_array(Auth::user()->role, ['admin', 'petugas']))
                <a href="{{ route('backend.kondisi_kesehatan.create') }}" class="btn btn-primary shadow">
                    <i class="bx bx-plus me-1"></i> Tambah Kondisi
                </a>
            @endif
        @endauth
    </div>

    <div class="card shadow-sm">
        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Daftar Riwayat Kesehatan Khusus</h5>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th style="width: 25%">Siswa</th>
                        <th>Kondisi / Penyakit</th>
                        <th>Tanggal Diagnosa</th>
                        <th>Keterangan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($kondisi_kesehatans as $item)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xs me-2">
                                    <span class="avatar-initial rounded-circle bg-label-info">
                                        {{ strtoupper(substr($item->siswa->nama, 0, 1)) }}
                                    </span>
                                </div>
                                <span class="fw-bold text-dark">{{ $item->siswa->nama }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-label-danger fw-bold">
                                <i class="bx bx-pulse me-1"></i> {{ $item->nama_kondisi }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center text-muted small">
                                <i class="bx bx-calendar me-1"></i>
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                            </div>
                        </td>
                        <td>
                            <span class="text-muted small">
                                {{ $item->keterangan ? Str::limit($item->keterangan, 40) : '-' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="{{ route('backend.kondisi_kesehatan.edit', $item->id) }}">
                                        <i class="bx bx-edit-alt me-1 text-warning"></i> Edit
                                    </a>
                                    {{-- Tambahkan aksi hapus jika diperlukan --}}
                                    <form action="{{ route('backend.kondisi_kesehatan.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        {{-- Hapus onsubmit, tambahkan class btn-delete dan data-name --}}
                                        <button type="submit" class="dropdown-item text-danger btn-delete" 
                                                data-name="Data Kondisi Kesehatan {{ $item->siswa->nama ?? 'ini' }}">
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
                            <i class="bx bx-shield-quarter mb-2 display-6"></i>
                            <p>Semua siswa dalam kondisi sehat atau data belum diinput.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection