@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Siswa /</span> Tambah Data
    </h4>

    <div class="row">
        <div class="col-xl">
            <div class="card mb-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center border-bottom mb-3">
                    <h5 class="mb-0 text-primary fw-bold">Formulir Biodata Siswa</h5>
                    <small class="text-muted float-end">Lengkapi data dengan benar</small>
                </div>
                <div class="card-body">
                    {{-- Alert Error Validasi --}}
                    @if ($errors->any())
                        <div class="alert alert-label-danger alert-dismissible fade show" role="alert">
                            <div class="d-flex">
                                <i class="bx bx-error-circle me-2"></i>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('backend.siswa.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            {{-- Nama Siswa --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="nama">Nama Lengkap Siswa</label>
                                <div class="input-group input-group-merge shadow-none">
                                    <span class="input-group-text bg-label-primary"><i class="bx bx-user"></i></span>
                                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan nama lengkap..." required value="{{ old('nama') }}">
                                </div>
                            </div>

                            {{-- Tanggal Lahir --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="tanggal_lahir">Tanggal Lahir</label>
                                <div class="input-group input-group-merge shadow-none">
                                    <span class="input-group-text bg-label-primary"><i class="bx bx-calendar"></i></span>
                                    <input type="date" name="tanggal_lahir" class="form-control" id="tanggal_lahir" required value="{{ old('tanggal_lahir') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Kelas --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="kelas_id">Pilih Kelas</label>
                                <div class="input-group input-group-merge shadow-none">
                                    <span class="input-group-text bg-label-primary"><i class="bx bx-buildings"></i></span>
                                    <select name="kelas_id" id="kelas_id" class="form-select" required>
                                        <option disabled selected value="">-- Pilih Kelas --</option>
                                        @foreach ($kelas as $data)
                                            <option value="{{ $data->id }}" {{ old('kelas_id') == $data->id ? 'selected' : '' }}>
                                                {{ $data->nama_kelas }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Jenis Kelamin --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label" for="jenis_kelamin">Jenis Kelamin</label>
                                <div class="input-group input-group-merge shadow-none">
                                    <span class="input-group-text bg-label-primary"><i class="bx bx-body"></i></span>
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required>
                                        <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('backend.siswa.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-arrow-back me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary px-4 shadow">
                                <i class="bx bx-save me-1"></i> Simpan Data Siswa
                            </button>
                        </div>
                    </form>
                </div>
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
                    text: 'Mohon tunggu sebentar, data siswa sedang diproses.',
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