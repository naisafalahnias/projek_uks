@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Laporan & Log /</span> Log Aktivitas</h4>
        
        @if(auth()->user()->role === 'admin' && $logs->count() > 0)
        <form action="{{ route('backend.log.deleteAll') }}" method="POST" class="form-delete-all">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-danger btn-delete-all">
                <i class="bx bx-trash me-1"></i> Bersihkan Histori
            </button>
        </form>
        @endif
    </div>

    <div class="card">
        <h5 class="card-header">Riwayat Sistem</h5>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Petugas</th>
                        <th>Aksi</th>
                        <th>Tabel</th>
                        <th class="text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($logs as $log)
                    <tr>
                        <td>
                            <span class="badge bg-label-secondary">{{ $log->created_at->format('d M Y') }}</span>
                            <small class="text-muted d-block">{{ $log->created_at->format('H:i') }}</small>
                        </td>
                        <td>
                            <div class="d-flex justify-content-start align-items-center">
                                <div class="d-flex flex-column">
                                    <span class="fw-semibold">{{ $log->user->name ?? '-' }}</span>
                                    <small class="text-muted">{{ $log->user->role ?? '' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if(str_contains($log->aksi, 'Menambah'))
                                <i class="bx bx-plus-circle text-success me-1"></i>
                            @elseif(str_contains($log->aksi, 'Mengubah') || str_contains($log->aksi, 'Mengedit'))
                                <i class="bx bx-edit-alt text-warning me-1"></i>
                            @elseif(str_contains($log->aksi, 'Menghapus'))
                                <i class="bx bx-trash text-danger me-1"></i>
                            @else
                                <i class="bx bx-info-circle text-info me-1"></i>
                            @endif
                            {{ $log->aksi }}
                        </td>
                        <td><span class="badge bg-label-primary">{{ $log->tabel ?? '-' }}</span></td>
                        <td class="text-center">
                            <form action="{{ route('backend.log.destroy', $log->id) }}" method="POST" class="d-inline form-delete">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-icon btn-outline-danger btn-delete">
                                    <i class="bx bx-x"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="text-light fw-semibold">Belum ada aktivitas tercatat.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">Menampilkan {{ $logs->firstItem() ?? 0 }} sampai {{ $logs->lastItem() ?? 0 }} dari {{ $logs->total() }} data</small>
                <div>
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Alert untuk Hapus Satuan
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('.form-delete');
            Swal.fire({
                title: 'Hapus log ini?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff3e1d',
                cancelButtonColor: '#8592a3',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Alert untuk Hapus Semua
    const deleteAllBtn = document.querySelector('.btn-delete-all');
    if (deleteAllBtn) {
        deleteAllBtn.addEventListener('click', function () {
            const form = this.closest('.form-delete-all');
            Swal.fire({
                title: 'Bersihkan SEMUA Log?',
                text: "Seluruh riwayat aktivitas sistem akan dikosongkan permanen!",
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#ff3e1d',
                cancelButtonColor: '#8592a3',
                confirmButtonText: 'Ya, Bersihkan Semua!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    }
});
</script>