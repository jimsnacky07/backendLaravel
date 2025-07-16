{{-- filepath: c:\xampp\htdocs\tugasakhirmobile\backendLaravel\resources\views\penghuni\show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Detail Penghuni</h3>
    <table class="table">
        <tr><th>ID</th><td>{{ $penghuni->id }}</td></tr>
        <tr><th>Nama</th><td>{{ $penghuni->nama }}</td></tr>
        <tr><th>Alamat</th><td>{{ $penghuni->alamat }}</td></tr>
        <tr><th>No HP</th><td>{{ $penghuni->nohp }}</td></tr>
        <tr><th>Registrasi</th><td>{{ $penghuni->registrasi }}</td></tr>
        <tr><th>Kamar</th><td>{{ $penghuni->kamar }}</td></tr>
    </table>
    <a href="{{ route('penghuni.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection