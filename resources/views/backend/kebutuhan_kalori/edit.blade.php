@extends('layouts.backend')

@section('content')
<div class="container mt-5" style="max-width: 900px">
  <div class="card shadow-sm p-4">
    <h5 class="mb-3">Edit Kebutuhan Kalori</h5>

    <form action="{{ route('backend.kebutuhan_kalori.update', $kebutuhanKalori->id) }}"
          method="POST">
      @csrf
      @method('PUT')

      <div class="mb-3">
        <label class="form-label">Siswa</label>
        <select name="siswa_id" class="form-control" required>
          @foreach ($siswas as $siswa)
            <option value="{{ $siswa->id }}"
              {{ $kebutuhanKalori->siswa_id == $siswa->id ? 'selected' : '' }}>
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
               value="{{ $kebutuhanKalori->kebutuhan_harian }}"
               required>
      </div>

      <div class="mb-3">
        <label class="form-label">Tingkat Aktivitas</label>
        <select name="tingkat_aktivitas" class="form-control" required>
          <option value="rendah"
            {{ $kebutuhanKalori->tingkat_aktivitas == 'rendah' ? 'selected' : '' }}>
            Rendah
          </option>
          <option value="sedang"
            {{ $kebutuhanKalori->tingkat_aktivitas == 'sedang' ? 'selected' : '' }}>
            Sedang
          </option>
          <option value="tinggi"
            {{ $kebutuhanKalori->tingkat_aktivitas == 'tinggi' ? 'selected' : '' }}>
            Tinggi
          </option>
        </select>
      </div>

      <div class="d-flex justify-content-end">
        <a href="{{ route('backend.kebutuhan_kalori.index') }}"
           class="btn btn-secondary me-2">
          Kembali
        </a>
        <button class="btn btn-primary">
          Update
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
