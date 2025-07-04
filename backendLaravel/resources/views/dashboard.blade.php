@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3 grid-margin stretch-card">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h4 class="mb-2">Total Kamar</h4>
                <h2>{{ $kamar }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 grid-margin stretch-card">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h4 class="mb-2">Total Penghuni</h4>
                <h2>{{ $penghuni }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 grid-margin stretch-card">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h4 class="mb-2">Total Tagihan</h4>
                <h2>{{ $tagihan }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 grid-margin stretch-card">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h4 class="mb-2">Total Admin</h4>
                <h2>{{ $admin }}</h2>
            </div>
        </div>
    </div>
</div>
<!-- Tabel Penghuni Terbaru dan Grafik -->
<div class="row mt-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">Penghuni Terbaru</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Kamar</th>
                            <th>Registrasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penghuni_terbaru as $p)
                        <tr>
                            <td>{{ $p->nama }}</td>
                            <td>{{ $p->kamar }}</td>
                            <td>{{ $p->registrasi }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-warning text-white">Grafik Tagihan per Bulan</div>
            <div class="card-body">
                <canvas id="chartTagihan"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection
