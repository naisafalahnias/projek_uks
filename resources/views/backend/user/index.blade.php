@extends('layouts.backend') {{-- atau layouts.app, sesuai layout kamu --}}

@section('content')
<div class="container mt-4">
  <h3 class="mb-3">Daftar User</h3>

  @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <a href="{{ route('backend.user.create') }}" class="btn btn-primary mb-3">+ Tambah User</a>

  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>No</th>
        <th>Nama Petugas</th>
        <th>Email</th>
        <th>No HP</th>
        <th>Role</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($users as $index => $user)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
        <td>
            @if ($user->role === 'admin' && empty($user->no_hp))
                <span class="text-muted fst-italic">Tidak Tersedia</span>
            @else
                {{ $user->no_hp }}
            @endif
        </td>         
        <td>{{ ucfirst($user->role) }}</td>
          <td>
            @if ($user->role !== 'admin')
              <form action="{{ route('backend.user.destroy', $user->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Yakin hapus user ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
              </form>
            @else
              <span class="text-muted fst-italic">Tidak bisa dihapus</span>
            @endif
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
