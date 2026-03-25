@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Kesehatan /</span> Input Kebutuhan Energi
    </h4>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-top border-primary border-3">
                <div class="card-header d-flex justify-content-between align-items-center border-bottom mb-4">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="bx bx-calculator me-1"></i> Pengaturan Target Kalori
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.kebutuhan_kalori.store') }}" method="POST">
                        @csrf

                        {{-- Siswa --}}
                        <div class="mb-3">
                            <label class="form-label" for="siswa_id">Nama Siswa</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-user"></i></span>
                                <select name="siswa_id" id="siswa_id" class="form-select @error('siswa_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Siswa --</option>
                                    @foreach ($siswas as $siswa)
                                        <option value="{{ $siswa->id }}" {{ old('siswa_id') == $siswa->id ? 'selected' : '' }}>
                                            {{ $siswa->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Kebutuhan Kalori --}}
                        <div class="mb-3">
                            <label class="form-label" for="kebutuhan_harian">Kebutuhan Kalori Harian (BMR + Aktivitas)</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-bolt-circle"></i></span>
                                <input type="number" name="kebutuhan_harian" id="kebutuhan_harian" 
                                       class="form-control" placeholder="Contoh: 2150" min="0" required>
                                <span class="input-group-text">kkal/hari</span>
                            </div>
                            <div class="form-text">Masukkan angka berdasarkan hasil hitung rumus Harris-Benedict atau Mifflin-St Jeor.</div>
                        </div>

                        {{-- Tingkat Aktivitas --}}
                        <div class="mb-4">
                            <label class="form-label" for="tingkat_aktivitas">Tingkat Aktivitas Fisik</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-run"></i></span>
                                <select name="tingkat_aktivitas" id="tingkat_aktivitas" class="form-select" required>
                                    <option value="">-- Pilih Aktivitas --</option>
                                    <option value="rendah">Rendah (Jarang olahraga / Sedenter)</option>
                                    <option value="sedang">Sedang (Olahraga 3-5 hari/minggu)</option>
                                    <option value="tinggi">Tinggi (Atlet / Olahraga tiap hari)</option>
                                </select>
                            </div>
                        </div>

                        

                        {{-- Info Box --}}
                        <div class="alert alert-outline-primary d-flex align-items-start p-3" role="alert">
                            <span class="badge badge-center rounded-pill bg-primary me-3"><i class="bx bx-help-circle"></i></span>
                            <div>
                                <h6 class="mb-1 fw-bold">Tips UKS:</h6>
                                <span>Rata-rata remaja membutuhkan <b>2.000 - 2.500 kkal</b>. Jika siswa memiliki berat badan berlebih, target kalori biasanya dikurangi secara bertahap.</span>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('backend.kebutuhan_kalori.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-chevron-left me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-4 shadow">
                                <i class="bx bx-save me-1"></i> Simpan Target
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
                    text: 'Mohon tunggu sebentar, data kebutuhan kalori sedang diproses.',
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