@extends('layouts.backend') {{-- Ganti sesuai layout kamu --}}

@section('content')
<div class="container mt-4">
  <h4>Tambah User Baru</h4>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('backend.user.store') }}" method="POST">
    @csrf

    <div class="mb-3">
      <label for="name" class="form-label">Nama</label>
      <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" name="email" id="email" class="form-control" required value="{{ old('email') }}">
    </div>

    <div class="mb-3">
      <label for="no_hp" class="form-label">No HP</label>
      <input type="text" name="no_hp" id="no_hp" class="form-control" required value="{{ old('no_hp') }}">
    </div>

    <div class="mb-3">
      <label for="role" class="form-label">Role</label>
      <select name="role" id="role" class="form-select" required>
        <option value="">-- Pilih Role --</option>
        <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" name="password" id="password" class="form-control" required>
    </div>

    <a href="{{ route('backend.user.index') }}" class="btn btn-secondary">Kembali</a>
    <button type="submit" class="btn btn-primary">Simpan</button>
  </form>
</div>
@endsection
