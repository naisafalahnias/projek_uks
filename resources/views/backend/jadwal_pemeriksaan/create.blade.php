@extends('layouts.backend')

@section('content')
<div class="col-xxl">
  <div class="card mb-4">
    <div class="card-header d-flex align-items-center justify-content-between">
      <h5 class="mb-0">Tambah Jadwal</h5>
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

      <form action="{{ route('jadwal_pemeriksaan.store') }}" method="POST">
        @csrf

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Tanggal</label>
          <div class="col-sm-10">
            <input type="date" name="tanggal" class="form-control" placeholder="" required>
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Kelas</label>
          <div class="col-sm-10">
            <select name="kelas_id" class="form-select">
              <option disabled selected>Pilih Kelas</option>
              @foreach ($kelas as $data)
                <option value="{{ $data->id }}" {{ old('kelas_id') == $data->id ? 'selected' : '' }}>
                  {{ $data->nama_kelas }}
                </option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="mb-3">
          <label for="user_id">Petugas</label>
            <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
              <option value="">-- Pilih Petugas --</option>
              @foreach ($users as $item)
                <option value="{{ $item->id }}"
                  {{ old('user_id') == $item->id ? 'selected' : '' }}>
                  {{ $item->name }}
                </option>
              @endforeach
            </select>
            @error('user_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Keterangan</label>
          <div class="col-sm-10">
            <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea> 
            @error('keterangan')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror         
          </div>
        </div>
      
        {{-- Tombol --}}
        <div class="row justify-content-end">
          <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('jadwal_pemeriksaan.index') }}" class="btn btn-secondary">Batal</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
