@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Kantin /</span> Input Menu Baru
    </h4>

    <div class="row">
        <div class="col-xl">
            <div class="card mb-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center border-bottom mb-3">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="bx bx-bowl-hot me-1"></i> Form Data Nutrisi Makanan
                    </h5>
                    <small class="text-muted">Pastikan data kalori sesuai label kemasan</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.makanans.store') }}" method="POST">
                        @csrf

                        {{-- Nama Makanan --}}
                        <div class="mb-3">
                            <label class="form-label" for="nama_makanan">Nama Makanan / Minuman</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-restaurant"></i></span>
                                <input type="text" name="nama_makanan" id="nama_makanan" 
                                       class="form-control @error('nama_makanan') is-invalid @enderror" 
                                       placeholder="Contoh: Salad Buah, Jus Jeruk..." required>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Jenis --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="jenis">Kategori</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-category"></i></span>
                                    <select name="jenis" id="jenis" class="form-select" required>
                                        <option value="">-- Pilih Jenis --</option>
                                        <option value="snack">Snack / Camilan</option>
                                        <option value="minuman">Minuman</option>
                                        <option value="berat">Makanan Berat</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="status">Penilaian Kesehatan</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-check-shield"></i></span>
                                    <select name="status" id="status" class="form-select" required>
                                        <option value="">-- Pilih Status --</option>
                                        <option value="sehat" class="text-success">✅ Sehat</option>
                                        <option value="tidak_sehat" class="text-danger">❌ Tidak Sehat</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        

[Image of nutrition facts label guide]


                        <div class="row mt-2">
                            {{-- Kalori --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="kalori">Energi (Kalori)</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-bolt-circle"></i></span>
                                    <input type="number" name="kalori" id="kalori" class="form-control" placeholder="0" required>
                                    <span class="input-group-text">kcal</span>
                                </div>
                            </div>

                            {{-- Gula --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="gula">Kandungan Gula</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-water"></i></span>
                                    <input type="number" step="0.01" name="gula" id="gula" class="form-control" placeholder="0.0" required>
                                    <span class="input-group-text">gram</span>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('backend.makanans.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-x me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-4 shadow">
                                <i class="bx bx-save me-1"></i> Simpan Menu
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
                    text: 'Mohon tunggu sebentar, data makanan sedang diproses.',
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