@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Siswa /</span> Perbarui Kondisi Kesehatan
    </h4>

    <div class="row">
        <div class="col-xl">
            <div class="card mb-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center border-bottom mb-3">
                    <h5 class="mb-0 text-warning fw-bold">
                        <i class="bx bx-edit-alt me-1"></i> Edit Data Kesehatan Siswa
                    </h5>
                    <small class="text-muted">ID Record: #{{ $kondisi->id }}</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.kondisi_kesehatan.update', $kondisi->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Pilih Siswa (Disabled) --}}
                        <div class="mb-3">
                            <label class="form-label" for="siswa_id">Pasien / Siswa</label>
                            <div class="input-group input-group-merge shadow-none">
                                <span class="input-group-text bg-light"><i class="bx bx-user"></i></span>
                                <select name="siswa_id_disabled" id="siswa_id" class="form-select bg-light" disabled>
                                    @foreach ($siswas as $siswa)
                                        <option value="{{ $siswa->id }}"
                                            {{ $siswa->id == $kondisi->siswa_id ? 'selected' : '' }}>
                                            {{ $siswa->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="siswa_id" value="{{ $kondisi->siswa_id }}">
                            </div>
                            <div class="form-text text-warning small"><i class="bx bx-info-circle"></i> Identitas siswa tidak dapat diubah untuk menjaga riwayat medis.</div>
                        </div>

                        <div class="row">
                            {{-- Nama Kondisi --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="nama_kondisi">Kondisi / Diagnosa</label>
                                <div class="input-group input-group-merge shadow-none">
                                    <span class="input-group-text bg-label-warning"><i class="bx bx-pulse text-warning"></i></span>
                                    <input type="text" name="nama_kondisi" id="nama_kondisi" 
                                           class="form-control border-warning @error('nama_kondisi') is-invalid @enderror" 
                                           value="{{ old('nama_kondisi', $kondisi->nama_kondisi) }}" required>
                                </div>
                                @error('nama_kondisi')
                                    <small class="text-danger mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Tanggal --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="tanggal">Tanggal Diagnosa</label>
                                <div class="input-group input-group-merge shadow-none">
                                    <span class="input-group-text bg-label-warning"><i class="bx bx-calendar text-warning"></i></span>
                                    <input type="date" name="tanggal" id="tanggal" 
                                           class="form-control border-warning @error('tanggal') is-invalid @enderror" 
                                           value="{{ old('tanggal', $kondisi->tanggal) }}" required>
                                </div>
                                @error('tanggal')
                                    <small class="text-danger mt-1">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- Keterangan --}}
                        <div class="mb-4">
                            <label class="form-label" for="keterangan">Catatan Medis & Penanganan</label>
                            <div class="input-group input-group-merge shadow-none">
                                <span class="input-group-text bg-label-warning"><i class="bx bx-note text-warning"></i></span>
                                <textarea name="keterangan" id="keterangan" 
                                          class="form-control border-warning" 
                                          rows="4" placeholder="Update detail penanganan...">{{ old('keterangan', $kondisi->keterangan) }}</textarea>
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- Tombol --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('backend.kondisi_kesehatan.index') }}" class="btn btn-outline-secondary">
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