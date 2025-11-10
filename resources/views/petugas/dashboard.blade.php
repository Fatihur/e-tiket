@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Dashboard Petugas</h4>
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
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-truncate font-size-14 mb-2">Scan Hari Ini</p>
                            <h4 class="mb-2">{{ $stats['today_scanned'] }}</h4>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-success rounded-3">
                                <i class="ti ti-qrcode font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-truncate font-size-14 mb-2">Total Scan</p>
                            <h4 class="mb-2">{{ $stats['total_scanned'] }}</h4>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-info rounded-3">
                                <i class="ti ti-ticket font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-truncate font-size-14 mb-2">Tiket Pending</p>
                            <h4 class="mb-2">{{ $stats['pending_tickets'] }}</h4>
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

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="ti ti-qrcode display-3 text-primary mb-3"></i>
                    <h4>Scanner QR Code</h4>
                    <p class="text-muted">Scan tiket pengunjung untuk validasi masuk</p>
                    <a href="{{ route('petugas.scanner') }}" class="btn btn-primary btn-lg">
                        <i class="ti ti-scan"></i> Buka Scanner
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="ti ti-list display-3 text-info mb-3"></i>
                    <h4>Riwayat Scan</h4>
                    <p class="text-muted">Lihat daftar tiket yang telah discan</p>
                    <a href="{{ route('petugas.validated.tickets') }}" class="btn btn-info btn-lg">
                        <i class="ti ti-eye"></i> Lihat Riwayat
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Scans -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Scan Terbaru</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Kode Tiket</th>
                            <th>Pengunjung</th>
                            <th>Paket</th>
                            <th>Waktu Scan</th>
                            <th>Petugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recent_scans as $scan)
                        <tr>
                            <td><code>{{ $scan->ticket_code }}</code></td>
                            <td>{{ $scan->booking->visitor_name }}</td>
                            <td>{{ $scan->booking->wisataPackage->name }}</td>
                            <td>{{ $scan->used_at->format('d/m/Y H:i:s') }}</td>
                            <td>{{ $scan->scanner->name }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada scan hari ini</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

