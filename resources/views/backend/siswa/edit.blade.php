@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Siswa /</span> Edit Data
    </h4>

    <div class="row">
        <div class="col-xl">
            <div class="card mb-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center border-bottom mb-3">
                    <h5 class="mb-0 text-warning fw-bold">
                        <i class="bx bx-edit me-1"></i> Ubah Biodata Siswa
                    </h5>
                    <small class="text-muted float-end">ID Siswa: #{{ $siswa->id }}</small>
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

                    <form action="{{ route('backend.siswa.update', $siswa->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- Nama Siswa --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="nama">Nama Lengkap Siswa</label>
                                <div class="input-group input-group-merge shadow-none">
                                    <span class="input-group-text bg-label-warning"><i class="bx bx-user"></i></span>
                                    <input 
                                        type="text" 
                                        name="nama" 
                                        class="form-control" 
                                        id="nama" 
                                        placeholder="Masukkan nama lengkap..." 
                                        required 
                                        value="{{ old('nama', $siswa->nama) }}"
                                    >
                                </div>
                            </div>

                            {{-- Tanggal Lahir --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="tanggal_lahir">Tanggal Lahir</label>
                                <div class="input-group input-group-merge shadow-none">
                                    <span class="input-group-text bg-label-warning"><i class="bx bx-calendar"></i></span>
                                    <input 
                                        type="date" 
                                        name="tanggal_lahir" 
                                        class="form-control" 
                                        id="tanggal_lahir" 
                                        required 
                                        value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}"
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Kelas --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="kelas_id">Pilih Kelas</label>
                                <div class="input-group input-group-merge shadow-none">
                                    <span class="input-group-text bg-label-warning"><i class="bx bx-buildings"></i></span>
                                    <select name="kelas_id" id="kelas_id" class="form-select" required>
                                        <option disabled value="">-- Pilih Kelas --</option>
                                        @foreach ($kelas as $data)
                                            <option value="{{ $data->id }}" 
                                                {{ (old('kelas_id', $siswa->kelas_id) == $data->id) ? 'selected' : '' }}>
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
                                    <span class="input-group-text bg-label-warning"><i class="bx bx-body"></i></span>
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required>
                                        <option value="" disabled>-- Pilih Jenis Kelamin --</option>
                                        <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('backend.siswa.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-arrow-back me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-warning px-4 shadow text-white">
                                <i class="bx bx-refresh me-1"></i> Perbarui Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection