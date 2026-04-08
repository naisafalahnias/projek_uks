@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 m-0">
            <span class="text-muted fw-light">Kantin /</span> Data Makanan & Nutrisi
        </h4>
        @auth
            @if(in_array(Auth::user()->role, ['admin', 'petugas']))
                <a href="{{ route('backend.makanans.create') }}" class="btn btn-primary shadow">
                    <i class="bx bx-plus me-1"></i> Tambah Makanan
                </a>
            @endif
        @endauth
    </div>

    <div class="card shadow-sm">
        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Daftar Menu Kantin Sehat</h5>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nama Makanan</th>
                        <th>Jenis</th>
                        <th>Kandungan Nutrisi</th>
                        <th>Status Kelayakan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($makanans as $item)
                    <tr>
                        {{-- Nama Makanan --}}
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xs me-2">
                                    <span class="avatar-initial rounded bg-label-secondary">
                                        <i class="bx bx-restaurant"></i>
                                    </span>
                                </div>
                                <span class="fw-bold text-dark">{{ $item->nama_makanan }}</span>
                            </div>
                        </td>

                        {{-- Jenis --}}
                        <td>
                            <span class="text-capitalize small">
                                <i class="bx bx-tag-alt me-1 text-primary"></i> {{ $item->jenis }}
                            </span>
                        </td>

                        {{-- Nutrisi (Kalori & Gula digabung agar ringkas) --}}
                        <td>
                            <div class="d-flex flex-column">
                                <small class="text-muted">
                                    <i class="bx bx-bolt-circle text-warning"></i> {{ $item->kalori }} kcal
                                </small>
                                <small class="text-muted">
                                    <i class="bx bx-water text-info"></i> {{ $item->gula }}g Gula
                                </small>
                            </div>
                        </td>

                        {{-- Status --}}
                        <td>
                            @if ($item->status === 'sehat')
                                <span class="badge bg-label-success border-start border-3 border-success rounded-pill">
                                    <i class="bx bx-check-double me-1"></i> Sehat
                                </span>
                            @else
                                <span class="badge bg-label-danger border-start border-3 border-danger rounded-pill">
                                    <i class="bx bx-error me-1"></i> Tidak Sehat
                                </span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="text-center">
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end shadow">
                                    <a class="dropdown-item" href="{{ route('backend.makanans.edit', $item->id) }}">
                                        <i class="bx bx-edit-alt me-1 text-warning"></i> Edit
                                    </a>
                                    <form action="{{ route('backend.makanans.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger btn-delete" 
                                                data-name="{{ $item->nama_makanan }}">
                                            <i class="bx bx-trash me-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bx bx-food-menu mb-2 display-6"></i>
                            <p>Data menu makanan belum tersedia.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection