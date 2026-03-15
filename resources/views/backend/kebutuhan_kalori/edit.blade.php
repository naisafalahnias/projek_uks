@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Kesehatan /</span> Koreksi Kebutuhan Energi
    </h4>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4 shadow-sm border-top border-warning border-3">
                <div class="card-header d-flex justify-content-between align-items-center border-bottom mb-4">
                    <h5 class="mb-0 text-warning fw-bold">
                        <i class="bx bx-edit-alt me-1"></i> Perbarui Target Kalori Siswa
                    </h5>
                    <small class="text-muted">Data ID: #{{ $kebutuhanKalori->id }}</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.kebutuhan_kalori.update', $kebutuhanKalori->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Siswa --}}
                        <div class="mb-3">
                            <label class="form-label" for="siswa_id">Nama Siswa</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text bg-light"><i class="bx bx-user"></i></span>
                                <select name="siswa_id" id="siswa_id" class="form-select @error('siswa_id') is-invalid @enderror" required>
                                    @foreach ($siswas as $siswa)
                                        <option value="{{ $siswa->id }}" 
                                            {{ old('siswa_id', $kebutuhanKalori->siswa_id) == $siswa->id ? 'selected' : '' }}>
                                            {{ $siswa->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Kebutuhan Kalori --}}
                        <div class="mb-3">
                            <label class="form-label" for="kebutuhan_harian">Kebutuhan Kalori Harian</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text bg-label-warning text-warning"><i class="bx bx-bolt-circle"></i></span>
                                <input type="number" name="kebutuhan_harian" id="kebutuhan_harian" 
                                       class="form-control border-warning" 
                                       value="{{ old('kebutuhan_harian', $kebutuhanKalori->kebutuhan_harian) }}" required>
                                <span class="input-group-text border-warning">kcal/hari</span>
                            </div>
                        </div>

                        {{-- Tingkat Aktivitas --}}
                        <div class="mb-4">
                            <label class="form-label" for="tingkat_aktivitas">Tingkat Aktivitas Fisik</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-run"></i></span>
                                <select name="tingkat_aktivitas" id="tingkat_aktivitas" class="form-select" required>
                                    <option value="rendah" {{ old('tingkat_aktivitas', $kebutuhanKalori->tingkat_aktivitas) == 'rendah' ? 'selected' : '' }}>
                                        Rendah (Sedenter / Jarang Olahraga)
                                    </option>
                                    <option value="sedang" {{ old('tingkat_aktivitas', $kebutuhanKalori->tingkat_aktivitas) == 'sedang' ? 'selected' : '' }}>
                                        Sedang (Aktif 3-5 hari/minggu)
                                    </option>
                                    <option value="tinggi" {{ old('tingkat_aktivitas', $kebutuhanKalori->tingkat_aktivitas) == 'tinggi' ? 'selected' : '' }}>
                                        Tinggi (Sangat Aktif / Atlet)
                                    </option>
                                </select>
                            </div>
                        </div>

                        

                        <div class="alert alert-warning d-flex align-items-center mt-2 shadow-none border-0 bg-label-warning" role="alert">
                            <i class="bx bx-info-circle me-2"></i>
                            <div>
                                <small>Perubahan target kalori akan mempengaruhi analisis status kecukupan gizi pada laporan harian siswa.</small>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('backend.kebutuhan_kalori.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-chevron-left me-1"></i> Kembali
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