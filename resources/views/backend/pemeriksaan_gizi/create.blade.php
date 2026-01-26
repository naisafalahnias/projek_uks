@extends('layouts.backend')

@section('content')
<div class="container mt-5">
  <div class="card shadow-sm">
    <div class="card-header">
      <h5>Tambah Pemeriksaan Gizi</h5>
    </div>

    <div class="card-body">
      <form action="{{ route('backend.pemeriksaan_gizi.store') }}" method="POST">
        @csrf

        <div class="mb-3">
          <label>Siswa</label>
          <select name="siswa_id" class="form-control" required>
            <option value="">-- Pilih Siswa --</option>
            @foreach ($siswas as $siswa)
              <option value="{{ $siswa->id }}">{{ $siswa->nama }}</option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label>Tanggal</label>
          <input type="date" name="tanggal" class="form-control" required>
        </div>

        <div class="mb-3">
          <label>Berat Badan (kg)</label>
          <input type="number" step="0.01" name="berat_badan" class="form-control" required>
        </div>

        <div class="mb-3">
          <label>Tinggi Badan (cm)</label>
          <input type="number" step="0.01" name="tinggi_badan" class="form-control" required>
        </div>

        <div class="mb-3">
          <label>Keterangan</label>
          <textarea name="keterangan" class="form-control"></textarea>
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('backend.pemeriksaan_gizi.index') }}" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </div>
</div>
@endsection
