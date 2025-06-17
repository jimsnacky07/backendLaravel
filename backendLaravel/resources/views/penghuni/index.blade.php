@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Data Penghuni</h3>
        <a href="{{ route('penghuni.create') }}" class="btn btn-primary">Tambah Penghuni</a>
    </div>
    <form method="GET" action="" class="mb-3 d-flex" style="max-width:400px">
        <input type="text" name="q" class="form-control me-2" placeholder="Cari penghuni..." value="{{ request('q') }}">
        <button class="btn btn-secondary" type="submit">Cari</button>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No HP</th>
                <th>Registrasi</th>
                <th>Kamar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penghunis as $penghuni)
            <tr>
                <td>{{ $penghuni->id }}</td>
                <td>{{ $penghuni->nama }}</td>
                <td>{{ $penghuni->alamat }}</td>
                <td>{{ $penghuni->nohp }}</td>
                <td>{{ $penghuni->registrasi }}</td>
                <td>{{ $penghuni->kamar }}</td>
                <td>
                    <a href="{{ route('penghuni.edit', $penghuni->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('penghuni.destroy', $penghuni->id) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $penghunis->links() }}
</div>
@endsection
