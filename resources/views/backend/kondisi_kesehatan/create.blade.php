@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center py-3 mb-4">
        <h4 class="fw-bold mb-0">
            <span class="text-muted fw-light">Siswa /</span> Kondisi Kesehatan
        </h4>
        <a href="{{ route('backend.kondisi_kesehatan.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bx bx-chevron-left"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-body">
                    <form action="{{ route('backend.kondisi_kesehatan.store') }}" method="POST" id="formKondisi">
                        @csrf
                        
                        <div class="row">
                            <div class="col-12 mb-4">
                                <label class="form-label fw-bold" for="siswa_id">Cari Siswa</label>
                                <select name="siswa_id" id="siswa_id" class="select2 form-select @error('siswa_id') is-invalid @enderror" required>
                                    <option value="">Ketik nama atau NIS siswa...</option>
                                    @foreach ($siswas as $siswa)
                                        <option value="{{ $siswa->id }}" {{ old('siswa_id') == $siswa->id ? 'selected' : '' }}>
                                            {{ $siswa->nama }} ({{ $siswa->kelas->nama_kelas ?? 'Tanpa Kelas' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('siswa_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold" for="nama_kondisi">Jenis Kondisi / Penyakit</label>
                                <input type="text" name="nama_kondisi" id="nama_kondisi" 
                                       class="form-control @error('nama_kondisi') is-invalid @enderror" 
                                       placeholder="Contoh: Alergi Kacang, Asma, Diabetes" 
                                       value="{{ old('nama_kondisi') }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold" for="tanggal">Tanggal Diagnosa</label>
                                <input type="date" name="tanggal" id="tanggal" 
                                       class="form-control @error('tanggal') is-invalid @enderror" 
                                       value="{{ old('tanggal', date('Y-m-d')) }}" required>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold" for="keterangan">Prosedur Penanganan & Keterangan</label>
                                <textarea name="keterangan" id="keterangan" 
                                          class="form-control @error('keterangan') is-invalid @enderror" 
                                          rows="4" placeholder="Apa yang harus dilakukan jika kondisi ini kambuh?">{{ old('keterangan') }}</textarea>
                                <div class="form-text mt-2 text-warning">
                                    <i class="bx bx-info-circle me-1"></i> Informasi ini akan langsung tampil di Dashboard Siswa.
                                </div>
                            </div>
                        </div>

                        <div class="pt-3 border-top d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary px-5 py-2">
                                <i class="bx bx-check-circle me-1"></i> Simpan Data Medis
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-label-primary border-0 shadow-none mb-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold text-primary mb-3"><i class="bx bx-info-circle"></i> Petunjuk Pengisian</h5>
                    <p class="small mb-2">Pastikan data yang diinput adalah diagnosa resmi dari tenaga medis.</p>
                    <ul class="ps-3 mb-0 small text-muted">
                        <li>Gunakan istilah medis yang umum.</li>
                        <li>Tuliskan langkah darurat (Emergency Plan) pada kolom keterangan.</li>
                        <li>Double check nama siswa sebelum menyimpan.</li>
                    </ul>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="badge bg-label-danger p-2 rounded me-3">
                            <i class="bx bx-heart fs-3"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">Kritis</h6>
                            <small class="text-muted">Data ini mempengaruhi keselamatan siswa di sekolah.</small>
                        </div>
                    </div>
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