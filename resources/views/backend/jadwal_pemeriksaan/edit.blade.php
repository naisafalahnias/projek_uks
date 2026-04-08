@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Pemeriksaan /</span> Edit Jadwal
    </h4>

    <div class="row">
        <div class="col-xl">
            <div class="card mb-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center border-bottom mb-3">
                    <h5 class="mb-0 text-warning fw-bold">
                        <i class="bx bx-edit-alt me-1"></i> Perbarui Jadwal Pemeriksaan
                    </h5>
                    <small class="text-muted float-end">ID Jadwal: #{{ $jadwal_pemeriksaan->id }}</small>
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

                    <form action="{{ route('backend.jadwal_pemeriksaan.update', $jadwal_pemeriksaan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- Tanggal --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="tanggal">Tanggal Pemeriksaan</label>
                                <div class="input-group input-group-merge shadow-none">
                                    <span class="input-group-text bg-label-warning"><i class="bx bx-calendar text-warning"></i></span>
                                    <input type="date" name="tanggal" id="tanggal" class="form-control" 
                                           value="{{ old('tanggal', $jadwal_pemeriksaan->tanggal) }}" required>
                                </div>
                            </div>

                            {{-- Kelas --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="kelas_id">Target Kelas</label>
                                <div class="input-group input-group-merge shadow-none">
                                    <span class="input-group-text bg-label-warning"><i class="bx bx-buildings text-warning"></i></span>
                                    <select name="kelas_id" id="kelas_id" class="form-select" required>
                                        <option disabled>Pilih Kelas</option>
                                        @foreach ($kelas as $data)
                                            <option value="{{ $data->id }}"
                                                {{ old('kelas_id', $jadwal_pemeriksaan->kelas_id) == $data->id ? 'selected' : '' }}>
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
                                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                </div>
                            </div>
                        </div>

                        {{-- Keterangan --}}
                        <div class="mb-4">
                            <label class="form-label" for="keterangan">Keterangan / Catatan Tambahan</label>
                            <div class="input-group input-group-merge shadow-none">
                                <span class="input-group-text bg-label-warning"><i class="bx bx-note text-warning"></i></span>
                                <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" 
                                          rows="3" placeholder="Contoh: Perubahan jam pemeriksaan">{{ old('keterangan', $jadwal_pemeriksaan->keterangan) }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('backend.jadwal_pemeriksaan.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-arrow-back me-1"></i> Kembali
                            </a>
                            
                            {{-- Tambahkan class btn-update dan ubah type jadi button --}}
                            <button type="button" class="btn btn-warning px-4 shadow text-white btn-update">
                                <i class="bx bx-refresh me-1"></i> Perbarui Jadwal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection