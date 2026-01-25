@extends('layouts.backend')

@section('content')
<div class="container mt-5" style="max-width: 10000px"> {{-- Biar nggak full width --}}
  <div class="card shadow-sm">
    <div class="d-flex justify-content-between align-items-center px-4 pt-3">
      <h5 class="mb-0">Data Obat</h5>
      @auth
          @if(in_array(Auth::user()->role, ['admin', 'petugas']))
            <a href="{{ route('backend.obat.create') }}" class="btn btn-primary">Tambah Data Obat</a>
          @endif
      @endauth
    </div>

    <div class="table-responsive text-nowrap p-3">
      <table class="table">
        <thead class="table-light">
          <tr>
            <th>Nama Obat</th>
            <th>Kategori</th>
            <th>Stok</th>
            <th>Tgl Kadaluarsa</th>
            <th>Status</th>
            <th>Unit</th>
            <th>Deskripsi</th>
            <th>Action</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($obat as $data)
          <tr>
            <td>{{ $data->nama_obat }}</td>
            <td>{{ $data->kategori }}</td>
            <td>{{ $data->stok }}</td>
            <td>{{ $data->tgl_kadaluarsa }}</td>
            {{-- Kolom status kadaluarsa --}}
            <td>
              @if ($data->status_kadaluarsa === 'expired')
                <span class="badge bg-danger">Kadaluarsa</span>
              @elseif ($data->status_kadaluarsa === 'near_expired')
                <span class="badge bg-warning text-dark">Hampir Kadaluarsa</span>
              @else
                <span class="badge bg-success">Aman</span>
              @endif
            </td>
            <td>{{ $data->unit }}</td>
            <td>{{ $data->deskripsi }}</td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{ route('backend.obat.edit', $data->id) }}">
                    <i class="bx bx-edit-alt me-2"></i> Edit
                  </a>
                  <form action="{{ route('backend.obat.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus?')">
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
