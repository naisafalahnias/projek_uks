@extends('layouts.backend')

@section('content')
<div class="container mt-5">
  <div class="card shadow-sm">
    <div class="card-header">
      <h5>Tambah Kondisi Kesehatan</h5>
    </div>

    <div class="card-body">
      <form action="{{ route('backend.kondisi_kesehatan.store') }}" method="POST">
        @csrf

        <div class="mb-3">
          <label>Siswa</label>
          <select name="siswa_id" class="form-control" required>
            <option value="">-- Pilih Siswa --</option>
            @foreach ($siswas as $siswa)
              <option value="{{ $siswa->id }}">
                {{ $siswa->nama }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label>Nama Kondisi</label>
          <input
            type="text"
            name="nama_kondisi"
            class="form-control"
            placeholder="Contoh: Asma, Alergi, Anemia"
            required
          >
        </div>

        <div class="mb-3">
          <label>Tanggal</label>
          <input
            type="date"
            name="tanggal"
            class="form-control"
            required
          >
        </div>

        <div class="mb-3">
          <label>Keterangan</label>
          <textarea
            name="keterangan"
            class="form-control"
            placeholder="Keterangan tambahan (opsional)"
          ></textarea>
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('backend.kondisi_kesehatan.index') }}" class="btn btn-secondary">
          Kembali
        </a>
      </form>
    </div>
  </div>
</div>
@endsection
