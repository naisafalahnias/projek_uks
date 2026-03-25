@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Form /</span> Edit Data Kelas</h4>

    <div class="row">
        <div class="col-xl">
            <div class="card mb-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center border-bottom mb-3">
                    <h5 class="mb-0 text-primary">Perbarui Data Kelas</h5>
                    <small class="text-muted float-end">ID Kelas: #{{ $kelas->id }}</small>
                </div>
                <div class="card-body">
                    
                    @if (session('info'))
                        <div class="alert alert-label-info alert-dismissible fade show" role="alert">
                            {{ session('info') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    {{-- Tampilkan error validasi --}}
                    @if ($errors->any())
                        <div class="alert alert-label-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('backend.kelas.update', $kelas->id) }}" method="POST">
                        @csrf
                        @method('PUT') {{-- WAJIB ADA UNTUK PROSES UPDATE --}}

                        <div class="mb-4">
                            <label class="form-label" for="nama_kelas">Nama Kelas</label>
                            <div class="input-group input-group-merge shadow-none">
                                <span id="icon-kelas" class="input-group-text bg-label-primary">
                                    <i class="bx bx-buildings"></i>
                                </span>
                                <input
                                    type="text"
                                    name="nama_kelas"
                                    class="form-control"
                                    id="nama_kelas"
                                    placeholder="Contoh: XII RPL 1 atau X IPA 2"
                                    aria-label="Nama Kelas"
                                    aria-describedby="icon-kelas"
                                    required
                                    value="{{ old('nama_kelas', $kelas->nama_kelas) }}"
                                />
                            </div>
                            <div class="form-text">Ubah nama kelas jika terdapat kesalahan penulisan.</div>
                        </div>

                        <div class="row">
                            <div class="col-12 d-flex justify-content-start gap-2">
                                <button type="submit" class="btn btn-primary d-flex align-items-center">
                                    <i class="bx bx-refresh me-1"></i> Perbarui Data
                                </button>
                                <a href="{{ route('backend.kelas.index') }}" class="btn btn-outline-secondary">
                                    <i class="bx bx-arrow-back me-1"></i> Batal
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection