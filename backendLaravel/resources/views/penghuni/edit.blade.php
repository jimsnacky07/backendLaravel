@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Penghuni</h3>
    <form action="{{ route('penghuni.update', $penghuni->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>ID</label>
            <input type="text" name="id" class="form-control" value="{{ $penghuni->id }}" readonly>
        </div>
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ $penghuni->nama }}" required>
        </div>
        <div class="mb-3">
            <label>Alamat</label>
            <input type="text" name="alamat" class="form-control" value="{{ $penghuni->alamat }}" required>
        </div>
        <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="nohp" class="form-control" value="{{ $penghuni->nohp }}" required>
        </div>
        <div class="mb-3">
            <label>Registrasi</label>
            <input type="date" name="registrasi" class="form-control" value="{{ $penghuni->registrasi }}" required>
        </div>
        <div class="mb-3">
            <label>Kamar</label>
            <input type="text" name="kamar" class="form-control" value="{{ $penghuni->kamar }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('penghuni.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
