@extends('layouts.backend')

@section('content')
<div class="container mt-5" style="max-width: 10000px"> {{-- atau 800px --}}
<div class="card shadow-sm">
  <div class="d-flex justify-content-between align-items-center">
    <h5 class="card-header mb-0">Data Petugas</h5>
    <a href="{{ route('petugas.create') }}" class="btn btn-primary me-4 mt-2">Tambah Petugas</a>
  </div>
  <div class="table-responsive text-nowrap p-3">
      <table class="table">
        <thead class="table-light">
        <tr>
          <th>Nama</th>
          <th>Role</th>
          <th>No HP</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach ($petugas as $data)
        <tr>
          <td><strong>{{ $data->nama }}</strong></td>
          <td>{{ $data->user->role }}</td>
          <td>{{ $data->no_hp }}</td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('petugas.edit', $data->id) }}">
                  <i class="bx bx-edit-alt me-2"></i> Edit
                </a>
                <form action="{{ route('petugas.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus?')">
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
