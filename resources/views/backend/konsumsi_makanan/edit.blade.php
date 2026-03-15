@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Kantin /</span> Koreksi Konsumsi
    </h4>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-top border-warning border-3">
                <div class="card-header d-flex justify-content-between align-items-center border-bottom mb-4">
                    <h5 class="mb-0 text-warning fw-bold">
                        <i class="bx bx-edit-alt me-1"></i> Perbarui Log Konsumsi
                    </h5>
                    <small class="text-muted">Record ID: #{{ $konsumsi->id }}</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.konsumsi_makanan.update', $konsumsi->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Siswa --}}
                        <div class="mb-3">
                            <label class="form-label" for="siswa_id">Nama Siswa</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text bg-light"><i class="bx bx-user"></i></span>
                                <select name="siswa_id" id="siswa_id" class="form-select @error('siswa_id') is-invalid @enderror" required>
                                    @foreach ($siswas as $siswa)
                                        <option value="{{ $siswa->id }}" {{ old('siswa_id', $konsumsi->siswa_id) == $siswa->id ? 'selected' : '' }}>
                                            {{ $siswa->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Makanan --}}
                        <div class="mb-3">
                            <label class="form-label" for="makanan_id">Menu Makanan</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text bg-label-warning text-warning"><i class="bx bx-dish"></i></span>
                                <select name="makanan_id" id="makanan_id" class="form-select border-warning" required>
                                    @foreach ($makanans as $makanan)
                                        <option value="{{ $makanan->id }}" data-kalori="{{ $makanan->kalori }}" 
                                            {{ old('makanan_id', $konsumsi->makanan_id) == $makanan->id ? 'selected' : '' }}>
                                            {{ $makanan->nama_makanan }} ({{ $makanan->kalori }} kcal/porsi)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Tanggal --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="tanggal">Tanggal</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                    <input type="date" name="tanggal" id="tanggal" class="form-control" 
                                           value="{{ old('tanggal', $konsumsi->tanggal) }}" required>
                                </div>
                            </div>

                            {{-- Jumlah --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="jumlah text-warning">Jumlah Porsi</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text border-warning text-warning"><i class="bx bx-hash"></i></span>
                                    <input type="number" name="jumlah" id="jumlah" class="form-control border-warning" 
                                           min="1" value="{{ old('jumlah', $konsumsi->jumlah) }}" required>
                                </div>
                            </div>
                        </div>

                        {{-- Total Kalori Box --}}
                        <div class="alert alert-warning d-flex align-items-center mt-2 shadow-none border-0 bg-label-warning" role="alert">
                            <i class="bx bx-bolt-circle me-2"></i>
                            <div>
                                Total Energi Terkoreksi: <strong id="total_preview">0</strong> <strong>kcal</strong>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('backend.konsumsi_makanan.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-chevron-left me-1"></i> Batal
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

{{-- Script Kalkulator Kalori --}}
@push('scripts')
<script>
    const makananSelect = document.getElementById('makanan_id');
    const jumlahInput = document.getElementById('jumlah');
    const totalPreview = document.getElementById('total_preview');

    function calculateCalories() {
        const selectedOption = makananSelect.options[makananSelect.selectedIndex];
        const kaloriPerPorsi = parseFloat(selectedOption.getAttribute('data-kalori')) || 0;
        const jumlah = parseFloat(jumlahInput.value) || 0;

        const total = kaloriPerPorsi * jumlah;
        totalPreview.innerText = total.toLocaleString('id-ID');
    }

    makananSelect.addEventListener('change', calculateCalories);
    jumlahInput.addEventListener('input', calculateCalories);
    
    // Inisialisasi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', calculateCalories);
</script>
@endpush
@endsection