@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">User /</span> Registrasi Akun Baru
    </h4>

    <div class="row">
        <div class="col-md-8 col-lg-6"> {{-- Dibikin nggak terlalu lebar biar fokus --}}
            <div class="card mb-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center border-bottom mb-3">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="bx bx-user-plus me-1"></i> Identitas Petugas
                    </h5>
                    <small class="text-muted float-end">Akses Sistem</small>
                </div>
                <div class="card-body">
                    {{-- Alert Error Validasi --}}
                    @if ($errors->any())
                        <div class="alert alert-label-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('backend.user.store') }}" method="POST">
                        @csrf

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label class="form-label" for="name">Nama Lengkap</label>
                            <div class="input-group input-group-merge shadow-none">
                                <span class="input-group-text"><i class="bx bx-user"></i></span>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama petugas" required value="{{ old('name') }}">
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label" for="email">Alamat Email</label>
                            <div class="input-group input-group-merge shadow-none">
                                <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                <input type="email" name="email" id="email" class="form-control" placeholder="nama@email.com" required value="{{ old('email') }}">
                            </div>
                        </div>

                        <div class="row">
                            {{-- No HP --}}
                            <div class="col-md-7 mb-3">
                                <label class="form-label" for="no_hp">Nomor WhatsApp/HP</label>
                                <div class="input-group input-group-merge shadow-none">
                                    <span class="input-group-text"><i class="bx bx-phone"></i></span>
                                    <input type="text" name="no_hp" id="no_hp" class="form-control" placeholder="0812..." required value="{{ old('no_hp') }}">
                                </div>
                            </div>

                            {{-- Role --}}
                            <div class="col-md-5 mb-3">
                                <label class="form-label" for="role">Hak Akses (Role)</label>
                                <div class="input-group input-group-merge shadow-none">
                                    <span class="input-group-text"><i class="bx bx-shield-alt-2"></i></span>
                                    <select name="role" id="role" class="form-select" required>
                                        <option value="" disabled selected>Pilih...</option>
                                        <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Password dengan Toggle --}}
                        <div class="mb-4 form-password-toggle">
                            <label class="form-label" for="password">Password Baru</label>
                            <div class="input-group input-group-merge shadow-none">
                                <span class="input-group-text"><i class="bx bx-lock-alt"></i></span>
                                <input type="password" id="password" name="password" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                            <small class="text-muted">Gunakan minimal 8 karakter kombinasi.</small>
                        </div>

                        <hr class="my-4">

                        {{-- Tombol --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('backend.user.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-arrow-back me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary px-4 shadow">
                                <i class="bx bx-check-double me-1"></i> Daftarkan User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Info Panel (Optional) --}}
        <div class="col-md-4 col-lg-6">
            <div class="alert alert-label-info border-0 shadow-none" role="alert">
                <h6 class="alert-heading fw-bold mb-1">Catatan Keamanan</h6>
                <p class="mb-0 small">
                    Admin memiliki akses penuh ke pengaturan sistem, sedangkan Petugas hanya bisa mengelola data rekam medis dan inventori obat.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        // Targetkan semua form yang ada di halaman ini
        $('form').on('submit', function(e) {
            // Cek validasi HTML5 (required dsb)
            if (this.checkValidity()) {
                Swal.fire({
                    title: 'Sedang Menyimpan...',
                    text: 'Mohon tunggu sebentar, data obat sedang diproses.',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                // Biarkan form berlanjut kirim data
            } else {
                // Jika ada field required yang belum diisi, 
                // biarkan browser yang kasih peringatan standar (atau ganti pakai Swal error)
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Harap lengkapi semua kolom yang wajib diisi!',
                });
                e.preventDefault(); // Stop pengiriman
            }
        });
    });
</script>
@endpush