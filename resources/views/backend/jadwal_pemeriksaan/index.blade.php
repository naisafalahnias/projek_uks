@extends('layouts.backend')

@section('content')
<div class="container mt-5" style="max-width: 10000px"> {{-- Biar nggak full width --}}
  <div class="card shadow-sm">
    <div class="d-flex justify-content-between align-items-center px-4 pt-3">
      <h5 class="mb-0">Jadwal Pemeriksaan</h5>
      <a href="{{ route('jadwal_pemeriksaan.create') }}" class="btn btn-primary">Tambah Data</a>
    </div>

    <div class="table-responsive text-nowrap p-3">
      <table class="table">
        <thead class="table-light">
          <tr>
            <th>Tanggal</th>
            <th>Kelas</th>
            <th>Petugas</th>
            <th>Keterangan</th>
            <th>Action</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($jadwal_pemeriksaan as $data)
          <tr>
            <td>{{ $data->tanggal }}</td>
            <td>{{ $data->kelas->nama_kelas }}</td>
            <td>{{ $data->user->name }}</td>
            <td>{{ $data->keterangan }}</td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{ route('jadwal_pemeriksaan.edit', $data->id) }}">
                    <i class="bx bx-edit-alt me-2"></i> Edit
                  </a>
                  <form action="{{ route('jadwal_pemeriksaan.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus?')">
                    @csrf
                    @method('DELETE')
                    <button class="dropdown-item" type="submit">
                      <i class="bx bx-trash me-2"></i> Hapus
                    </button>
                  </form>
                </div>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
