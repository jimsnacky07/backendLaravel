@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Kamar</h3>
    <form action="{{ route('kamar.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>ID</label>
            <input type="text" name="id" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Lantai</label>
            <input type="number" name="lantai" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Kapasitas</label>
            <input type="text" name="kapasitas" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Fasilitas</label>
            <input type="text" name="fasilitas" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tarif</label>
            <input type="number" name="tarif" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('kamar.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
