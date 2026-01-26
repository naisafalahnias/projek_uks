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

      <form action="{{ route('backend.rekam_medis.update', $rekam_medis->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
          <label class="col-sm-2 col-form-label">Pilih Siswa</label>
          <select class="form-control" disabled>
            <option selected>{{ $rekam_medis->siswa->nama }}</option>
          </select>
          <input type="hidden" name="siswa_id" value="{{ $rekam_medis->siswa->id }}">
          @error('siswa_id')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
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
            <textarea name="tindakan" class="form-control @error('tindakan') is-invalid @enderror">
              {{ old('tindakan', $rekam_medis->tindakan) }}
            </textarea>
            @error('tindakan')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror         
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Obat yang diberikan</label>
          <div class="col-sm-10">
            @foreach ($rekam_medis->rekam_medis_obat as $item)
              <div class="row mb-2">
                <div class="col-md-6">
                  <input type="text" class="form-control"
                    value="{{ $item->obat->nama_obat }} ({{ $item->obat->unit }})"
                    readonly>
                </div>
                <div class="col-md-3">
                  <input type="number"
                    name="jumlah[{{ $item->id }}]"
                    value="{{ $item->jumlah }}"
                    class="form-control">
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Petugas</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Status</label>
          <div class="col-sm-10">
            <input type="text"
              name="status"
              class="form-control @error('status') is-invalid @enderror"
              placeholder="isi status"
              value="{{ old('status', $rekam_medis->status) }}"
              required>
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
