@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Ringkasan Laporan Penjualan</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Ringkasan Laporan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Period Summary Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-primary h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Hari Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($daily['revenue'] ?? 0, 0, ',', '.') }}
                            </div>
                            <div class="small text-muted">{{ $daily['transactions'] ?? 0 }} transaksi</div>
                        </div>
                        <div class="col-auto">
                            <i class="ri-calendar-today-line fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-left-success h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Minggu Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($weekly['revenue'] ?? 0, 0, ',', '.') }}
                            </div>
                            <div class="small text-muted">{{ $weekly['transactions'] ?? 0 }} transaksi</div>
                        </div>
                        <div class="col-auto">
                            <i class="ri-calendar-week-line fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-left-info h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Bulan Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($monthly['revenue'] ?? 0, 0, ',', '.') }}
                            </div>
                            <div class="small text-muted">{{ $monthly['transactions'] ?? 0 }} transaksi</div>
                        </div>
                        <div class="col-auto">
                            <i class="ri-calendar-month-line fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-left-warning h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Tahun Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($yearly['revenue'] ?? 0, 0, ',', '.') }}
                            </div>
                            <div class="small text-muted">{{ $yearly['transactions'] ?? 0 }} transaksi</div>
                        </div>
                        <div class="col-auto">
                            <i class="ri-calendar-year-line fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-dashboard-line me-2"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="{{ route('admin.reports') }}?period=today" class="btn btn-outline-primary w-100 mb-2">
                                <i class="ri-today-line me-2"></i>Laporan Hari Ini
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.reports') }}?period=this_week" class="btn btn-outline-success w-100 mb-2">
                                <i class="ri-calendar-week-line me-2"></i>Laporan Mingguan
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.reports') }}?period=this_month" class="btn btn-outline-info w-100 mb-2">
                                <i class="ri-calendar-month-line me-2"></i>Laporan Bulanan
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.reports') }}?period=custom" class="btn btn-outline-warning w-100 mb-2">
                                <i class="ri-calendar-range-line me-2"></i>Custom Range
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Packages -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-star-line me-2"></i>Paket Terpopuler (Bulan Ini)
                    </h5>
                </div>
                <div class="card-body">
                    @if(!empty($top_packages))
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Ranking</th>
                                    <th>Paket Wisata</th>
                                    <th>Booking</th>
                                    <th>Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($top_packages as $index => $package)
                                <tr>
                                    <td>
                                        @if($index == 0)
                                        <span class="badge bg-warning">🥇</span>
                                        @elseif($index == 1)
                                        <span class="badge bg-secondary">🥈</span>
                                        @elseif($index == 2)
                                        <span class="badge bg-dark">🥉</span>
                                        @else
                                        <span class="badge bg-light text-dark">{{ $index + 1 }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $package['name'] }}</td>
                                    <td><span class="badge bg-primary">{{ $package['bookings'] }}</span></td>
                                    <td class="text-success">Rp {{ number_format($package['revenue'], 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-3">
                        <i class="ri-gift-line font-size-48 text-muted"></i>
                        <p class="text-muted mt-2">Belum ada data paket untuk bulan ini</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-user-star-line me-2"></i>Top Petugas Scanner (Bulan Ini)
                    </h5>
                </div>
                <div class="card-body">
                    @if(!empty($top_scanners))
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Ranking</th>
                                    <th>Nama Petugas</th>
                                    <th>Total Scan</th>
                                    <th>Hari Aktif</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($top_scanners as $index => $scanner)
                                <tr>
                                    <td>
                                        @if($index == 0)
                                        <span class="badge bg-warning">🏆</span>
                                        @else
                                        <span class="badge bg-light text-dark">{{ $index + 1 }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $scanner['name'] }}</td>
                                    <td><span class="badge bg-success">{{ $scanner['total_scans'] }}</span></td>
                                    <td><span class="badge bg-info">{{ $scanner['active_days'] }}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-3">
                        <i class="ri-user-line font-size-48 text-muted"></i>
                        <p class="text-muted mt-2">Belum ada data scanning untuk bulan ini</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-history-line me-2"></i>Aktivitas Terbaru
                    </h5>
                </div>
                <div class="card-body">
                    @if(!empty($recent_activities))
                    <div class="timeline">
                        @foreach($recent_activities as $activity)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-{{ $activity['color'] }}"></div>
                            <div class="timeline-content">
                                <h6>{{ $activity['title'] }}</h6>
                                <p class="text-muted small mb-1">{{ $activity['description'] }}</p>
                                <small class="text-muted">{{ $activity['time'] }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-3">
                        <i class="ri-history-line font-size-48 text-muted"></i>
                        <p class="text-muted mt-2">Belum ada aktivitas terbaru</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.border-left-primary { border-left: 4px solid #007bff !important; }
.border-left-success { border-left: 4px solid #28a745 !important; }
.border-left-info { border-left: 4px solid #17a2b8 !important; }
.border-left-warning { border-left: 4px solid #ffc107 !important; }

.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline:before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #e9ecef;
}

.timeline-content {
    margin-left: 10px;
}
</style>
@endsection