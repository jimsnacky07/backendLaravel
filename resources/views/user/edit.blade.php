@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>
    <form action="{{ route('user.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password (kosongkan jika tidak ingin mengubah)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label for="penghuni_id" class="form-label">Relasi Penghuni (Opsional)</label>
            <select name="penghuni_id" class="form-control">
                <option value="">-- Pilih Penghuni --</option>
                @foreach($penghuniList as $penghuni)
                <option value="{{ $penghuni->id }}" @if($user->penghuni && $user->penghuni->id == $penghuni->id) selected @endif>{{ $penghuni->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="tanggal_bayar" class="form-label">Tanggal Bayar (Opsional)</label>
            <input type="date" name="tanggal_bayar" class="form-control" value="{{ $user->penghuni ? $user->penghuni->tanggal_bayar : '' }}">
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" class="form-control">
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('user.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection