@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Inventori /</span> Edit Obat
    </h4>

    <div class="row">
        <div class="col-xl">
            <div class="card mb-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center border-bottom mb-3">
                    <h5 class="mb-0 text-warning fw-bold">
                        <i class="bx bx-edit me-1"></i> Ubah Data Obat
                    </h5>
                    <small class="text-muted float-end">ID Obat: #{{ $obat->id }}</small>
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

                    <form action="{{ route('backend.obat.update', $obat->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- Nama Obat --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="nama_obat">Nama Obat</label>
                                <div class="input-group input-group-merge shadow-none">
                                    <span class="input-group-text bg-label-warning"><i class="bx bx-capsule text-warning"></i></span>
                                    <input 
                                        type="text" 
                                        name="nama_obat" 
                                        class="form-control" 
                                        id="nama_obat" 
                                        value="{{ old('nama_obat', $obat->nama_obat) }}" 
                                        required
                                    >
                                </div>
                            </div>

                            {{-- Kategori --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="kategori">Kategori</label>
                                <div class="input-group input-group-merge shadow-none">
                                    <span class="input-group-text bg-label-warning"><i class="bx bx-category text-warning"></i></span>
                                    <input 
                                        type="text" 
                                        name="kategori" 
                                        class="form-control" 
                                        id="kategori" 
                                        value="{{ old('kategori', $obat->kategori) }}" 
                                        required
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Stok --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="stok">Stok Saat Ini</label>
                                <div class="input-group input-group-merge shadow-none">
                                    <span class="input-group-text bg-label-warning"><i class="bx bx-package text-warning"></i></span>
                                    <input 
                                        type="number" 
                                        name="stok" 
                                        class="form-control" 
                                        id="stok" 
                                        value="{{ old('stok', $obat->stok) }}" 
                                        required
                                    >
                                </div>
                            </div>

                            {{-- Unit --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="unit">Unit/Satuan</label>
                                <div class="input-group input-group-merge shadow-none">
                                    <span class="input-group-text bg-label-warning"><i class="bx bx-purchase-tag-alt text-warning"></i></span>
                                    <input 
                                        type="text" 
                                        name="unit" 
                                        class="form-control" 
                                        id="unit" 
                                        value="{{ old('unit', $obat->unit) }}" 
                                        required
                                    >
                                </div>
                            </div>

                            {{-- Tanggal Kadaluarsa --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="tgl_kadaluarsa">Tanggal Kadaluarsa</label>
                                <div class="input-group input-group-merge shadow-none">
                                    <span class="input-group-text bg-label-warning"><i class="bx bx-time-five text-warning"></i></span>
                                    <input 
                                        type="date" 
                                        name="tgl_kadaluarsa" 
                                        class="form-control" 
                                        id="tgl_kadaluarsa" 
                                        value="{{ old('tgl_kadaluarsa', $obat->tgl_kadaluarsa) }}" 
                                        required
                                    >
                                </div>
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label class="form-label" for="deskripsi">Deskripsi Obat</label>
                            <div class="input-group input-group-merge shadow-none">
                                <span class="input-group-text bg-label-warning"><i class="bx bx-detail text-warning"></i></span>
                                <textarea 
                                    name="deskripsi" 
                                    id="deskripsi" 
                                    class="form-control" 
                                    rows="3" 
                                    required
                                >{{ old('deskripsi', $obat->deskripsi) }}</textarea>
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('backend.obat.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-arrow-back me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-warning px-4 shadow text-white">
                                <i class="bx bx-refresh me-1"></i> Perbarui Data Obat
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection