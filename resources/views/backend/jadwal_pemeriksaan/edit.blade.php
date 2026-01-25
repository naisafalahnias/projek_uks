@extends('layouts.backend')

@section('content')
<div class="container mt-5" style="max-width: 10000px"> {{-- Biar nggak full width --}}
  <div class="card mb-4">
    <div class="card-header d-flex align-items-center justify-content-between">
      <h5 class="mb-0">Ubah Jadwal Pemeriksaan</h5>
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

      <form action="{{ route('backend.jadwal_pemeriksaan.update', $jadwal_pemeriksaan->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Tanggal --}}
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Tanggal</label>
          <div class="col-sm-10">
            <input type="date" name="tanggal" class="form-control" 
                   value="{{ old('tanggal', $jadwal_pemeriksaan->tanggal) }}">
          </div>
        </div>

        {{-- Kelas --}}
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Kelas</label>
          <div class="col-sm-10">
            <select name="kelas_id" class="form-select">
              <option disabled>Pilih Kelas</option>
              @foreach ($kelas as $data)
                <option value="{{ $data->id }}"
                  {{ old('kelas_id', $jadwal_pemeriksaan->kelas_id) == $data->id ? 'selected' : '' }}>
                  {{ $data->nama_kelas }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        {{-- Petugas --}}
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Petugas</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
          </div>
        </div>

        {{-- Keterangan --}}
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Keterangan</label>
          <div class="col-sm-10">
            <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $jadwal_pemeriksaan->keterangan) }}</textarea>
            @error('keterangan')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        {{-- Tombol --}}
        <div class="row justify-content-end">
          <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Ubah</button>
            <a href="{{ route('backend.jadwal_pemeriksaan.index') }}" class="btn btn-secondary">Batal</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
