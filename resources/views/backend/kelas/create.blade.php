@extends('layouts.backend')

@section('content')
<div class="container mt-5" style="max-width: 10000px">
  <div class="card mb-4">
    <div class="card-header d-flex align-items-center justify-content-between">
      <h5 class="mb-0">Tambah Data Kelas</h5>
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

      <form action="{{ route('backend.kelas.store') }}" method="POST">
        @csrf

        {{-- Kelas --}}
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Kelas</label>
          <div class="col-sm-10">
            <input type="text" name="nama_kelas" class="form-control" placeholder="isi kelas" required>
          </div>
        </div>

        {{-- Tombol --}}
        <div class="row justify-content-end">
          <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('backend.kelas.index') }}" class="btn btn-secondary">Batal</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
