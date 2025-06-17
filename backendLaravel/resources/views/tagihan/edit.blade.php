@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Tagihan</h3>
    <form action="{{ route('tagihan.update', $tagihan->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Penghuni</label>
            <select name="id_penghuni" class="form-control" required>
                <option value="">-- Pilih Penghuni --</option>
                @foreach($penghuni as $p)
                    <option value="{{ $p->id }}" @if($tagihan->id_penghuni == $p->id) selected @endif>{{ $p->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Bulan</label>
            <input type="text" name="bulan" class="form-control" value="{{ $tagihan->bulan }}" required>
        </div>
        <div class="mb-3">
            <label>Tahun</label>
            <input type="text" name="tahun" class="form-control" value="{{ $tagihan->tahun }}" required>
        </div>
        <div class="mb-3">
            <label>Tagihan</label>
            <input type="number" name="tagihan" class="form-control" value="{{ $tagihan->tagihan }}" required>
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="Lunas" @if($tagihan->status=='Lunas') selected @endif>Lunas</option>
                <option value="Belum Lunas" @if($tagihan->status=='Belum Lunas') selected @endif>Belum Lunas</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ $tagihan->tanggal }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('tagihan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
