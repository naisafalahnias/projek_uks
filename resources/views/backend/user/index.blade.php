@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 m-0"><span class="text-muted fw-light">Manajemen /</span> Daftar Petugas</h4>
        <a href="{{ route('backend.user.create') }}" class="btn btn-primary shadow">
            <i class="bx bx-user-plus me-1"></i> Tambah User
        </a>
    </div>

    {{-- Notifikasi Sukses --}}
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
            <h5 class="card-title mb-0">Tabel Akun Pengguna</h5>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%">No</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <th>Role</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex justify-content-start align-items-center user-name">
                                    <div class="avatar-wrapper">
                                        <div class="avatar avatar-sm me-3">
                                            <span class="avatar-initial rounded-circle {{ $user->role === 'admin' ? 'bg-label-primary' : 'bg-label-info' }}">
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold">{{ $user->name }}</span>
                                        <small class="text-muted">UID: #{{ $user->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->role === 'admin' && empty($user->no_hp))
                                    <span class="text-muted small fst-italic">Tidak Tersedia</span>
                                @else
                                    <span class="text-dark">{{ $user->no_hp }}</span>
                                @endif
                            </td>
                            <td>
                                @if($user->role === 'admin')
                                    <span class="badge bg-label-primary">Admin</span>
                                @else
                                    <span class="badge bg-label-info">Petugas</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($user->role !== 'admin')
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <form action="{{ route('backend.user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="bx bx-trash me-1"></i> Hapus User
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <span class="badge badge-center rounded-pill bg-label-secondary" title="Admin Utama tidak bisa dihapus">
                                        <i class="bx bx-lock-alt"></i>
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data user.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection