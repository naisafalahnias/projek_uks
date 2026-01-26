@extends('layouts.backend')

@section('content')
<div class="container mt-5" style="max-width: 10000px">
  <div class="card shadow-sm">
    <div class="d-flex justify-content-between align-items-center px-4 pt-3">
      <h5 class="mb-0">Pemeriksaan Gizi</h5>
      @auth
        @if(in_array(Auth::user()->role, ['admin', 'petugas']))
          <a href="{{ route('backend.pemeriksaan_gizi.create') }}" class="btn btn-primary">
            Tambah Data
          </a>
        @endif
      @endauth
    </div>

    <div class="table-responsive text-nowrap p-3">
      <table class="table">
        <thead class="table-light">
          <tr>
            <th>Siswa</th>
            <th>Tanggal</th>
            <th>Berat Badan (kg)</th>
            <th>Tinggi Badan (cm)</th>
            <th>BMI</th>
            <th>Keterangan</th>
            <th>Petugas</th>
            <th>Aksi</th>
          </tr>
        </thead>

        <tbody>
          @forelse ($pemeriksaan_gizi as $item)
            <tr>
              <td>{{ $item->siswa->nama }}</td>
              <td>{{ $item->tanggal }}</td>
              <td>{{ $item->berat_badan }}</td>
              <td>{{ $item->tinggi_badan }}</td>
              <td>{{ $item->bmi }}</td>
              <td>{{ $item->keterangan ?? '-' }}</td>
              <td>{{ $item->petugas->name ?? '-' }}</td>
              <td>
                {{-- <a href="{{ route('pemeriksaan_gizi', $item->id) }}" class="btn btn-sm btn-info">Detail</a> --}}
                <a href="{{ route('backend.pemeriksaan_gizi.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center">Data belum ada</td>
            </tr>
          @endforelse
        </tbody>

      </table>
    </div>
  </div>
</div>
@endsection
