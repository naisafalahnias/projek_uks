@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Siswa /</span> Input Kondisi Kesehatan
    </h4>

    <div class="row">
        <div class="col-xl">
            <div class="card mb-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center border-bottom mb-3">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="bx bx-shield-plus me-1"></i> Form Riwayat Kesehatan
                    </h5>
                    <small class="text-muted float-end">Data penyakit kronis atau alergi</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.kondisi_kesehatan.store') }}" method="POST">
                        @csrf

                        {{-- Pilih Siswa --}}
                        <div class="mb-3">
                            <label class="form-label" for="siswa_id">Nama Siswa</label>
                            <div class="input-group input-group-merge shadow-none">
                                <span class="input-group-text"><i class="bx bx-user"></i></span>
                                <select name="siswa_id" id="siswa_id" class="form-select @error('siswa_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Siswa --</option>
                                    @foreach ($siswas as $siswa)
                                        <option value="{{ $siswa->id }}" {{ old('siswa_id') == $siswa->id ? 'selected' : '' }}>
                                            {{ $siswa->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('siswa_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            {{-- Nama Kondisi --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="nama_kondisi">Kondisi / Penyakit</label>
                                <div class="input-group input-group-merge shadow-none">
                                    <span class="input-group-text"><i class="bx bx-pulse"></i></span>
                                    <input type="text" name="nama_kondisi" id="nama_kondisi" 
                                           class="form-control @error('nama_kondisi') is-invalid @enderror" 
                                           placeholder="Asma, Alergi Kacang, dll" 
                                           value="{{ old('nama_kondisi') }}" required>
                                    @error('nama_kondisi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Tanggal --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="tanggal">Tanggal Diagnosa</label>
                                <div class="input-group input-group-merge shadow-none">
                                    <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                    <input type="date" name="tanggal" id="tanggal" 
                                           class="form-control @error('tanggal') is-invalid @enderror" 
                                           value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                    @error('tanggal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Keterangan --}}
                        <div class="mb-4">
                            <label class="form-label" for="keterangan">Keterangan Tambahan</label>
                            <div class="input-group input-group-merge shadow-none">
                                <span class="input-group-text"><i class="bx bx-comment-detail"></i></span>
                                <textarea name="keterangan" id="keterangan" 
                                          class="form-control @error('keterangan') is-invalid @enderror" 
                                          rows="3" placeholder="Misal: Harus bawa inhaler setiap hari">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text">Jelaskan penanganan awal jika kondisi ini kambuh di sekolah.</div>
                        </div>

                        <hr class="my-4">

                        {{-- Tombol --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('backend.kondisi_kesehatan.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-x me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-4 shadow">
                                <i class="bx bx-save me-1"></i> Simpan Kondisi
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
                    text: 'Mohon tunggu sebentar, data kondisi kesehatan sedang diproses.',
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