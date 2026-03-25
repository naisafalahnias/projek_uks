@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Pemeriksaan /</span> Buat Jadwal Baru
    </h4>

    <div class="row">
        <div class="col-xl">
            <div class="card mb-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center border-bottom mb-3">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="bx bx-calendar-event me-1"></i> Formulir Penjadwalan
                    </h5>
                    <small class="text-muted float-end">Agenda Pemeriksaan Kesehatan</small>
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

                    <form action="{{ route('backend.jadwal_pemeriksaan.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            {{-- Tanggal --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="tanggal">Tanggal Pemeriksaan</label>
                                <div class="input-group input-group-merge shadow-none">
                                    <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                    <input type="date" name="tanggal" id="tanggal" class="form-control" required value="{{ old('tanggal') }}">
                                </div>
                            </div>

                            {{-- Kelas --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="kelas_id">Target Kelas</label>
                                <div class="input-group input-group-merge shadow-none">
                                    <span class="input-group-text"><i class="bx bx-buildings"></i></span>
                                    <select name="kelas_id" id="kelas_id" class="form-select" required>
                                        <option disabled selected>Pilih Kelas...</option>
                                        @foreach ($kelas as $data)
                                            <option value="{{ $data->id }}" {{ old('kelas_id') == $data->id ? 'selected' : '' }}>
                                                {{ $data->nama_kelas }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Petugas (Read Only) --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="petugas">Petugas Pelaksana</label>
                                <div class="input-group input-group-merge shadow-none">
                                    <span class="input-group-text bg-light"><i class="bx bx-user-check"></i></span>
                                    <input type="text" class="form-control bg-light" value="{{ auth()->user()->name }}" readonly>
                                    {{-- Pastikan user_id terkirim --}}
                                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                </div>
                            </div>
                        </div>

                        {{-- Keterangan --}}
                        <div class="mb-4">
                            <label class="form-label" for="keterangan">Keterangan / Catatan Tambahan</label>
                            <div class="input-group input-group-merge shadow-none">
                                <span class="input-group-text"><i class="bx bx-note"></i></span>
                                <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="3" placeholder="Contoh: Pemeriksaan berkala atau skrining mata">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('backend.jadwal_pemeriksaan.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-x me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-4 shadow">
                                <i class="bx bx-check me-1"></i> Simpan Jadwal
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
                    text: 'Mohon tunggu sebentar, data jadwal pemeriksaan sedang diproses.',
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