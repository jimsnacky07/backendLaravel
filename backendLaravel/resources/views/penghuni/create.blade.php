@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Penghuni</h3>
    <form action="{{ route('penghuni.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>ID</label>
            <input type="text" name="id" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Alamat</label>
            <input type="text" name="alamat" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="nohp" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Registrasi</label>
            <input type="date" name="registrasi" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Kamar</label>
            <input type="text" name="kamar" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('penghuni.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
