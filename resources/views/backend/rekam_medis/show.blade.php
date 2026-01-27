@extends('layouts.backend')

@section('content')
<div class="col-xxl">
  <div class="card mb-4">
    <div class="card-header">
      <h5 class="mb-0">Detail Rekam Medis</h5>
    </div>

    <div class="card-body">

      <div class="mb-3">
        <label class="form-label">Siswa</label>
        <input type="text" class="form-control" value="{{ $rekam_medis->siswa->nama }}" readonly>
      </div>

      <div class="mb-3">
        <label class="form-label">Tanggal</label>
        <input type="text" class="form-control" value="{{ $rekam_medis->tanggal }}" readonly>
      </div>

      <div class="mb-3">
        <label class="form-label">Keluhan</label>
        <textarea class="form-control" readonly>{{ $rekam_medis->keluhan }}</textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Tindakan</label>
        <textarea class="form-control" readonly>{{ $rekam_medis->tindakan }}</textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Obat yang diberikan</label>
        <ul>
          @foreach ($rekam_medis->rekam_medis_obat as $item)
            <li>
              {{ $item->obat->nama_obat }}
              ({{ $item->jumlah }} {{ $item->obat->unit }})
            </li>
          @endforeach
        </ul>
      </div>

      <div class="mb-3">
        <label class="form-label">Status</label>
        <input type="text" class="form-control" value="{{ $rekam_medis->status }}" readonly>
      </div>

      <a href="{{ route('backend.rekam_medis.index') }}" class="btn btn-secondary">Kembali</a>

    </div>
  </div>
</div>
@endsection
