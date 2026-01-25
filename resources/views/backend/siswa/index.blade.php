@extends('layouts.backend')

@section('content')
<div class="container mt-5" style="max-width: 10000px">
  <div class="card shadow-sm">
    <div class="d-flex justify-content-between align-items-center">
      <h5 class="card-header mb-0">Filter Data Siswa per Kelas</h5>
      @auth
          @if(in_array(Auth::user()->role, ['admin', 'petugas']))
            <a href="{{ route('backend.siswa.create') }}" class="btn btn-primary me-4 mt-2">Tambah Siswa</a>
          @endif
      @endauth
    </div>

    <div class="px-3 mt-3">
      <div class="row mb-3">
        <div class="col-md-6">
          <input type="text" id="search-input" class="form-control" placeholder="Cari nama atau kelas siswa...">
        </div>
      </div>
    </div>

    {{-- Tempat isi tabel --}}
    <div class="table-responsive text-nowrap px-3 pb-3">
      <table class="table">
        <thead class="table-light">
          <tr>
            <th>Nama</th>
            <th>Tanggal Lahir</th>
            <th>Kelas</th>
            <th>Jenis Kelamin</th>
            @if(auth()->user()->role === 'admin')
              <th>Input Oleh</th>
            @endif
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="tabel-siswa"> {{-- Ganti dari "tabel-siswa" ke "data-siswa" biar nyambung ke JS --}}
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

                $.ajax({
                    url: "{{ route('backend.siswa.search') }}",
                    type: 'GET',
                    data: {
                        keyword: keyword,
                    },
                    success: function(response) {
                        $('#tabel-siswa').html(response.data);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Gagal memuat data.');
                    }
                });
            }

            $('#search-input').on('keyup', fetchData);
        });
    </script>
@endpush
