    @extends('layouts.backend')

@section('content')
<div class="container mt-5" style="max-width: 10000px">
  <div class="card shadow-sm">

    <div class="d-flex justify-content-between align-items-center px-4 pt-3">
      <h5 class="mb-0">Kebutuhan Kalori Siswa</h5>

      @auth
        @if(in_array(Auth::user()->role, ['admin', 'petugas']))
          <a href="{{ route('backend.kebutuhan_kalori.create') }}" class="btn btn-primary">
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
            <th>Kebutuhan Harian</th>
            <th>Tingkat Aktivitas</th>
            <th>Dibuat</th>
            <th>Aksi</th>
          </tr>
        </thead>

        <tbody>
          @forelse ($kebutuhanKalori as $item)
            <tr>
              <td>{{ $item->siswa->nama }}</td>
              <td>{{ $item->kebutuhan_harian }} kkal</td>
              <td>
                <span class="badge bg-info text-capitalize">
                  {{ $item->tingkat_aktivitas }}
                </span>
              </td>
              <td>{{ $item->created_at->format('d-m-Y') }}</td>
              <td>

                @auth
                  @if(in_array(Auth::user()->role, ['admin', 'petugas']))
                    <a href="{{ route('backend.kebutuhan_kalori.edit', $item->id) }}"
                       class="btn btn-sm btn-warning">
                      Edit
                    </a>

                    <form action="{{ route('backend.kebutuhan_kalori.destroy', $item->id) }}"
                          method="POST"
                          class="d-inline"
                          onsubmit="return confirm('Yakin hapus data ini?')">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-sm btn-danger">
                        Hapus
                      </button>
                    </form>
                  @endif
                @endauth
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
