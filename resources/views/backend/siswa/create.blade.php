@extends('layouts.backend')

@section('content')
<div class="container mt-5" style="max-width: 10000px">
  <div class="card mb-4">
    <div class="card-header d-flex align-items-center justify-content-between">
      <h5 class="mb-0">Tambah Data Siswa</h5>
      <small class="text-muted float-end">Formulir Siswa</small>
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

      <form action="{{ route('siswa.store') }}" method="POST">
        @csrf

        {{-- Pilih User --}}
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Nama Siswa</label>
          <div class="col-sm-10">
            <input type="text" name="nama" class="form-control" placeholder="" required>
          </div>
        </div>

        {{-- Kelas --}}
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Kelas</label>
          <div class="col-sm-10">
            <select name="kelas_id" class="form-select">
              <option disabled selected>-- Pilih Kelas --</option>
              @foreach ($kelas as $data)
                <option value="{{ $data->id }}" {{ old('kelas_id') == $data->id ? 'selected' : '' }}>
                  {{ $data->nama_kelas }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        {{-- Jenis Kelamin --}}
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
          <div class="col-sm-10">
            <select name="jenis_kelamin" class="form-select" required>
              <option value="">-- Pilih Jenis Kelamin --</option>
              <option value="L">Laki-laki</option>
              <option value="P">Perempuan</option>
            </select>
          </div>
        </div>
        
        {{-- Tombol --}}
        <div class="row justify-content-end">
          <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('backend.siswa.index') }}" class="btn btn-secondary">Batal</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
