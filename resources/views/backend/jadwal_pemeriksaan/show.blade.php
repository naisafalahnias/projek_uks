@extends('layouts.backend')
@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner mt--8">
                <div class="row justify-content-center mt-5">
                    <div class="col-md-11">
                        <div class="card full-height">
                            <div class="card-header">
                                <div class="card-title"> Show Data jadwal pemeriksaan</div>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Tanggal</th>
                                        <td>{{ $jadwal_pemeriksaan->tanggal }}</td>
                                    </tr>
                                    <tr>
                                        <th>kelas id</th>
                                        <td>{{ $jadwal_pemeriksaan->kelas->nama_kelas }}</td>
                                    </tr>
                                    <tr>
                                        <th>User Id</th>
                                        <td>{{ $jadwal_pemeriksaan->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Keterangan</th>
                                        <td>{{ $jadwal_pemeriksaan->keterangan }}</td>
                                    </tr>

                                </table>
                                <a href="{{ route('backend.jadwal_pemeriksaan.index') }}" class="btn btn-primary">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection