@extends('layouts.backend')

@section('content')
<div class="container mt-5" style="max-width: 900px">
  <div class="card shadow-sm p-4">
    <h5 class="mb-3">Edit Konsumsi Makanan</h5>

    <form action="{{ route('backend.konsumsi_makanan.update', $konsumsi->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="mb-3">
        <label class="form-label">Siswa</label>
        <select name="siswa_id" class="form-control" required>
          @foreach ($siswas as $siswa)
            <option value="{{ $siswa->id }}"
              {{ $konsumsi->siswa_id == $siswa->id ? 'selected' : '' }}>
              {{ $siswa->nama }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Makanan</label>
        <select name="makanan_id" class="form-control" required>
          @foreach ($makanans as $makanan)
            <option value="{{ $makanan->id }}"
              {{ $konsumsi->makanan_id == $makanan->id ? 'selected' : '' }}>
              {{ $makanan->nama_makanan }} ({{ $makanan->kalori }} kkal)
            </option>
          @endforeach
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Tanggal</label>
        <input type="date"
               name="tanggal"
               class="form-control"
               value="{{ $konsumsi->tanggal }}"
               required>
      </div>

      <div class="mb-3">
        <label class="form-label">Jumlah</label>
        <input type="number"
               name="jumlah"
               class="form-control"
               min="1"
               value="{{ $konsumsi->jumlah }}"
               required>
      </div>

      <div class="d-flex justify-content-end">
        <a href="{{ route('backend.konsumsi_makanan.index') }}"
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
