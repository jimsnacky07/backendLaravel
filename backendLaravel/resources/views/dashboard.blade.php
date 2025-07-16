@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Dashboard</h2>
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Kamar</h5>
                    <h2>{{ $kamar }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Penghuni</h5>
                    <h2>{{ $penghuni }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white mb-3">
                <div class="card-body">
                    <h5 class="card-title">Kamar Penuh</h5>
                    <h2>{{ $kamar_penuh ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white mb-3">
                <div class="card-body">
                    <h5 class="card-title">Kamar Tersedia</h5>
                    <h2>{{ $kamar_tersedia ?? 0 }}</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
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
</div>
@endsection