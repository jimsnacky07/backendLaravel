@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Keuangan</h3>
    <form action="{{ route('keuangan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Penghuni</label>
            <select name="id_penghuni" class="form-control" required>
                <option value="">-- Pilih Penghuni --</option>
                @foreach($penghuniList as $p)
                <option value="{{ $p->id }}" {{ (old('id_penghuni') == $p->id) ? 'selected' : '' }}>{{ $p->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Tanggal Bayar</label>
            <input type="date" name="tgl_bayar" class="form-control" required value="{{ old('tgl_bayar', date('Y-m-d')) }}">
        </div>
        <div class="mb-3">
            <label>Bayar</label>
            <input type="number" name="bayar" class="form-control" required value="{{ old('bayar') }}">
        </div>
        <div class="mb-3">
            <label>Keterangan</label>
            <input type="text" name="keterangan" class="form-control" value="{{ old('keterangan') }}">
        </div>
        <div class="mb-3">
            <label>Foto Bukti Pembayaran</label>
            <input type="file" name="foto" class="form-control" accept="image/*">
            <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('keuangan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection