@extends('layouts.backend')

@section('content')
    <div class="container mt-5">
        <h3>Laporan Jadwal Pemeriksaan</h3>
        <form method="GET" action="{{ route('jadwal_pemeriksaan.laporan') }}">
            <div class="row">
                <div class="col">
                    <label>Dari Tanggal</label>
                    <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                </div>
                <div class="col">
                    <label>Sampai Tanggal</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                </div>
                <div class="col">
                    <label>&nbsp;</label><br>
                    <button class="btn btn-primary" type="submit">Tampilkan</button>
                </div>
            </div>
        </form>

        <hr>

        @if ($jadwal)
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Kelas</th>
                                <th>Petugas</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jadwal as $item)
                                <tr>
                                    <td>{{ $item->tanggal }}</td>
                                    <td>{{ $item->kelas->nama_kelas }}</td>
                                    <td>{{ $item->user->name ?? '-' }}</td>
                                    <td>{{ $item->keterangan }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @if ($jadwal)
                        <form action="{{ route('jadwal_pemeriksaan.export.pdf') }}" method="GET" target="_blank"
                            class="mt-3">
                            <input type="hidden" name="tanggal_awal" value="{{ $awal }}">
                            <input type="hidden" name="tanggal_akhir" value="{{ $akhir }}">
                            <button class="btn btn-danger">Export PDF</button>
                        </form>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection