@forelse ($siswas as $siswa)
              <tr>
                <td>{{ $siswa->nama }}</td>
                <td>{{ $siswa->tanggal_lahir }}</td>
                <td>{{ $siswa->kelas->nama_kelas }}</td>
                <td>{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                @if(auth()->user()->role === 'admin')
                  <td>{{ $siswa->user->name ?? '-' }}</td> 
                @endif
                <td>
                  <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="{{ route('backend.siswa.edit', $siswa->id) }}">
                        <i class="bx bx-edit-alt me-2"></i> Edit
                      </a>
                      <form action="{{ route('backend.siswa.destroy', $siswa->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="dropdown-item btn-delete" data-name="{{ $siswa->nama }}">
                            <i class="bx bx-trash me-2"></i> Hapus
                        </button>
                    </form>
                    </div>
                  </div>
                </td>
              </tr>
@empty
    <tr>
        <td colspan="{{ auth()->user()->role === 'admin' ? 6 : 5 }}" class="text-center text-muted">
            Tidak ada data ditemukan.
        </td>
    </tr>
@endforelse