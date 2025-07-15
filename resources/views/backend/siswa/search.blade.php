@forelse ($siswas as $siswa)
              <tr>
                <td>{{ $siswa->nama }}</td>
                <td>{{ $siswa->kelas->nama_kelas }}</td>
                <td>{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                @if(auth()->user()->role === 'admin')
                  <td>{{ $siswa->user->name ?? '-' }}</td> {{-- Nama petugas yg input --}}
                @endif
                <td>
                  <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="{{ route('siswa.edit', $siswa->id) }}">
                        <i class="bx bx-edit-alt me-2"></i> Edit
                      </a>
                      <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus?')">
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
@empty
    <tr>
        <td colspan="5" class="text-center">Tidak ada data ditemukan.</td>
    </tr>
@endforelse