@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Penghuni</h2>
    <form action="{{ route('penghuni.update', $penghuni->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="id" class="form-label">ID Penghuni</label>
            <input type="text" name="id" class="form-control" value="{{ $penghuni->id }}" readonly>
        </div>
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" required value="{{ old('nama', $penghuni->nama) }}">
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" name="alamat" class="form-control" required value="{{ old('alamat', $penghuni->alamat) }}">
        </div>
        <div class="mb-3">
            <label for="nohp" class="form-label">No HP</label>
            <input type="text" name="nohp" class="form-control" required value="{{ old('nohp', $penghuni->nohp) }}">
        </div>
        <div class="mb-3">
            <label for="registrasi" class="form-label">Tanggal Registrasi</label>
            <input type="date" name="registrasi" class="form-control" required value="{{ old('registrasi', $penghuni->registrasi) }}">
        </div>
        <div class="mb-3">
            <label for="tanggal_bayar" class="form-label">Tanggal Pembayaran</label>
            <input type="date" name="tanggal_bayar" class="form-control" required value="{{ old('tanggal_bayar', $penghuni->tanggal_bayar) }}">
        </div>
        <div class="mb-3">
            <label for="kamar" class="form-label">Kamar</label>
            <select name="kamar" class="form-control" required>
                <option value="">-- Pilih Kamar --</option>
                @foreach($kamars as $kamar)
                <option value="{{ $kamar->id }}" {{ old('kamar', $penghuni->kamar) == $kamar->id ? 'selected' : '' }} {{ $kamar->canAcceptNewOccupant() || $penghuni->kamar == $kamar->id ? '' : 'disabled' }}>
                    {{ $kamar->id }} ({{ $kamar->getOccupancyStatus() }})
                </option>
                @endforeach
            </select>
            @error('kamar')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="foto" class="form-label">Foto</label>
            <input type="file" name="foto" class="form-control" accept="image/jpeg,image/png,image/jpg,image/svg+xml">
            @if($penghuni->foto)
            <img src="{{ asset('storage/' . $penghuni->foto) }}" alt="Foto Penghuni" width="100" class="mt-2">
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('penghuni.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection