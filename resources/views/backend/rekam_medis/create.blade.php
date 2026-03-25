@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Kesehatan /</span> Tambah Rekam Medis
    </h4>

    <div class="row">
        <div class="col-xl">
            <div class="card mb-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center border-bottom mb-3">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="bx bx-plus-medical me-1"></i> Input Data Pemeriksaan
                    </h5>
                    <small class="text-muted float-end">Lengkapi detail kesehatan siswa</small>
                </div>
                <div class="card-body">
                    {{-- Alert Error Validasi --}}
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

                    <form action="{{ route('backend.rekam_medis.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            {{-- Pilih Kelas --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="kelasSelect">Pilih Kelas</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-buildings"></i></span>
                                    <select id="kelasSelect" name="kelas_id" class="form-select @error('kelas_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach ($kelas as $k)
                                            <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Pilih Siswa --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="siswaSelect">Nama Siswa</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                                    <select name="siswa_id" id="siswaSelect" class="form-select @error('siswa_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Siswa --</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Tanggal --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="tanggal">Tanggal Pemeriksaan</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                    <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="status">Tindak Lanjut (Status)</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-git-branch"></i></span>
                                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="">-- Pilih Status --</option>
                                        <option value="kelas" {{ old('status') == 'kelas' ? 'selected' : '' }}>Kembali ke Kelas</option>
                                        <option value="uks" {{ old('status') == 'uks' ? 'selected' : '' }}>Istirahat di UKS</option>
                                        <option value="pulang" {{ old('status') == 'pulang' ? 'selected' : '' }}>Pulang</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Keluhan --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="keluhan">Keluhan Utama</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-error-alt"></i></span>
                                    <input type="text" name="keluhan" id="keluhan" class="form-control @error('keluhan') is-invalid @enderror" placeholder="Contoh: Pusing, Demam" value="{{ old('keluhan') }}" required>
                                </div>
                            </div>

                            {{-- Tindakan --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="tindakan">Tindakan</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-first-aid"></i></span>
                                    <textarea name="tindakan" id="tindakan" class="form-control @error('tindakan') is-invalid @enderror" rows="1" placeholder="Tindakan yang diberikan" required>{{ old('tindakan') }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Obat --}}
                        <div class="row mb-3">
                            <label class="form-label">Pemberian Obat (Opsional)</label>
                            <div class="col-sm-7 mb-2">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-capsule"></i></span>
                                    <select name="obat_id" class="form-select @error('obat_id') is-invalid @enderror">
                                        <option value="">Pilih obat...</option>
                                        @foreach ($obat as $data)
                                            <option value="{{ $data->id }}" {{ old('obat_id') == $data->id ? 'selected' : '' }}>
                                                {{ $data->nama_obat }} (Stok: {{ $data->stok }} {{ $data->unit }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-list-ol"></i></span>
                                    <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror" placeholder="Jumlah" value="{{ old('jumlah') }}">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Petugas Pencatat</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text bg-light"><i class="bx bx-user-check"></i></span>
                                <input type="text" class="form-control bg-light" value="{{ auth()->user()->name }}" readonly>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('backend.rekam_medis.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-x me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-4 shadow">
                                <i class="bx bx-save me-1"></i> Simpan Rekam Medis
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
    const oldSiswaId = @json(old('siswa_id'));
    const oldKelasId = "{{ old('kelas_id') }}";

    document.getElementById('kelasSelect').addEventListener('change', function () {
        const kelasId = this.value;
        const siswaSelect = document.getElementById('siswaSelect');

        if (!kelasId) {
            siswaSelect.innerHTML = '<option value="">-- Pilih Siswa --</option>';
            return;
        }

        siswaSelect.innerHTML = '<option value="">-- Memuat data siswa... --</option>';

        fetch(`/get-siswa-by-kelas/${kelasId}`)
            .then(response => response.json())
            .then(data => {
                siswaSelect.innerHTML = '<option value="">-- Pilih Siswa --</option>';
                data.forEach(siswa => {
                    const selected = siswa.id == oldSiswaId ? 'selected' : '';
                    siswaSelect.innerHTML += `<option value="${siswa.id}" ${selected}>${siswa.nama}</option>`;
                });
            })
            .catch(error => {
                console.error('Gagal memuat siswa:', error);
                siswaSelect.innerHTML = '<option value="">-- Gagal memuat siswa --</option>';
            });
    });

    if (oldKelasId) {
        const kelasSelect = document.getElementById('kelasSelect');
        kelasSelect.dispatchEvent(new Event('change'));
    }

    $(document).ready(function() {
        // Targetkan semua form yang ada di halaman ini
        $('form').on('submit', function(e) {
            // Cek validasi HTML5 (required dsb)
            if (this.checkValidity()) {
                Swal.fire({
                    title: 'Sedang Menyimpan...',
                    text: 'Mohon tunggu sebentar, data rekam medis sedang diproses.',
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