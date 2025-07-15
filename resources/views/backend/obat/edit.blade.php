@extends('layouts.backend')

@section('content')
<div class="container mt-5" style="max-width: 10000px">
  <div class="card mb-4">
    <div class="card-header d-flex align-items-center justify-content-between">
      <h5 class="mb-0">Ubah Data Obat</h5>
      <small class="text-muted float-end"></small>
    </div>
    <div class="card-body">
      {{-- Tampilkan error validasi --}}
      @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('obat.update', $obat->id) }}" method="POST">
        @csrf

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Nama Obat</label>
          <div class="col-sm-10">
            <input type="text" name="nama_obat" class="form-control" placeholder="" value="{{ $obat->nama_obat }}" required>
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Kategori</label>
          <div class="col-sm-10">
            <input type="text" name="kategori" class="form-control" placeholder="" value="{{ $obat->kategori }}" required>
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Stok</label>
          <div class="col-sm-10">
            <input type="text" name="stok" class="form-control" placeholder="" value="{{ $obat->stok }}" required>
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Tanggal Kadaluarsa</label>
          <div class="col-sm-10">
            <input type="date" name="tgl_kadaluarsa" class="form-control" placeholder="" value="{{ $obat->tgl_kadaluarsa }}" required>
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Unit</label>
          <div class="col-sm-10">
            <input type="text" name="unit" class="form-control" placeholder="" value="{{ $obat->unit }}" required>
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Deskripsi</label>
          <div class="col-sm-10">
            <input type="text" name="deskripsi" class="form-control" placeholder="" value="{{ $obat->deskripsi }}" required>
          </div>
        </div>

        {{-- Tombol --}}
        <div class="row justify-content-end">
          <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('backend.obat.index') }}" class="btn btn-secondary">Batal</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
