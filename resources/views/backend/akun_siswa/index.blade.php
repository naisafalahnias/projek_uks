@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 m-0"><span class="text-muted fw-light">Siswa /</span> Daftar Akun Siswa</h4>
        @auth
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('backend.akun_siswa.create') }}" class="btn btn-primary shadow">
                    <i class="bx bx-user-plus me-1"></i> Tambah Akun Siswa
                </a>
            @endif
        @endauth
    </div>

    {{-- Alert Notifikasi --}}
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
        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">List Akun Akses Siswa</h5>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%">No</th>
                        <th>Identitas Akun</th> {{-- Ubah label --}}
                        <th>Profil Terhubung</th> {{-- TAMBAH KOLOM INI --}}
                        <th>Kontak</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="avatar-wrapper">
                                        <div class="avatar avatar-sm me-3">
                                            <span class="avatar-initial rounded-circle bg-label-secondary">
                                                <i class="bx bx-user"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold text-dark">{{ $user->name }}</span>
                                        <small class="text-muted">{{ $user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            {{-- KOLOM BARU: Menampilkan data dari tabel siswas --}}
                            <td>
                                @if($user->siswa_id && $user->siswa)
                                    <div class="d-flex flex-column">
                                        <span class="text-primary fw-bold">{{ $user->siswa->nama }}</span>
                                        <small class="text-muted">NISN: {{ $user->siswa->nisn ?? '-' }}</small>
                                    </div>
                                @else
                                    <span class="badge bg-label-warning small">Belum Terhubung</span>
                                @endif
                            </td>
                            <td>
                                @if($user->no_hp)
                                    <span class="badge bg-label-primary">
                                        <i class="bx bx-phone-call me-1 small"></i>{{ $user->no_hp }}
                                    </span>
                                @else
                                    <span class="text-muted small fst-italic">No. HP Kosong</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    {{-- Fitur Kirim Hasil (Admin & Petugas) --}}
                                    @if(in_array(Auth::user()->role, ['admin', 'petugas']))
                                        <form action="{{ route('backend.user.kirimHasil', $user->id) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-sm btn-success px-3 shadow-sm">
                                                <i class="bx bx-paper-plane me-1"></i> Kirim Hasil
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Fitur Hapus (Hanya Admin) --}}
                                    @if(Auth::user()->role === 'admin')
                                        <form action="{{ route('backend.akun_siswa.destroy', $user->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Yakin hapus akun siswa ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-icon btn-outline-danger shadow-sm" title="Hapus Akun">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bx bx-user-x mb-2 display-6"></i>
                                    <p>Belum ada akun siswa terdaftar.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection