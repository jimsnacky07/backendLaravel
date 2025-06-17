@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Admin</h3>
    <form action="{{ route('admin.update', $admin->id) }}" method="POST">
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
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
