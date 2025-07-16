@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Kamar</h5>
                <p class="card-text display-4">{{ $totalKamar }}</p>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Penghuni</h5>
                <p class="card-text display-4">{{ $totalPenghuni }}</p>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Tagihan</h5>
                <p class="card-text display-4">{{ $totalTagihan }}</p>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card text-white bg-danger mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Admin</h5>
                <p class="card-text display-4">{{ $totalAdmin }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">Penghuni Terbaru</div>
            <div class="card-body">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Kamar</th>
                            <th>Registrasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penghuniTerbaru as $p)
                        <tr>
                            <td>{{ $p->nama }}</td>
                            <td>{{ $p->kamar_id }}</td>
                            <td>{{ $p->registrasi }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-warning text-white">Grafik Tagihan per Bulan</div>
            <div class="card-body">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th>Jumlah Tagihan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grafikTagihan as $g)
                        <tr>
                            <td>{{ DateTime::createFromFormat('!m', $g->bulan)->format('F') }}</td>
                            <td>{{ $g->jumlah }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
