@extends('layouts.backend')

@section('content')
<div class="container mt-5" style="max-width: 10000px"> {{-- atau 800px --}}
<div class="col-xxl">
  <div class="card mb-4">
    <div class="card-header d-flex align-items-center justify-content-between">
      <h5 class="mb-0">Tambah Data Petugas</h5>
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

      <form action="{{ route('petugas.store') }}" method="POST">
        @csrf

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Nama</label>
          <div class="col-sm-10">
            <input type="text" name="nama" class="form-control" placeholder="" required>
          </div>
        </div>
        {{-- role --}}
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Role</label>
          <div class="col-sm-10">
            <select name="kelas_id" class="form-select">
              <option disabled selected>Pilih role</option>
              @foreach ($users as $data)
                <option value="{{ $data->id }}" {{ old('user_id') == $data->id ? 'selected' : '' }}>
                  {{ $data->name }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">No HP</label>
          <div class="col-sm-10">
            <input type="number" name="no_hp" class="form-control" placeholder="" required>
          </div>
        </div>

        {{-- Tombol --}}
        <div class="row justify-content-end">
          <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('backend.petugas.index') }}" class="btn btn-secondary">Batal</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
@endsection
