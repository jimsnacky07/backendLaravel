@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Kamar</h2>
    <form action="{{ route('kamar.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="id" class="form-label">ID Kamar</label>
            <input type="text" name="id" class="form-control" required value="{{ old('id') }}">
        </div>
        <div class="mb-3">
            <label for="lantai" class="form-label">Lantai</label>
            <input type="number" name="lantai" class="form-control" required value="{{ old('lantai') }}">
        </div>
        <div class="mb-3">
            <label for="kapasitas" class="form-label">Kapasitas</label>
            <input type="text" name="kapasitas" class="form-control" required value="{{ old('kapasitas') }}">
        </div>
        <div class="mb-3">
            <label for="fasilitas" class="form-label">Fasilitas</label>
            <textarea name="fasilitas" class="form-control" required>{{ old('fasilitas') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="tarif" class="form-label">Tarif</label>
            <input type="number" name="tarif" class="form-control" required value="{{ old('tarif') }}">
        </div>
        <div class="mb-3">
            <label for="max_penghuni" class="form-label">Maksimal Penghuni</label>
            <input type="number" name="max_penghuni" class="form-control" required min="1" max="4" value="{{ old('max_penghuni', 2) }}">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('kamar.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection