@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Keuangan</h3>
    <form action="{{ route('keuangan.update', $keuangan->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>ID</label>
            <input type="text" name="id" class="form-control" value="{{ $keuangan->id }}" readonly>
        </div>
        <div class="mb-3">
            <label>Penghuni</label>
            <select name="id_penghuni" class="form-control" required>
                <option value="">-- Pilih Penghuni --</option>
                @foreach($penghuni as $p)
                    <option value="{{ $p->id }}" @if($keuangan->id_penghuni == $p->id) selected @endif>{{ $p->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Tanggal Bayar</label>
            <input type="date" name="tgl_bayar" class="form-control" value="{{ $keuangan->tgl_bayar }}" required>
        </div>
        <div class="mb-3">
            <label>Bayar</label>
            <input type="number" name="bayar" class="form-control" value="{{ $keuangan->bayar }}" required>
        </div>
        <div class="mb-3">
            <label>Keterangan</label>
            <input type="text" name="keterangan" class="form-control" value="{{ $keuangan->keterangan }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('keuangan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
