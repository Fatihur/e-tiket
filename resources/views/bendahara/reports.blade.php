@extends('layouts.app')

@section('title', 'Laporan Keuangan')

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Laporan Keuangan</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-muted" href="{{ route('bendahara.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Laporan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Harian</h6>
                    <h3 class="mb-0">{{ 'Rp ' . number_format($daily, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Mingguan</h6>
                    <h3 class="mb-0">{{ 'Rp ' . number_format($weekly, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Bulanan</h6>
                    <h3 class="mb-0">{{ 'Rp ' . number_format($monthly, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Tahunan</h6>
                    <h3 class="mb-0">{{ 'Rp ' . number_format($yearly, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Breakdown Chart -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Pendapatan Bulanan {{ now()->year }}</h5>
        </div>
        <div class="card-body">
            <canvas id="monthlyRevenueChart" height="100"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('monthlyRevenueChart');
    
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: @json($monthlyBreakdown),
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>
@endpush
@endsection

