@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Data Kamar</h3>
        <a href="{{ route('kamar.create') }}" class="btn btn-primary">Tambah Kamar</a>
    </div>
    <form method="GET" action="" class="mb-3 d-flex" style="max-width:400px">
        <input type="text" name="q" class="form-control me-2" placeholder="Cari kamar..." value="{{ request('q') }}">
        <button class="btn btn-secondary" type="submit">Cari</button>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Lantai</th>
                <th>Kapasitas</th>
                <th>Fasilitas</th>
                <th>Tarif</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kamars as $kamar)
            <tr>
                <td>{{ $kamar->id }}</td>
                <td>{{ $kamar->lantai }}</td>
                <td>{{ $kamar->kapasitas }}</td>
                <td>{{ $kamar->fasilitas }}</td>
                <td>{{ $kamar->tarif }}</td>
                <td>
                    <a href="{{ route('kamar.edit', $kamar->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('kamar.destroy', $kamar->id) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $kamars->links() }}
</div>
@endsection
