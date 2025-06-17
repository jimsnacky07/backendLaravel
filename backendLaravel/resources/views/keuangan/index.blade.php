@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Data Keuangan</h3>
        <a href="{{ route('keuangan.create') }}" class="btn btn-primary">Tambah Keuangan</a>
    </div>
    <form method="GET" action="" class="mb-3 d-flex" style="max-width:400px">
        <input type="text" name="q" class="form-control me-2" placeholder="Cari keuangan..." value="{{ request('q') }}">
        <button class="btn btn-secondary" type="submit">Cari</button>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Penghuni</th>
                <th>Tanggal Bayar</th>
                <th>Bayar</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($keuangans as $keuangan)
            <tr>
                <td>{{ $keuangan->id }}</td>
                <td>{{ $keuangan->id_penghuni }}</td>
                <td>{{ $keuangan->tgl_bayar }}</td>
                <td>{{ $keuangan->bayar }}</td>
                <td>{{ $keuangan->keterangan }}</td>
                <td>
                    <a href="{{ route('keuangan.edit', $keuangan->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('keuangan.destroy', $keuangan->id) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $keuangans->links() }}
</div>
@endsection
