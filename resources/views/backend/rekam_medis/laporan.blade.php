@extends('layouts.backend')

@section('content')
    <div class="container-fluid py-4">
        <h4>Laporan Kunjungan</h4>

        <form method="GET" action="{{ route('backend.rekam_medis.laporan') }}" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <label>Dari Tanggal:</label>
                    <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                </div>
                <div class="col-md-4">
                    <label>Sampai Tanggal:</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Tanggal</th>
                            <th>Keluhan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekam_medis as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->siswa->nama }}</td>
                                <td>{{ $item->siswa->kelas->nama_kelas ?? '-' }}</td>
                                <td>{{ $item->tanggal }}</td>
                                <td>{{ $item->keluhan }}</td>
                                <td>
                                    @if ($item->status === 'pulang')
                                        <span class="badge bg-success">Pulang</span>
                                    @elseif ($item->status === 'uks')
                                        <span class="badge bg-info text-dark">UKS</span>
                                    @elseif ($item->status === 'kelas')
                                        <span class="badge bg-primary">Kembali ke Kelas</span>
                                    @elseif (!empty($item->status))
                                        <span class="badge bg-secondary">{{ ucfirst($item->status) }}</span>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data untuk tanggal tersebut.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <br>
                <a href="{{ route('rekam_medis.export.excel', ['tanggal_awal' => request('tanggal_awal'), 'tanggal_akhir' => request('tanggal_akhir')]) }}"
                    class="btn btn-success mb-3 ms-2" target="_blank">
                    Export Excel
                </a>
                <a href="{{ route('rekam_medis.export.pdf', ['tanggal_awal' => request('tanggal_awal'), 'tanggal_akhir' => request('tanggal_akhir')]) }}"
                    class="btn btn-warning mb-3" target="_blank">
                    Export PDF
                </a>
                

            </div>
        </div>
    </div>
@endsection