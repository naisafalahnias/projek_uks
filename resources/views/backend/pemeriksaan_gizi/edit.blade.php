@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Kesehatan /</span> Edit Pemeriksaan Gizi
    </h4>

    <div class="row">
        <div class="col-xl">
            <div class="card mb-4 shadow-sm border-top border-warning border-3">
                <div class="card-header d-flex justify-content-between align-items-center border-bottom mb-3">
                    <h5 class="mb-0 text-warning fw-bold">
                        <i class="bx bx-edit-alt me-1"></i> Perbarui Data Antropometri
                    </h5>
                    <small class="text-muted">Data ID: #{{ $pemeriksaan->id }}</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.pemeriksaan_gizi.update', $pemeriksaan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Siswa (Biasanya tidak diubah, tapi kita buat tetap select dengan style rapi) --}}
                        <div class="mb-3">
                            <label class="form-label" for="siswa_id">Siswa</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text bg-light"><i class="bx bx-user"></i></span>
                                <select name="siswa_id" id="siswa_id" class="form-select @error('siswa_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Siswa --</option>
                                    @foreach ($siswas as $siswa)
                                        <option value="{{ $siswa->id }}" {{ $pemeriksaan->siswa_id == $siswa->id ? 'selected' : '' }}>
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
                                    <input type="date" name="tanggal" id="tanggal" class="form-control" 
                                           value="{{ old('tanggal', $pemeriksaan->tanggal) }}" required>
                                </div>
                            </div>

                            {{-- Live BMI Preview --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-warning fw-bold">Kalkulasi BMI Terupdate</label>
                                <div class="p-2 border border-warning rounded bg-label-warning d-flex align-items-center justify-content-center" style="height: 38px;">
                                    <h6 class="mb-0 fw-bold" id="bmi_preview">0.0</h6>
                                    <small class="ms-2 fw-semibold" id="bmi_status"></small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Berat Badan --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="berat_badan">Berat Badan (kg)</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-scale"></i></span>
                                    <input type="number" step="0.01" name="berat_badan" id="berat_badan" 
                                           class="form-control" value="{{ old('berat_badan', $pemeriksaan->berat_badan) }}" required>
                                </div>
                            </div>

                            {{-- Tinggi Badan --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="tinggi_badan">Tinggi Badan (cm)</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-ruler"></i></span>
                                    <input type="number" step="0.01" name="tinggi_badan" id="tinggi_badan" 
                                           class="form-control" value="{{ old('tinggi_badan', $pemeriksaan->tinggi_badan) }}" required>
                                </div>
                            </div>
                        </div>

                        {{-- Keterangan --}}
                        <div class="mb-4">
                            <label class="form-label" for="keterangan">Keterangan Tambahan</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-comment-detail"></i></span>
                                <textarea name="keterangan" id="keterangan" class="form-control" 
                                          rows="3" placeholder="Update catatan gizi jika ada">{{ old('keterangan', $pemeriksaan->keterangan) }}</textarea>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('backend.pemeriksaan_gizi.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-chevron-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-warning px-4 shadow text-white">
                                <i class="bx bx-refresh me-1"></i> Update Data Gizi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const bbInput = document.getElementById('berat_badan');
    const tbInput = document.getElementById('tinggi_badan');
    const bmiPreview = document.getElementById('bmi_preview');
    const bmiStatus = document.getElementById('bmi_status');

    function calculateBMI() {
        const bb = parseFloat(bbInput.value);
        const tb = parseFloat(tbInput.value) / 100; // cm ke m

        if (bb > 0 && tb > 0) {
            const bmi = (bb / (tb * tb)).toFixed(1);
            bmiPreview.innerText = bmi;

            if (bmi < 18.5) {
                bmiStatus.innerText = '• Kurang';
                bmiStatus.className = 'ms-2 text-dark opacity-75';
            } else if (bmi >= 18.5 && bmi <= 25) {
                bmiStatus.innerText = '• Normal';
                bmiStatus.className = 'ms-2 text-success';
            } else {
                bmiStatus.innerText = '• Berlebih';
                bmiStatus.className = 'ms-2 text-danger';
            }
        } else {
            bmiPreview.innerText = '0.0';
            bmiStatus.innerText = '';
        }
    }

    // Jalankan kalkulasi saat pertama kali load
    window.onload = calculateBMI;

    // Jalankan saat input berubah
    bbInput.addEventListener('input', calculateBMI);
    tbInput.addEventListener('input', calculateBMI);
</script>
@endpush
@endsection