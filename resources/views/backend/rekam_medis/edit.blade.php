@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Kesehatan /</span> Edit Rekam Medis
    </h4>

    <div class="row">
        <div class="col-xl">
            <div class="card mb-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center border-bottom mb-3">
                    <h5 class="mb-0 text-warning fw-bold">
                        <i class="bx bx-edit-alt me-1"></i> Perbarui Data Kesehatan
                    </h5>
                    <small class="text-muted">No. Rekam Medis: #{{ $rekam_medis->id }}</small>
                </div>
                <div class="card-body">
                    {{-- Alert Error --}}
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

                    <form action="{{ route('backend.rekam_medis.update', $rekam_medis->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Nama Siswa (Read Only) --}}
                        <div class="mb-3">
                            <label class="form-label">Pasien / Siswa</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text bg-light"><i class="bx bx-user"></i></span>
                                <input type="text" class="form-control bg-light" value="{{ $rekam_medis->siswa->nama }}" readonly>
                                <input type="hidden" name="siswa_id" value="{{ $rekam_medis->siswa->id }}">
                            </div>
                        </div>

                        <div class="row">
                            {{-- Tanggal --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="tanggal">Tanggal</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal', $rekam_medis->tanggal) }}" required>
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="status">Status / Tindak Lanjut</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-git-branch"></i></span>
                                    <select name="status" id="status" class="form-select" required>
                                        <option value="kelas" {{ old('status', $rekam_medis->status) == 'kelas' ? 'selected' : '' }}>Kembali ke Kelas</option>
                                        <option value="uks" {{ old('status', $rekam_medis->status) == 'uks' ? 'selected' : '' }}>Istirahat di UKS</option>
                                        <option value="pulang" {{ old('status', $rekam_medis->status) == 'pulang' ? 'selected' : '' }}>Pulang</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Keluhan --}}
                        <div class="mb-3">
                            <label class="form-label" for="keluhan">Keluhan Utama</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-error-alt"></i></span>
                                <input type="text" name="keluhan" id="keluhan" class="form-control" value="{{ old('keluhan', $rekam_medis->keluhan) }}" required>
                            </div>
                        </div>

                        {{-- Tindakan --}}
                        <div class="mb-4">
                            <label class="form-label" for="tindakan">Tindakan Medis</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-first-aid"></i></span>
                                <textarea name="tindakan" id="tindakan" class="form-control" rows="2" required>{{ old('tindakan', $rekam_medis->tindakan) }}</textarea>
                            </div>
                        </div>

                        {{-- Bagian Obat --}}
                        <div class="card bg-label-secondary border-0 mb-4">
                            <div class="card-body p-3">
                                <h6 class="fw-bold mb-3"><i class="bx bx-capsule me-1"></i> Edit Jumlah Obat</h6>
                                @forelse ($rekam_medis->rekam_medis_obat as $item)
                                    <div class="row g-2 mb-2 align-items-center">
                                        <div class="col-md-8">
                                            <input type="text" class="form-control form-control-sm bg-white border-0" 
                                                   value="{{ $item->obat->nama_obat }} ({{ $item->obat->unit }})" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group input-group-sm">
                                                <input type="number" name="jumlah[{{ $item->id }}]" 
                                                       value="{{ old('jumlah.'.$item->id, $item->jumlah) }}" 
                                                       class="form-control border-warning" placeholder="Jumlah">
                                                <span class="input-group-text border-warning bg-warning text-white small">Qty</span>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <small class="text-muted fst-italic">Tidak ada obat yang diberikan sebelumnya.</small>
                                @endforelse
                            </div>
                        </div>

                        {{-- Petugas --}}
                        <div class="mb-4">
                            <label class="form-label">Petugas Pengubah</label>
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