@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah User</h1>
    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="foto" class="form-label">Foto</label>
            <input type="file" name="foto" class="form-control" accept="image/jpeg,image/png,image/jpg,image/svg+xml">
        </div>
        <div class="mb-3">
            <label for="penghuni_id" class="form-label">Relasi Penghuni (Opsional)</label>
            <select name="penghuni_id" class="form-control">
                <option value="">-- Pilih Penghuni --</option>
                @foreach($penghuniList as $penghuni)
                <option value="{{ $penghuni->id }}">{{ $penghuni->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" class="form-control">
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('user.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection