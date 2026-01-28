@extends('layouts.backend')

@section('content')
<div class="container mt-5" style="max-width: 10000px">
  <div class="card shadow-sm">
    <div class="px-4 pt-3">
      <h5 class="mb-0">Tambah Data Makanan</h5>
    </div>

    <div class="card-body">
      <form action="{{ route('backend.makanans.store') }}" method="POST">
        @csrf

        <div class="mb-3">
          <label class="form-label">Nama Makanan</label>
          <input type="text" name="nama_makanan" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Jenis</label>
          <select name="jenis" class="form-select" required>
            <option value="">-- Pilih Jenis --</option>
            <option value="snack">Snack</option>
            <option value="minuman">Minuman</option>
            <option value="berat">Makanan Berat</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Kalori (kcal)</label>
          <input type="number" name="kalori" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Gula (gram)</label>
          <input type="number" step="0.01" name="gula" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Status</label>
          <select name="status" class="form-select" required>
            <option value="">-- Pilih Status --</option>
            <option value="sehat">Sehat</option>
            <option value="tidak_sehat">Tidak Sehat</option>
          </select>
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('backend.makanans.index') }}" class="btn btn-secondary">
          Kembali
        </a>
      </form>
    </div>
  </div>
</div>
@endsection
