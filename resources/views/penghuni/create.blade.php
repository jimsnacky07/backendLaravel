@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Penghuni</h2>
    <form action="{{ route('penghuni.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="id" class="form-label">ID Penghuni</label>
            <input type="text" name="id" class="form-control" required value="{{ old('id') }}">
        </div>
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" required value="{{ old('nama') }}">
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" name="alamat" class="form-control" required value="{{ old('alamat') }}">
        </div>
        <div class="mb-3">
            <label for="nohp" class="form-label">No HP</label>
            <input type="text" name="nohp" class="form-control" required value="{{ old('nohp') }}">
        </div>
        <div class="mb-3">
            <label for="registrasi" class="form-label">Tanggal Registrasi</label>
            <input type="date" name="registrasi" class="form-control" required value="{{ old('registrasi') }}">
        </div>
        <div class="mb-3">
            <label for="tanggal_bayar" class="form-label">Tanggal Pembayaran</label>
            <input type="date" name="tanggal_bayar" class="form-control" required value="{{ old('tanggal_bayar') }}">
        </div>
        <div class="mb-3">
            <label for="foto" class="form-label">Foto</label>
            <input type="file" name="foto" class="form-control" accept="image/jpeg,image/png,image/jpg,image/svg+xml">
        </div>
        <div class="mb-3">
            <label for="kamar" class="form-label">Kamar</label>
            <select name="kamar" class="form-control" required>
                <option value="">-- Pilih Kamar --</option>
                @foreach($kamars as $kamar)
                <option value="{{ $kamar->id }}" {{ old('kamar') == $kamar->id ? 'selected' : '' }} {{ $kamar->canAcceptNewOccupant() ? '' : 'disabled' }}>
                    {{ $kamar->id }} ({{ $kamar->getOccupancyStatus() }})
                </option>
                @endforeach
            </select>
            @error('kamar')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('penghuni.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection