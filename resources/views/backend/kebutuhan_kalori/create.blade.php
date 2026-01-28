@extends('layouts.backend')

@section('content')
<div class="container mt-5" style="max-width: 900px">
  <div class="card shadow-sm p-4">
    <h5 class="mb-3">Tambah Kebutuhan Kalori</h5>

    <form action="{{ route('backend.kebutuhan_kalori.store') }}" method="POST">
      @csrf

      <div class="mb-3">
        <label class="form-label">Siswa</label>
        <select name="siswa_id" class="form-control" required>
          <option value="">-- Pilih Siswa --</option>
          @foreach ($siswas as $siswa)
            <option value="{{ $siswa->id }}">
              {{ $siswa->nama }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Kebutuhan Kalori Harian (kkal)</label>
        <input type="number"
               name="kebutuhan_harian"
               class="form-control"
               min="0"
               required>
      </div>

      <div class="mb-3">
        <label class="form-label">Tingkat Aktivitas</label>
        <select name="tingkat_aktivitas" class="form-control" required>
          <option value="">-- Pilih Aktivitas --</option>
          <option value="rendah">Rendah</option>
          <option value="sedang">Sedang</option>
          <option value="tinggi">Tinggi</option>
        </select>
      </div>

      <div class="d-flex justify-content-end">
        <a href="{{ route('backend.kebutuhan_kalori.index') }}"
           class="btn btn-secondary me-2">
          Kembali
        </a>
        <button class="btn btn-primary">
          Simpan
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
