@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Kesehatan /</span> Input Pemeriksaan Gizi
    </h4>

    <div class="row">
        <div class="col-xl">
            <div class="card mb-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center border-bottom mb-3">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="bx bx-bullseye me-1"></i> Data Antropometri Siswa
                    </h5>
                    <small class="text-muted">Gunakan satuan kg dan cm</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.pemeriksaan_gizi.store') }}" method="POST">
                        @csrf

                        {{-- Pilih Siswa --}}
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

                        <div class="row">
                            {{-- Tanggal --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="tanggal">Tanggal Periksa</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                </div>
                            </div>

                            {{-- Preview BMI --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kalkulasi BMI (Otomatis)</label>
                                <div class="p-2 border rounded bg-light d-flex align-items-center justify-content-center" style="height: 38px;">
                                    <h6 class="mb-0 text-primary" id="bmi_preview">0.0</h6>
                                    <small class="ms-2 text-muted" id="bmi_status"></small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Berat Badan --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="berat_badan">Berat Badan (kg)</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-scale"></i></span>
                                    <input type="number" step="0.01" name="berat_badan" id="berat_badan" class="form-control" placeholder="0.00" required>
                                </div>
                            </div>

                            {{-- Tinggi Badan --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="tinggi_badan">Tinggi Badan (cm)</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-ruler"></i></span>
                                    <input type="number" step="0.01" name="tinggi_badan" id="tinggi_badan" class="form-control" placeholder="0.00" required>
                                </div>
                            </div>
                        </div>

                        {{-- Keterangan --}}
                        <div class="mb-4">
                            <label class="form-label" for="keterangan">Keterangan / Catatan Gizi</label>
                            <textarea name="keterangan" id="keterangan" class="form-control" rows="2" placeholder="Tambahkan catatan jika diperlukan">{{ old('keterangan') }}</textarea>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('backend.pemeriksaan_gizi.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-x me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-4 shadow">
                                <i class="bx bx-save me-1"></i> Simpan Data Gizi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script Kalkulator BMI Otomatis --}}
@push('scripts')
<script>
    const bbInput = document.getElementById('berat_badan');
    const tbInput = document.getElementById('tinggi_badan');
    const bmiPreview = document.getElementById('bmi_preview');
    const bmiStatus = document.getElementById('bmi_status');

    function calculateBMI() {
        const bb = parseFloat(bbInput.value);
        const tb = parseFloat(tbInput.value) / 100; // Ubah cm ke meter

        if (bb > 0 && tb > 0) {
            const bmi = (bb / (tb * tb)).toFixed(1);
            bmiPreview.innerText = bmi;

            // Beri label status sederhana
            if (bmi < 18.5) {
                bmiStatus.innerText = '(Kurus)';
                bmiStatus.className = 'ms-2 text-warning';
            } else if (bmi >= 18.5 && bmi <= 25) {
                bmiStatus.innerText = '(Normal)';
                bmiStatus.className = 'ms-2 text-success';
            } else {
                bmiStatus.innerText = '(Overweight)';
                bmiStatus.className = 'ms-2 text-danger';
            }
        } else {
            bmiPreview.innerText = '0.0';
            bmiStatus.innerText = '';
        }
    }

    bbInput.addEventListener('input', calculateBMI);
    tbInput.addEventListener('input', calculateBMI);
</script>
@endpush
@endsection