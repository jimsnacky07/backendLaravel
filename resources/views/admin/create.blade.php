@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Admin</h3>
    <form action="{{ route('admin.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>ID</label>
            <input type="text" name="id" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Admin Level</label>
            <input type="number" name="adminlevel" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
