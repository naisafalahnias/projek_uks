@extends('layouts.backend')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 m-0"><span class="text-muted fw-light">Data Master /</span> Daftar Siswa</h4>
        @auth
            @if(in_array(Auth::user()->role, ['admin', 'petugas']))
                <a href="{{ route('backend.siswa.create') }}" class="btn btn-primary shadow">
                    <i class="bx bx-user-plus me-1"></i> Tambah Siswa
                </a>
            @endif
        @endauth
    </div>

    <div class="card shadow-sm">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-3">Filter & Pencarian</h5>
            <div class="d-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0">
                <div class="col-md-6">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-search"></i></span>
                        <input 
                            type="text" 
                            id="search-input" 
                            class="form-control" 
                            placeholder="Cari berdasarkan Nama, atau Kelas..."
                        >
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover striped">
                <thead class="table-light">
                    <tr>
                        <th>Identitas Siswa</th>
                        <th>Tanggal Lahir</th>
                        <th>Kelas</th>
                        <th>L/P</th>
                        @if(auth()->user()->role === 'admin')
                            <th>Input Oleh</th>
                        @endif
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tabel-siswa" class="table-border-bottom-0">
                    {{-- Data akan dimuat via AJAX atau Include Pertama --}}
                    @include('backend.siswa.search', ['siswas' => $siswas])
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            function fetchData() {
                let keyword = $('#search-input').val();
                // Tambahkan efek loading sederhana
                $('#tabel-siswa').css('opacity', '0.5');

                $.ajax({
                    url: "{{ route('backend.siswa.search') }}",
                    type: 'GET',
                    data: { keyword: keyword },
                    success: function(response) {
                        $('#tabel-siswa').html(response.data).css('opacity', '1');
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        $('#tabel-siswa').css('opacity', '1');
                    }
                });
            }
            $('#search-input').on('keyup', fetchData);
        });
    </script>
@endpush