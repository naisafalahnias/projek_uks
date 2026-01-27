@extends('layouts.backend')

@section('content')
<div class="container mt-5" style="max-width: 10000px">
  <div class="card shadow-sm">
    <div class="d-flex justify-content-between align-items-center px-4 pt-3">
      <h5 class="mb-0">Kondisi Kesehatan Siswa</h5>

      @auth
        @if(in_array(Auth::user()->role, ['admin', 'petugas']))
          <a href="{{ route('backend.kondisi_kesehatan.create') }}" class="btn btn-primary">
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
            <th>Nama Kondisi</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th>Aksi</th>
          </tr>
        </thead>

        <tbody>
          @forelse ($kondisi_kesehatans as $item)
            <tr>
              <td>{{ $item->siswa->nama }}</td>
              <td>{{ $item->nama_kondisi }}</td>
              <td>{{ $item->tanggal }}</td>
              <td>{{ $item->keterangan ?? '-' }}</td>
              <td>
                <a href="{{ route('backend.kondisi_kesehatan.edit', $item->id) }}"
                   class="btn btn-sm btn-warning">
                  Edit
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center">Data belum ada</td>
            </tr>
          @endforelse
        </tbody>

      </table>
    </div>
  </div>
</div>
@endsection
