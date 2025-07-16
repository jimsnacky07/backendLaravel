@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail User</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $user->name }}</h5>
            <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
            <p class="card-text"><strong>Penghuni:</strong> {{ $user->penghuni ? $user->penghuni->nama : '-' }}</p>
            <p class="card-text"><strong>Tanggal Bayar:</strong> {{ $user->penghuni ? $user->penghuni->tanggal_bayar : '-' }}</p>
            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('user.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection