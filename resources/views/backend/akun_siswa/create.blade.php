@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Siswa /</span> Tambah Akun Siswa
    </h4>

    <div class="row">
        <div class="col-md-8 col-lg-7">
            <div class="card mb-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center border-bottom mb-3">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="bx bx-user-plus me-1"></i> Registrasi Akun Siswa
                    </h5>
                    <small class="text-muted float-end">Akses login siswa</small>
                </div>
                <div class="card-body">
                    {{-- Alert Error --}}
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

                    <form action="{{ route('backend.akun_siswa.store') }}" method="POST">
                        @csrf

                        {{-- BARU: Pilih Profil Siswa dari Database --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="siswa_id">Hubungkan Profil</label>
                            <div class="col-sm-9">
                                <div class="input-group input-group-merge shadow-none">
                                    <span class="input-group-text"><i class="bx bx-link"></i></span>
                                    <select name="siswa_id" id="siswa_id" class="form-select @error('siswa_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Data Siswa --</option>
                                        @foreach($data_siswa as $siswa)
                                            <option value="{{ $siswa->id }}" {{ old('siswa_id') == $siswa->id ? 'selected' : '' }}>
                                                {{ $siswa->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <small class="text-info">Pilih profil siswa yang sudah diinput sebelumnya untuk dihubungkan ke akun ini.</small>
                                @error('siswa_id')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Nama Akun (Bisa diisi manual atau nanti pakai JS otomatis) --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="name">Username / Nama Akun</label>
                            <div class="col-sm-9">
                                <div class="input-group input-group-merge shadow-none">
                                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Nama untuk login" required value="{{ old('name') }}">
                                </div>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="email">Email Login</label>
                            <div class="col-sm-9">
                                <div class="input-group input-group-merge shadow-none">
                                    <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="siswa@sekolah.sch.id" required value="{{ old('email') }}">
                                </div>
                            </div>
                        </div>

                        {{-- No HP --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="no_hp">No. HP / WA</label>
                            <div class="col-sm-9">
                                <div class="input-group input-group-merge shadow-none">
                                    <span class="input-group-text"><i class="bx bx-phone"></i></span>
                                    <input type="text" name="no_hp" id="no_hp" class="form-control" placeholder="08..." value="{{ old('no_hp') }}">
                                </div>
                            </div>
                        </div>

                        {{-- Password --}}
                        <div class="row mb-4">
                            <label class="col-sm-3 col-form-label" for="password">Password</label>
                            <div class="col-sm-9">
                                <div class="form-password-toggle">
                                    <div class="input-group input-group-merge shadow-none">
                                        <span class="input-group-text"><i class="bx bx-lock-alt"></i></span>
                                        <input type="password" name="password" id="password" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required>
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row justify-content-end">
                            <div class="col-sm-9">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="bx bx-save me-1"></i> Simpan Akun
                                    </button>
                                    <a href="{{ route('backend.akun_siswa.index') }}" class="btn btn-outline-secondary">
                                        Batal
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('siswa_id').addEventListener('change', function() {
        const selectedText = this.options[this.selectedIndex].text;
        const nameInput = document.getElementById('name');
        
        if (this.value !== "") {
            // Ambil nama saja (sebelum tanda kurung NISN)
            const name = selectedText.split('(')[0].trim();
            nameInput.value = name;
        }
    });
</script>

@endsection