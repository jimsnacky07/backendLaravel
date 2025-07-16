@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Keuangan</h3>
    <form action="{{ route('keuangan.create') }}" method="GET">
        <div class="mb-3">
            <label>Penghuni</label>
            <select name="id_penghuni" class="form-control" onchange="this.form.submit()">
                <option value="">-- Pilih Penghuni --</option>
                @foreach($penghuni as $p)
                <option value="{{ $p->id }}" {{ (old('id_penghuni', $selectedPenghuni ?? '') == $p->id) ? 'selected' : '' }}>{{ $p->nama }}</option>
                @endforeach
            </select>
        </div>
    </form>
    <form action="{{ route('keuangan.store') }}" method="POST">
        @csrf
        <input type="hidden" name="id_penghuni" value="{{ old('id_penghuni', $selectedPenghuni ?? '') }}">
        <div class="mb-3">
            <label>Tanggal Bayar</label>
            <input type="date" name="tgl_bayar" class="form-control" id="tgl_bayar" required value="{{ old('tgl_bayar', $defaultTanggalBayar) }}">
        </div>
        <div class="mb-3">
            <label>Bayar</label>
            <input type="number" name="bayar" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Keterangan</label>
            <input type="text" name="keterangan" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('keuangan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection