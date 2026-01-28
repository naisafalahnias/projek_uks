@extends('layouts.backend')

@section('content')
<div class="container mt-5" style="max-width: 10000px">
  <div class="card shadow-sm">
    <div class="d-flex justify-content-between align-items-center px-4 pt-3">
      <h5 class="mb-0">Data Makanan</h5>

      @auth
        @if(in_array(Auth::user()->role, ['admin', 'petugas']))
          <a href="{{ route('backend.makanans.create') }}" class="btn btn-primary">
            Tambah Data
          </a>
        @endif
      @endauth
    </div>

    <div class="table-responsive text-nowrap p-3">
      <table class="table">
        <thead class="table-light">
          <tr>
            <th>Nama Makanan</th>
            <th>Jenis</th>
            <th>Kalori</th>
            <th>Gula</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>

        <tbody>
          @forelse ($makanans as $item)
            <tr>
              <td>{{ $item->nama_makanan }}</td>
              <td class="text-capitalize">{{ $item->jenis }}</td>
              <td>{{ $item->kalori }} kcal</td>
              <td>{{ $item->gula }} g</td>
              <td>
                @if ($item->status === 'sehat')
                  <span class="badge bg-label-success">Sehat</span>
                @else
                  <span class="badge bg-label-danger">Tidak Sehat</span>
                @endif
              </td>
              <td>
                <a href="{{ route('backend.makanans.edit', $item->id) }}"
                   class="btn btn-sm btn-warning">
                  Edit
                </a>

                <form
                  action="{{ route('backend.makanans.destroy', $item->id) }}"
                  method="POST"
                  class="d-inline"
                  onsubmit="return confirm('Yakin hapus data ini?')"
                >
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-danger">
                    Hapus
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center">Data belum ada</td>
            </tr>
          @endforelse
        </tbody>

      </table>
    </div>
  </div>
</div>
@endsection
