@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 m-0"><span class="text-muted fw-light">Inventori /</span> Data Obat</h4>
        @auth
            @if(in_array(Auth::user()->role, ['admin', 'petugas']))
                <a href="{{ route('backend.obat.create') }}" class="btn btn-primary shadow">
                    <i class="bx bx-plus-circle me-1"></i> Tambah Data Obat
                </a>
            @endif
        @endauth
    </div>

    <div class="card shadow-sm">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-0">Daftar Stok Obat-obatan</h5>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nama Obat</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Tgl Kadaluarsa</th>
                        <th>Status</th>
                        <th>Unit</th>
                        <th>Deskripsi</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($obat as $data)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar flex-shrink-0 me-2">
                                    <span class="avatar-initial rounded bg-label-success">
                                        <i class="bx bx-capsule"></i>
                                    </span>
                                </div>
                                <span class="fw-bold text-dark">{{ $data->nama_obat }}</span>
                            </div>
                        </td>
                        <td><span class="badge bg-label-primary text-capitalize">{{ $data->kategori }}</span></td>
                        <td>
                            <div class="fw-semibold {{ $data->stok <= 5 ? 'text-danger' : '' }}">
                                {{ $data->stok }}
                            </div>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($data->tgl_kadaluarsa)->format('d M Y') }}</td>
                        <td>
                            @if ($data->status_kadaluarsa === 'expired')
                                <span class="badge bg-label-danger">Kadaluarsa</span>
                            @elseif ($data->status_kadaluarsa === 'near_expired')
                                <span class="badge bg-label-warning">Hampir Kadaluarsa</span>
                            @else
                                <span class="badge bg-label-success">Aman</span>
                            @endif
                        </td>
                        <td><small class="text-muted">{{ $data->unit }}</small></td>
                        <td>
                            <span class="d-inline-block text-truncate" style="max-width: 150px;" title="{{ $data->deskripsi }}">
                                {{ $data->deskripsi }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="{{ route('backend.obat.edit', $data->id) }}">
                                        <i class="bx bx-edit-alt me-1 text-warning"></i> Edit
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <form action="{{ route('backend.obat.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data obat ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="dropdown-item text-danger" type="submit">
                                            <i class="bx bx-trash me-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">Data obat belum tersedia.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection