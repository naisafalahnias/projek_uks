@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Manajemen Akademik /</span> Daftar Kelas
    </h4>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center border-bottom mb-3">
            <h5 class="m-0 text-primary fw-bold">
                <i class="bx bx-list-ul me-2"></i>Data Seluruh Kelas
            </h5>
            <a href="{{ route('backend.kelas.create') }}" class="btn btn-primary shadow">
                <i class="bx bx-plus-circle me-1"></i> Tambah Kelas
            </a>
        </div>

        <div class="table-responsive text-nowrap p-2">
            <table class="table table-striped table-hover">
                <thead>
                    <tr class="text-nowrap bg-label-secondary">
                        <th style="width: 10%">No</th>
                        <th>Identitas Kelas</th>
                        <th>Status</th>
                        <th style="width: 15%">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($kelas as $key => $data)
                    <tr>
                        <td><strong>{{ $key + 1 }}</strong></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded-circle bg-label-info">
                                        <i class="bx bx-home-alt"></i>
                                    </span>
                                </div>
                                <div>
                                    <span class="fw-bold d-block">{{ $data->nama_kelas }}</span>
                                    <small class="text-muted">ID: #CLS-0{{ $data->id }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-label-success">Aktif</span>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('backend.kelas.edit', $data->id) }}">
                                        <i class="bx bx-edit-alt me-1 text-warning"></i> Edit
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    
                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('backend.kelas.destroy', $data->id) }}" method="POST" id="form-delete-{{ $data->id }}" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <button type="button" class="dropdown-item text-danger" onclick="confirmDelete('{{ $data->id }}')">
                                        <i class="bx bx-trash me-1"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="text-muted">
                                <i class="bx bx-info-circle mb-2" style="font-size: 3rem"></i>
                                <p>Belum ada data kelas yang terdaftar.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if(method_exists($kelas, 'links'))
        <div class="card-footer d-flex justify-content-end">
            {{ $kelas->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

{{-- TARUH SCRIPT DI LUAR SECTION CONTENT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin mau hapus?',
            text: "Data kelas ini nggak bisa dikembalikan lagi lho!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#696cff',
            cancelButtonColor: '#ff3e1d',
            confirmButtonText: 'Ya, Hapus saja!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-delete-' + id).submit();
            }
        })
    }

    // Notifikasi sukses (jika ada session success)
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Mantap!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 1500
        });
    @endif
</script>