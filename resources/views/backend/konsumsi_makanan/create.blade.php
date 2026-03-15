@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-top border-primary border-3">
                <div class="card-header border-bottom mb-4">
                    <h5 class="mb-0 text-primary fw-bold">Catat Konsumsi Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.konsumsi_makanan.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Pilih Siswa</label>
                            <select name="siswa_id" class="form-select" required>
                                <option value="">-- Pilih Siswa --</option>
                                @foreach ($siswas as $siswa)
                                    {{-- PAKAI $siswa->id dan $siswa->nama --}}
                                    <option value="{{ $siswa->id }}">{{ $siswa->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pilih Makanan</label>
                            <select name="makanan_id" id="makanan_id" class="form-select" required>
                                <option value="" data-kalori="0">-- Pilih Makanan --</option>
                                @foreach ($makanans as $makanan)
                                    {{-- PAKAI $makanan->id dan $makanan->nama_makanan --}}
                                    <option value="{{ $makanan->id }}" data-kalori="{{ $makanan->kalori }}">
                                        {{ $makanan->nama_makanan }} ({{ $makanan->kalori }} kcal)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jumlah Porsi</label>
                                <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" value="1" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('backend.konsumsi_makanan.index') }}" class="btn btn-outline-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection