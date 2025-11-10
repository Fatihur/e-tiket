@extends('layouts.app')

@section('title', 'Dashboard Bendahara')

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Dashboard Bendahara</h4>
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
                            <p class="text-truncate font-size-14 mb-2">Pendapatan Hari Ini</p>
                            <h4 class="mb-2">{{ 'Rp ' . number_format($stats['today_revenue'], 0, ',', '.') }}</h4>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-info rounded-3">
                                <i class="ti ti-calendar-event font-size-24"></i>
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
                            <p class="text-truncate font-size-14 mb-2">Pending Verifikasi</p>
                            <h4 class="mb-2">{{ $stats['pending_verification'] }}</h4>
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
        
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-truncate font-size-14 mb-2">Terverifikasi</p>
                            <h4 class="mb-2">{{ $stats['verified_transactions'] }}</h4>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-success rounded-3">
                                <i class="ti ti-check font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Aksi Cepat</h5>
                    <div class="d-grid gap-2">
                        <a href="{{ route('bendahara.transactions') }}" class="btn btn-outline-primary">
                            <i class="ti ti-list"></i> Lihat Semua Transaksi
                        </a>
                        <a href="{{ route('bendahara.reports') }}" class="btn btn-outline-info">
                            <i class="ti ti-file-description"></i> Lihat Laporan Lengkap
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Informasi</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Transaksi Hari Ini</span>
                            <strong>{{ $stats['today_revenue'] > 0 ? 'Ada' : 'Belum Ada' }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Perlu Verifikasi</span>
                            <strong class="text-warning">{{ $stats['pending_verification'] }} transaksi</strong>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

