@extends('layouts.backend')

@section('content')
<div class="container mt-5" style="max-width: 10000px">
  <div class="card mb-4">
    <div class="card-header d-flex align-items-center justify-content-between">
      <h5 class="mb-0">Tambah Rekam Medis</h5>
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

      <form action="{{ route('backend.rekam_medis.store') }}" method="POST">
        @csrf

        {{-- Pilih Kelas --}}
        <div class="mb-3">
          <label class="col-sm-2 col-form-label">Pilih Kelas</label>
          <select id="kelasSelect" name="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror">
            <option value="">-- Pilih Kelas --</option>
            @foreach ($kelas as $k)
              <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
            @endforeach
          </select>
          @error('kelas_id')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- Pilih Siswa --}}
        <div class="mb-3">
          <label class="col-sm-2 col-form-label">Pilih Siswa</label>
          <select name="siswa_id" id="siswaSelect" class="form-control @error('siswa_id') is-invalid @enderror">
            <option value="">-- Pilih Siswa --</option>
          </select>
          @error('siswa_id')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- Tanggal --}}
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Tanggal</label>
          <div class="col-sm-10">
            <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal') }}" required>
            @error('tanggal')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        {{-- Keluhan --}}
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Keluhan</label>
          <div class="col-sm-10">
            <input type="text" name="keluhan" class="form-control @error('keluhan') is-invalid @enderror" placeholder="isi keluhan" value="{{ old('keluhan') }}" required>
            @error('keluhan')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        {{-- Tindakan --}}
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Tindakan</label>
          <div class="col-sm-10">
            <textarea name="tindakan" class="form-control @error('tindakan') is-invalid @enderror" required>{{ old('tindakan') }}</textarea>
            @error('tindakan')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        {{-- Obat --}}
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Obat</label>
          <div class="col-sm-5">
            <select name="obat_id" class="form-select @error('obat_id') is-invalid @enderror">
              <option value="">Pilih obat</option>
              @foreach ($obat as $data)
                <option value="{{ $data->id }}">
                  {{ $data->nama_obat }} 
                  (stok: {{ $data->stok }} {{ $data->unit }})
                </option>
              @endforeach
            </select>
          </div>

          <div class="col-sm-5">
            <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror"
              placeholder="Jumlah sesuai satuan obat">
          </div>
        </div>

        {{-- Petugas --}}
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Petugas</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
          </div>
        </div>

        {{-- Status --}}
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Status</label>
          <div class="col-sm-10">
            <input type="text" name="status" class="form-control @error('status') is-invalid @enderror" placeholder="isi status" value="{{ old('status') }}" required>
            @error('status')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        {{-- Tombol --}}
        <div class="row justify-content-end">
          <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('backend.rekam_medis.index') }}" class="btn btn-secondary">Batal</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  const oldSiswaId = @json(old('siswa_id'));
  const oldKelasId = "{{ old('kelas_id') }}";

  document.getElementById('kelasSelect').addEventListener('change', function () {
    const kelasId = this.value;
    const siswaSelect = document.getElementById('siswaSelect');

    if (!kelasId) {
      siswaSelect.innerHTML = '<option value="">-- Pilih Siswa --</option>';
      return;
    }

    siswaSelect.innerHTML = '<option value="">-- Memuat data siswa... --</option>';

    fetch(`/get-siswa-by-kelas/${kelasId}`)
      .then(response => response.json())
      .then(data => {
        siswaSelect.innerHTML = '<option value="">-- Pilih Siswa --</option>';
        data.forEach(siswa => {
          const selected = siswa.id == oldSiswaId ? 'selected' : '';
          siswaSelect.innerHTML += `<option value="${siswa.id}" ${selected}>${siswa.nama}</option>`;
        });
      })
      .catch(error => {
        console.error('Gagal memuat siswa:', error);
        siswaSelect.innerHTML = '<option value="">-- Gagal memuat siswa --</option>';
      });
  });

  // Trigger otomatis kalau ada old value
  if (oldKelasId) {
    const kelasSelect = document.getElementById('kelasSelect');
    kelasSelect.value = oldKelasId;
    kelasSelect.dispatchEvent(new Event('change'));
  }
</script>
@endpush
