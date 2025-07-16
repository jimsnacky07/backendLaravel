@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Kamar</h2>
    <form action="{{ route('kamar.update', $kamar->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="id" class="form-label">ID Kamar</label>
            <input type="text" name="id" class="form-control" value="{{ $kamar->id }}" readonly>
        </div>
        <div class="mb-3">
            <label for="lantai" class="form-label">Lantai</label>
            <input type="number" name="lantai" class="form-control" required value="{{ old('lantai', $kamar->lantai) }}">
        </div>
        <div class="mb-3">
            <label for="kapasitas" class="form-label">Kapasitas</label>
            <input type="text" name="kapasitas" class="form-control" required value="{{ old('kapasitas', $kamar->kapasitas) }}">
        </div>
        <div class="mb-3">
            <label for="fasilitas" class="form-label">Fasilitas</label>
            <textarea name="fasilitas" class="form-control" required>{{ old('fasilitas', $kamar->fasilitas) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="tarif" class="form-label">Tarif</label>
            <input type="number" name="tarif" class="form-control" required value="{{ old('tarif', $kamar->tarif) }}">
        </div>
        <div class="mb-3">
            <label for="max_penghuni" class="form-label">Maksimal Penghuni</label>
            <input type="number" name="max_penghuni" class="form-control" required min="1" max="4" value="{{ old('max_penghuni', $kamar->max_penghuni) }}">
            @error('max_penghuni')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('kamar.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection