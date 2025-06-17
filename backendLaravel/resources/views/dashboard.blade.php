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

@push('styles')
    <!-- Link asset CSS utama dashboard -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vertical-layout-light/style.css') }}">
@endpush

@push('scripts')
    <!-- Link asset JS utama dashboard -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <script src="{{ asset('assets/js/settings.js') }}"></script>
    <script src="{{ asset('assets/js/todolist.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/Chart.roundedBarCharts.js') }}"></script>
    <script>
        var ctx = document.getElementById('chartTagihan').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($bulan),
                datasets: [{
                    label: 'Jumlah Tagihan',
                    data: @json($total_tagihan),
                    backgroundColor: 'rgba(255, 193, 7, 0.7)'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                }
            }
        });
    </script>
@endpush
