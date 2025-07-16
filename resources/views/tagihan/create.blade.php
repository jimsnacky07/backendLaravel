@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Tagihan</h3>
    <form action="{{ route('tagihan.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Penghuni</label>
            <select name="id_penghuni" class="form-control" required>
                <option value="">-- Pilih Penghuni --</option>
                @foreach($penghuni as $p)
                    <option value="{{ $p->id }}">{{ $p->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Bulan</label>
            <input type="text" name="bulan" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tahun</label>
            <input type="text" name="tahun" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tagihan</label>
            <input type="number" name="tagihan" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="Lunas">Lunas</option>
                <option value="Belum Lunas">Belum Lunas</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('tagihan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
