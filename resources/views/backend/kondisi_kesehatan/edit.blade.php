@extends('layouts.backend')

@section('content')
<div class="container mt-5">
  <div class="card shadow-sm">
    <div class="card-header">
      <h5>Edit Kondisi Kesehatan</h5>
    </div>

    <div class="card-body">
      <form action="{{ route('backend.kondisi_kesehatan.update', $kondisi->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
          <label>Siswa</label>
          <select name="siswa_id" class="form-control" disabled>
            @foreach ($siswas as $siswa)
              <option value="{{ $siswa->id }}"
                {{ $siswa->id == $kondisi->siswa_id ? 'selected' : '' }}>
                {{ $siswa->nama }}
              </option>
            @endforeach
          </select>
          {{-- biar tetap terkirim walaupun disabled --}}
          <input type="hidden" name="siswa_id" value="{{ $kondisi->siswa_id }}">
        </div>

        <div class="mb-3">
          <label>Nama Kondisi</label>
          <input
            type="text"
            name="nama_kondisi"
            class="form-control"
            value="{{ old('nama_kondisi', $kondisi->nama_kondisi) }}"
            required
          >
        </div>

        <div class="mb-3">
          <label>Tanggal</label>
          <input
            type="date"
            name="tanggal"
            class="form-control"
            value="{{ old('tanggal', $kondisi->tanggal) }}"
            required
          >
        </div>

        <div class="mb-3">
          <label>Keterangan</label>
          <textarea
            name="keterangan"
            class="form-control"
            placeholder="Keterangan tambahan (opsional)"
          >{{ old('keterangan', $kondisi->keterangan) }}</textarea>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('backend.kondisi_kesehatan.index') }}" class="btn btn-secondary">
          Kembali
        </a>
      </form>
    </div>
  </div>
</div>
@endsection
