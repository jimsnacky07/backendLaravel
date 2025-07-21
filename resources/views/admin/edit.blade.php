@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Admin</h3>
    <form action="{{ route('admin.update', $admin->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>ID</label>
            <input type="text" name="id" class="form-control" value="{{ $admin->id }}" readonly>
        </div>
        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="{{ $admin->username }}" required>
        </div>
        <div class="mb-3">
            <label>Password (isi jika ingin ganti)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label>Admin Level</label>
            <input type="number" name="adminlevel" class="form-control" value="{{ $admin->adminlevel }}" required>
        </div>
        <div class="mb-3">
            <label for="foto" class="form-label">Foto</label>
            <input type="file" name="foto" class="form-control" accept="image/jpeg,image/png,image/jpg,image/svg+xml">
            @if($admin->foto)
            <img src="{{ asset('storage/' . $admin->foto) }}" alt="Foto Admin" width="100" class="mt-2">
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection