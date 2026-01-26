  @extends('layouts.backend')

  @section('content')
  <div class="container mt-5" style="max-width: 10000px">
    <div class="card shadow-sm">
      <div class="d-flex justify-content-between align-items-center px-4 pt-3">
        <h5 class="mb-0">Rekam Medis</h5>
        @auth
          @if(in_array(Auth::user()->role, ['admin', 'petugas']))
            <a href="{{ route('backend.rekam_medis.create') }}" class="btn btn-primary">
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
              <th>Keluhan</th>
              <th>Tindakan</th>
              <th>Obat</th>
              <th>Petugas</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($rekam_medis as $data)
            <tr>
              <td>{{ $data->siswa->nama ?? '-' }}</td>
              <td>{{ $data->tanggal }}</td>
              <td>{{ $data->keluhan }}</td>
              <td>{{ $data->tindakan }}</td>

              {{-- OBAT --}}
              <td>
                @if ($data->rekam_medis_obat->count())
                  <ul class="mb-0 ps-3">
                    @foreach ($data->rekam_medis_obat as $rmObat)
                      <li>
                        {{ $rmObat->obat->nama_obat }}
                        ({{ $rmObat->jumlah }} {{ $rmObat->obat->unit }})
                      </li>
                    @endforeach
                  </ul>
                @else
                  -
                @endif
              </td>

              <td>{{ $data->user->name }}</td>

              <td>
                @if ($data->status === 'pulang')
                  <span class="badge bg-success">Pulang</span>
                @elseif ($data->status === 'uks')
                  <span class="badge bg-info text-dark">UKS</span>
                @elseif ($data->status === 'kelas')
                  <span class="badge bg-primary">Kembali ke Kelas</span>
                @else
                  <span class="badge bg-secondary">{{ ucfirst($data->status) }}</span>
                @endif
              </td>

              <td>
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('backend.rekam_medis.edit', $data->id) }}">
                      <i class="bx bx-edit-alt me-2"></i> Edit
                    </a>
                    <form action="{{ route('backend.rekam_medis.destroy', $data->id) }}" method="POST"
                          onsubmit="return confirm('Yakin mau hapus?')">
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
