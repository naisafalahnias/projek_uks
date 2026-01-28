@extends('layouts.backend')

@section('content')
<div class="container mt-5" style="max-width: 10000px">
  <div class="card shadow-sm">
    <div class="px-4 pt-3">
      <h5 class="mb-0">Edit Data Makanan</h5>
    </div>

    <div class="card-body">
      <form action="{{ route('backend.makanans.update', $makanan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
          <label class="form-label">Nama Makanan</label>
          <input
            type="text"
            name="nama_makanan"
            class="form-control"
            value="{{ old('nama_makanan', $makanan->nama_makanan) }}"
            required
          >
        </div>

        <div class="mb-3">
          <label class="form-label">Jenis</label>
          <select name="jenis" class="form-select" required>
            <option value="snack" {{ $makanan->jenis == 'snack' ? 'selected' : '' }}>Snack</option>
            <option value="minuman" {{ $makanan->jenis == 'minuman' ? 'selected' : '' }}>Minuman</option>
            <option value="berat" {{ $makanan->jenis == 'berat' ? 'selected' : '' }}>Makanan Berat</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Kalori (kcal)</label>
          <input
            type="number"
            name="kalori"
            class="form-control"
            value="{{ old('kalori', $makanan->kalori) }}"
            required
          >
        </div>

        <div class="mb-3">
          <label class="form-label">Gula (gram)</label>
          <input
            type="number"
            step="0.01"
            name="gula"
            class="form-control"
            value="{{ old('gula', $makanan->gula) }}"
            required
          >
        </div>

        <div class="mb-3">
          <label class="form-label">Status</label>
          <select name="status" class="form-select" required>
            <option value="sehat" {{ $makanan->status == 'sehat' ? 'selected' : '' }}>Sehat</option>
            <option value="tidak_sehat" {{ $makanan->status == 'tidak_sehat' ? 'selected' : '' }}>
              Tidak Sehat
            </option>
          </select>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('backend.makanans.index') }}" class="btn btn-secondary">
          Kembali
        </a>
      </form>
    </div>
  </div>
</div>
@endsection
