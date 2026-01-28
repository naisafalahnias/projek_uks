@extends('layouts.backend')

@section('content')
<div class="container mt-5" style="max-width: 900px">
  <div class="card shadow-sm p-4">
    <h5 class="mb-3">Detail Konsumsi Makanan</h5>

    <table class="table table-borderless">
      <tr>
        <th width="35%">Nama Siswa</th>
        <td>{{ $konsumsi->siswa->nama }}</td>
      </tr>
      <tr>
        <th>Makanan</th>
        <td>{{ $konsumsi->makanan->nama_makanan }}</td>
      </tr>
      <tr>
        <th>Kalori per Porsi</th>
        <td>{{ $konsumsi->makanan->kalori }} kkal</td>
      </tr>
      <tr>
        <th>Jumlah</th>
        <td>{{ $konsumsi->jumlah }}</td>
      </tr>
      <tr>
        <th>Total Kalori</th>
        <td>
          <span class="badge bg-success">
            {{ $konsumsi->total_kalori }} kkal
          </span>
        </td>
      </tr>
      <tr>
        <th>Tanggal</th>
        <td>{{ $konsumsi->tanggal }}</td>
      </tr>
    </table>

    <div class="d-flex justify-content-end mt-3">
      <a href="{{ route('backend.konsumsi_makanan.index') }}"
         class="btn btn-secondary me-2">
        Kembali
      </a>

      @auth
        @if(in_array(Auth::user()->role, ['admin', 'petugas']))
          <a href="{{ route('backend.konsumsi_makanan.edit', $konsumsi->id) }}"
             class="btn btn-warning">
            Edit
          </a>
        @endif
      @endauth
    </div>
  </div>
</div>
@endsection
