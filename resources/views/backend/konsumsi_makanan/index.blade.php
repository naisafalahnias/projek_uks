@extends('layouts.backend')

@section('content')
<div class="container mt-5" style="max-width: 10000px">
  <div class="card shadow-sm">

    <div class="d-flex justify-content-between align-items-center px-4 pt-3">
      <h5 class="mb-0">Konsumsi Makanan Siswa</h5>

      @auth
        @if(in_array(Auth::user()->role, ['admin', 'petugas']))
          <a href="{{ route('backend.konsumsi_makanan.create') }}" class="btn btn-primary">
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
            <th>Makanan</th>
            <th>Tanggal</th>
            <th>Jumlah</th>
            <th>Total Kalori</th>
            <th>Aksi</th>
          </tr>
        </thead>

        <tbody>
          @forelse ($konsumsi as $item)
            <tr>
              <td>{{ $item->siswa->nama }}</td>
              <td>{{ $item->makanan->nama_makanan }}</td>
              <td>{{ $item->tanggal }}</td>
              <td>{{ $item->jumlah }}</td>
              <td>{{ $item->total_kalori }} kkal</td>
              <td>
                <a href="{{ route('backend.konsumsi_makanan.show', $item->id) }}"
                   class="btn btn-sm btn-info">Detail</a>

                @auth
                  @if(in_array(Auth::user()->role, ['admin', 'petugas']))
                    <a href="{{ route('backend.konsumsi_makanan.edit', $item->id) }}"
                       class="btn btn-sm btn-warning">Edit</a>
                  @endif
                @endauth

                <form action="{{ route('backend.konsumsi_makanan.destroy', $item->id) }}"
                        method="POST"
                        class="d-inline"
                        onsubmit="return confirm('Yakin mau hapus data ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">
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
