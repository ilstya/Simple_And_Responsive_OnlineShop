@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Dashboard Admin</h1>

    <div class="row">
        {{-- Card Total Pesanan Bulan Ini --}}
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Pesanan Bulan Ini</h5>
                    <h2>{{ $totalThisMonth ?? 0 }}</h2>
                </div>
            </div>
        </div>

        {{-- Card Total Pesanan Keseluruhan --}}
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Semua Pesanan</h5>
                    <h2>{{ $totalAllTime ?? 0 }}</h2>
                </div>
            </div>
        </div>

        {{-- Card Total Pelanggan --}}
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Pelanggan</h5>
                    <h2>{{ $totalCustomers ?? 0 }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Grafik Pesanan per Bulan --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title">Grafik Pesanan Bulanan</h5>
            <canvas id="ordersChart"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('ordersChart').getContext('2d');
const ordersChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($chartLabels ?? []) !!},
        datasets: [{
            label: 'Jumlah Pesanan',
            data: {!! json_encode($chartData ?? []) !!},
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 2,
            fill: true,
            tension: 0.3
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
@endpush
