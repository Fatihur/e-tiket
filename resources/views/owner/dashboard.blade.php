@extends('layouts.app')

@section('title', 'Dashboard Owner')

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Dashboard Owner</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-truncate font-size-14 mb-2">Total Pendapatan</p>
                            <h4 class="mb-2">{{ 'Rp ' . number_format($stats['total_revenue'], 0, ',', '.') }}</h4>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-success rounded-3">
                                <i class="ti ti-coin font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-truncate font-size-14 mb-2">Total Pengunjung</p>
                            <h4 class="mb-2">{{ number_format($stats['total_visitors'], 0, ',', '.') }}</h4>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-info rounded-3">
                                <i class="ti ti-users font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-truncate font-size-14 mb-2">Paket Aktif</p>
                            <h4 class="mb-2">{{ $stats['total_packages'] }}</h4>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-primary rounded-3">
                                <i class="ti ti-package font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-truncate font-size-14 mb-2">Booking Pending</p>
                            <h4 class="mb-2">{{ $stats['pending_bookings'] }}</h4>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-warning rounded-3">
                                <i class="ti ti-clock font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Grafik Pendapatan (12 Bulan Terakhir)</h5>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Grafik Pengunjung (12 Bulan Terakhir)</h5>
                </div>
                <div class="card-body">
                    <canvas id="visitorChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Aksi Cepat</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <a href="{{ route('owner.reports') }}" class="btn btn-outline-primary w-100 mb-2">
                                <i class="ti ti-file-description"></i> Lihat Laporan Lengkap
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('owner.package.analysis') }}" class="btn btn-outline-info w-100 mb-2">
                                <i class="ti ti-chart-bar"></i> Analisis Paket Wisata
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('admin.bookings') }}" class="btn btn-outline-success w-100 mb-2">
                                <i class="ti ti-list"></i> Lihat Semua Booking
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart');
    if (revenueCtx) {
        const revenueData = @json($revenueChart);
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: revenueData.map(item => item.month),
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: revenueData.map(item => item.revenue),
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    }

    // Visitor Chart
    const visitorCtx = document.getElementById('visitorChart');
    if (visitorCtx) {
        const visitorData = @json($visitorChart);
        new Chart(visitorCtx, {
            type: 'bar',
            data: {
                labels: visitorData.map(item => item.month),
                datasets: [{
                    label: 'Pengunjung',
                    data: visitorData.map(item => item.visitors),
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
});
</script>
@endpush
@endsection

