@extends('layouts.backend')

@section('content')
<div class="container mt-5" style="max-width: 10000px"> {{-- Biar tampilannya lebih ramping --}}
  <div class="card shadow-sm">
  <div class="d-flex justify-content-between align-items-center">
    <h5 class="card-header mb-0">Data Kelas</h5>
    <a href="{{ route('backend.kelas.create') }}" class="btn btn-primary me-4 mt-2">Tambah data</a>
  </div>

  <div class="table-responsive text-nowrap p-3">
    <table class="table ">
      <thead class="table-light">
        <tr>
          <th>Nama Kelas</th>
          <th>Action</th>
        </tr>
      </thead>

      <tbody class="table-border-bottom-0">
        @foreach ($kelas as $data)
        <tr>
          <td>{{ $data->nama_kelas }}</td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <div class="dropdown-menu">
                <form action="{{ route('backend.kelas.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus?')">
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
