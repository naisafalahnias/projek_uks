@extends('layouts.backend')

@section('content')
<div class="col-xxl">
  <div class="card mb-4">
    <div class="card-header d-flex align-items-center justify-content-between">
      <h5 class="mb-0">Ubah Rekam Medis</h5>
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

      <form action="{{ route('rekam_medis.update', $rekam_medis->id) }}" method="POST">
        @csrf

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Siswa</label>
          <div class="col-sm-10">
            <select name="siswa_id" class="form-select">
              <option disabled selected>Pilih Siswa</option>
              @foreach ($siswa as $data)
                <option value="{{ $data->id }}" {{ old('siswa_id') == $data->id ? 'selected' : '' }} >
                  {{ $data->nama }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">tanggal</label>
          <div class="col-sm-10">
            <input type="date" name="tanggal" class="form-control" placeholder="" value="{{ $rekam_medis->tanggal }}" required>
            @error('tanggal')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror         
          </div>
        </div>
        
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Keluhan</label>
          <div class="col-sm-10">
            <input type="text" name="keluhan" class="form-control" placeholder="isi keluhan" value="{{ $rekam_medis->keluhan }}" required>
            @error('keluhan')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror         
          </div>
        </div>
        
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Tindakan</label>
          <div class="col-sm-10">
            <textarea name="tindakan" class="form-control @error('tindakan') is-invalid @enderror">{{ old('tindakan') }}</textarea> 
            @error('tindakan')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror         
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Obat</label>
          <div class="col-sm-10">
            <select name="obat_id" class="form-select">
              <option disabled selected>Pilih obat</option>
              @foreach ($obat as $data)
                <option value="{{ $data->id }}" {{ old('obat_id') == $data->id ? 'selected' : '' }}>
                  {{ $data->nama_obat }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Petugas</label>
          <div class="col-sm-10">
            <select name="user_id" class="form-select">
              <option disabled selected>Pilih user</option>
              @foreach ($users as $data)
                <option value="{{ $data->id }}" {{ old('user_id') == $data->id ? 'selected' : '' }}>
                  {{ $data->name }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Status</label>
          <div class="col-sm-10">
            <input type="text" name="status" class="form-control" placeholder="isi status" required>
            @error('status')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror         
          </div>
        </div>
      
        {{-- Tombol --}}
        <div class="row justify-content-end">
          <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Ubah</button>
            <a href="{{ route('backend.rekam_medis.index') }}" class="btn btn-secondary">Batal</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
