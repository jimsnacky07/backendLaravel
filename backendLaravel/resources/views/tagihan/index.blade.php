@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Data Tagihan</h3>
        <a href="{{ route('tagihan.create') }}" class="btn btn-primary">Tambah Tagihan</a>
    </div>
    <form method="GET" action="" class="mb-3 d-flex" style="max-width:400px">
        <input type="text" name="q" class="form-control me-2" placeholder="Cari tagihan..." value="{{ request('q') }}">
        <button class="btn btn-secondary" type="submit">Cari</button>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Penghuni</th>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Tagihan</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tagihans as $tagihan)
            <tr>
                <td>{{ $tagihan->id }}</td>
                <td>{{ $tagihan->id_penghuni }}</td>
                <td>{{ $tagihan->bulan }}</td>
                <td>{{ $tagihan->tahun }}</td>
                <td>{{ $tagihan->tagihan }}</td>
                <td>{{ $tagihan->status }}</td>
                <td>{{ $tagihan->tanggal }}</td>
                <td>
                    <a href="{{ route('tagihan.edit', $tagihan->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('tagihan.destroy', $tagihan->id) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $tagihans->links() }}
</div>
@endsection
