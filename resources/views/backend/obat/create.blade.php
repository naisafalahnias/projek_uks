@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Inventori /</span> Tambah Data Obat
    </h4>

    <div class="row">
        <div class="col-xl">
            <div class="card mb-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center border-bottom mb-3">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="bx bx-plus-circle me-1"></i> Formulir Obat Baru
                    </h5>
                    <small class="text-muted float-end">Lengkapi semua kolom</small>
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

                    <form action="{{ route('backend.obat.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            {{-- Nama Obat --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="nama_obat">Nama Obat</label>
                                <div class="input-group input-group-merge shadow-none">
                                    <span class="input-group-text bg-label-primary"><i class="bx bx-capsule"></i></span>
                                    <input type="text" name="nama_obat" class="form-control" id="nama_obat" placeholder="Contoh: Amoxicillin" required value="{{ old('nama_obat') }}">
                                </div>
                            </div>

                            {{-- Kategori --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="kategori">Kategori</label>
                                <div class="input-group input-group-merge shadow-none">
                                    <span class="input-group-text bg-label-primary"><i class="bx bx-category"></i></span>
                                    <input type="text" name="kategori" class="form-control" id="kategori" placeholder="Contoh: Antibiotik" required value="{{ old('kategori') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Stok --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="stok">Stok Awal</label>
                                <div class="input-group input-group-merge shadow-none">
                                    <span class="input-group-text bg-label-primary"><i class="bx bx-package"></i></span>
                                    <input type="number" name="stok" class="form-control" id="stok" placeholder="0" required value="{{ old('stok') }}">
                                </div>
                            </div>

                            {{-- Unit --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="unit">Unit (Satuan)</label>
                                <div class="input-group input-group-merge shadow-none">
                                    <span class="input-group-text bg-label-primary"><i class="bx bx-purchase-tag-alt"></i></span>
                                    <input type="text" name="unit" class="form-control" id="unit" placeholder="Pcs/Tablet/Botol" required value="{{ old('unit') }}">
                                </div>
                            </div>

                            {{-- Tanggal Kadaluarsa --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="tgl_kadaluarsa">Tanggal Kadaluarsa</label>
                                <div class="input-group input-group-merge shadow-none">
                                    <span class="input-group-text bg-label-primary"><i class="bx bx-calendar"></i></span>
                                    <input type="date" name="tgl_kadaluarsa" class="form-control" id="tgl_kadaluarsa" required value="{{ old('tgl_kadaluarsa') }}">
                                </div>
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label class="form-label" for="deskripsi">Deskripsi Obat</label>
                            <div class="input-group input-group-merge shadow-none">
                                <span class="input-group-text bg-label-primary"><i class="bx bx-detail"></i></span>
                                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" placeholder="Ketik deskripsi atau aturan pakai singkat..." required>{{ old('deskripsi') }}</textarea>
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('backend.obat.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-arrow-back me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary px-4 shadow">
                                <i class="bx bx-save me-1"></i> Simpan Obat Baru
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