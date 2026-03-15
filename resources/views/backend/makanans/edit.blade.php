@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Kantin /</span> Edit Nutrisi Makanan
    </h4>

    <div class="row">
        <div class="col-xl">
            <div class="card mb-4 shadow-sm border-top border-warning border-3">
                <div class="card-header d-flex justify-content-between align-items-center border-bottom mb-3">
                    <h5 class="mb-0 text-warning fw-bold">
                        <i class="bx bx-edit-alt me-1"></i> Perbarui Menu: {{ $makanan->nama_makanan }}
                    </h5>
                    <small class="text-muted">ID Menu: #{{ $makanan->id }}</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.makanans.update', $makanan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Nama Makanan --}}
                        <div class="mb-3">
                            <label class="form-label" for="nama_makanan">Nama Makanan / Minuman</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text bg-label-warning text-warning"><i class="bx bx-restaurant"></i></span>
                                <input type="text" name="nama_makanan" id="nama_makanan" 
                                       class="form-control border-warning @error('nama_makanan') is-invalid @enderror" 
                                       value="{{ old('nama_makanan', $makanan->nama_makanan) }}" required>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Jenis --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="jenis">Kategori</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-category"></i></span>
                                    <select name="jenis" id="jenis" class="form-select" required>
                                        <option value="snack" {{ old('jenis', $makanan->jenis) == 'snack' ? 'selected' : '' }}>Snack / Camilan</option>
                                        <option value="minuman" {{ old('jenis', $makanan->jenis) == 'minuman' ? 'selected' : '' }}>Minuman</option>
                                        <option value="berat" {{ old('jenis', $makanan->jenis) == 'berat' ? 'selected' : '' }}>Makanan Berat</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="status">Penilaian Kesehatan</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-check-shield"></i></span>
                                    <select name="status" id="status" class="form-select border-warning" required>
                                        <option value="sehat" {{ old('status', $makanan->status) == 'sehat' ? 'selected' : '' }}>✅ Sehat</option>
                                        <option value="tidak_sehat" {{ old('status', $makanan->status) == 'tidak_sehat' ? 'selected' : '' }}>❌ Tidak Sehat</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            {{-- Kalori --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="kalori">Energi (Kalori)</label>
                                <div class="input-group input-group-merge shadow-none">
                                    <span class="input-group-text bg-label-warning text-warning"><i class="bx bx-bolt-circle"></i></span>
                                    <input type="number" name="kalori" id="kalori" class="form-control border-warning" 
                                           value="{{ old('kalori', $makanan->kalori) }}" required>
                                    <span class="input-group-text border-warning">kcal</span>
                                </div>
                            </div>

                            {{-- Gula --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="gula">Kandungan Gula</label>
                                <div class="input-group input-group-merge shadow-none">
                                    <span class="input-group-text bg-label-warning text-warning"><i class="bx bx-water"></i></span>
                                    <input type="number" step="0.01" name="gula" id="gula" class="form-control border-warning" 
                                           value="{{ old('gula', $makanan->gula) }}" required>
                                    <span class="input-group-text border-warning">gram</span>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('backend.makanans.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-chevron-left me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-warning px-4 shadow text-white">
                                <i class="bx bx-refresh me-1"></i> Update Menu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection