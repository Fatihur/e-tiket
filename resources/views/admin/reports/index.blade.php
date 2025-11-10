@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Laporan Penjualan Tiket</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Laporan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Quick Stats -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="ri-filter-line me-2"></i>Filter Laporan
                        </h5>
                        <div class="d-flex gap-2">
                            
                            <button type="button" class="btn btn-danger btn-sm" onclick="exportReport('pdf')">
                                <i class="ri-file-pdf-line me-1"></i>Export PDF
                            </button>
                            
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" id="reportFilter" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Periode Laporan</label>
                            <select name="period" id="period" class="form-select" onchange="toggleCustomDate()">
                                <option value="today" {{ request('period', 'today') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                                <option value="yesterday" {{ request('period') == 'yesterday' ? 'selected' : '' }}>Kemarin</option>
                                <option value="this_week" {{ request('period') == 'this_week' ? 'selected' : '' }}>Minggu Ini</option>
                                <option value="last_week" {{ request('period') == 'last_week' ? 'selected' : '' }}>Minggu Lalu</option>
                                <option value="this_month" {{ request('period') == 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                                <option value="last_month" {{ request('period') == 'last_month' ? 'selected' : '' }}>Bulan Lalu</option>
                                <option value="this_year" {{ request('period') == 'this_year' ? 'selected' : '' }}>Tahun Ini</option>
                                <option value="custom" {{ request('period') == 'custom' ? 'selected' : '' }}>Custom Range</option>
                            </select>
                        </div>
                        
                        <div class="col-md-2" id="start_date_group" style="{{ request('period') == 'custom' ? '' : 'display: none;' }}">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                        </div>
                        
                        <div class="col-md-2" id="end_date_group" style="{{ request('period') == 'custom' ? '' : 'display: none;' }}">
                            <label class="form-label">Tanggal Akhir</label>
                            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                        </div>
                        
                        <div class="col-md-2">
                            <label class="form-label">Paket Wisata</label>
                            <select name="package_id" class="form-select">
                                <option value="">Semua Paket</option>
                                @foreach($packages as $package)
                                <option value="{{ $package->id }}" {{ request('package_id') == $package->id ? 'selected' : '' }}>
                                    {{ $package->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-2">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        
                        <div class="col-md-1">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="ri-search-line me-1"></i>Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-success rounded-circle fs-4">
                                <i class="ri-shopping-cart-line"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-uppercase fw-semibold mb-1">Total Penjualan</p>
                            <h4 class="mb-0">{{ $summary['total_sales'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-info rounded-circle fs-4">
                                <i class="ri-money-dollar-circle-line"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-uppercase fw-semibold mb-1">Total Revenue</p>
                            <h4 class="mb-0 text-success">Rp {{ number_format($summary['total_revenue'], 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-warning rounded-circle fs-4">
                                <i class="ri-users-line"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-uppercase fw-semibold mb-1">Total Pengunjung</p>
                            <h4 class="mb-0">{{ $summary['total_visitors'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-primary rounded-circle fs-4">
                                <i class="ri-ticket-line"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-uppercase fw-semibold mb-1">Tiket Terpakai</p>
                            <h4 class="mb-0">{{ $summary['used_tickets'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-bar-chart-line me-2"></i>Trend Penjualan
                        <span class="text-muted small">({{ $periodText }})</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div id="salesChart" style="height: 350px;"></div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-pie-chart-line me-2"></i>Paket Terpopuler
                    </h5>
                </div>
                <div class="card-body">
                    <div id="packageChart" style="height: 350px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Report Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="ri-table-line me-2"></i>Detail Laporan Penjualan
                        </h5>
                        <div class="d-flex gap-2">
                            <select id="tablePageSize" class="form-select form-select-sm" style="width: auto;" onchange="changePageSize()">
                                <option value="10">10 per halaman</option>
                                <option value="25" selected>25 per halaman</option>
                                <option value="50">50 per halaman</option>
                                <option value="100">100 per halaman</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($bookings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-nowrap table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Booking</th>
                                    <th>Kode Booking</th>
                                    <th>Nama Pengunjung</th>
                                    <th>Paket Wisata</th>
                                    <th>Tanggal Kunjungan</th>
                                    <th>Jumlah</th>
                                    <th>Total Bayar</th>
                                    <th>Status</th>
                                    <th>Validasi</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $index => $booking)
                                <tr>
                                    <td>{{ ($bookings->currentPage() - 1) * $bookings->perPage() + $index + 1 }}</td>
                                    <td>{{ $booking->created_at->format('d/m/Y H:i') }}</td>
                                    <td><code>{{ $booking->booking_code }}</code></td>
                                    <td>
                                        <div>
                                            <strong>{{ $booking->visitor_name }}</strong>
                                            <br><small class="text-muted">{{ $booking->visitor_email }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $booking->wisataPackage->name }}</span>
                                    </td>
                                    <td>{{ $booking->visit_date->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $booking->quantity }} orang</span>
                                    </td>
                                    <td>
                                        <strong class="text-success">{{ $booking->formatted_total_amount }}</strong>
                                    </td>
                                    <td>
                                        @if($booking->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                        @elseif($booking->status == 'confirmed')
                                        <span class="badge bg-success">Confirmed</span>
                                        @elseif($booking->status == 'rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($booking->validator)
                                        <small class="text-muted">
                                            {{ $booking->validator->name }}<br>
                                            {{ $booking->validated_at ? $booking->validated_at->format('d/m/Y H:i') : '-' }}
                                        </small>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <small class="text-muted">
                                Menampilkan {{ $bookings->firstItem() ?? 0 }} - {{ $bookings->lastItem() ?? 0 }} 
                                dari {{ $bookings->total() }} entri
                            </small>
                        </div>
                        {{ $bookings->links() }}
                    </div>

                    @else
                    <div class="text-center py-5">
                        <i class="ri-file-list-line font-size-48 text-muted"></i>
                        <h5 class="mt-3">Tidak ada data untuk periode ini</h5>
                        <p class="text-muted">Silakan ubah filter periode atau paket wisata</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Footer -->
    <div class="row">
        <div class="col-12">
            <div class="card bg-light border-0">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <h6 class="text-muted">RINGKASAN PERIODE</h6>
                            <h4>{{ $periodText }}</h4>
                        </div>
                        <div class="col-md-3">
                            <h6 class="text-muted">TOTAL TRANSAKSI</h6>
                            <h4 class="text-primary">{{ $summary['total_sales'] }}</h4>
                        </div>
                        <div class="col-md-3">
                            <h6 class="text-muted">TOTAL REVENUE</h6>
                            <h4 class="text-success">Rp {{ number_format($summary['total_revenue'], 0, ',', '.') }}</h4>
                        </div>
                        <div class="col-md-3">
                            <h6 class="text-muted">RATA-RATA TRANSAKSI</h6>
                            <h4 class="text-info">Rp {{ number_format($summary['avg_transaction'], 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart Scripts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
// Sales Trend Chart
var salesOptions = {
    series: [{
        name: 'Revenue',
        data: {!! json_encode($chartData['revenue']) !!}
    }, {
        name: 'Transaksi',
        data: {!! json_encode($chartData['transactions']) !!}
    }],
    chart: {
        type: 'area',
        height: 350,
        toolbar: { show: false }
    },
    colors: ['#28a745', '#007bff'],
    dataLabels: { enabled: false },
    stroke: { curve: 'smooth', width: 2 },
    xaxis: {
        categories: {!! json_encode($chartData['labels']) !!}
    },
    yaxis: [{
        title: { text: 'Revenue (Rp)' },
        labels: {
            formatter: function(val) {
                return 'Rp ' + val.toLocaleString('id-ID');
            }
        }
    }, {
        opposite: true,
        title: { text: 'Transaksi' }
    }],
    fill: {
        type: 'gradient',
        gradient: {
            shadeIntensity: 1,
            inverseColors: false,
            opacityFrom: 0.7,
            opacityTo: 0.1
        }
    }
};

var salesChart = new ApexCharts(document.querySelector("#salesChart"), salesOptions);
salesChart.render();

// Package Popularity Chart
var packageOptions = {
    series: {!! json_encode(array_values($packageStats)) !!},
    chart: {
        type: 'donut',
        height: 350
    },
    labels: {!! json_encode(array_keys($packageStats)) !!},
    colors: ['#28a745', '#007bff', '#ffc107', '#dc3545', '#17a2b8'],
    legend: { position: 'bottom' }
};

var packageChart = new ApexCharts(document.querySelector("#packageChart"), packageOptions);
packageChart.render();

// Helper Functions
function toggleCustomDate() {
    const period = document.getElementById('period').value;
    const startGroup = document.getElementById('start_date_group');
    const endGroup = document.getElementById('end_date_group');
    
    if (period === 'custom') {
        startGroup.style.display = 'block';
        endGroup.style.display = 'block';
    } else {
        startGroup.style.display = 'none';
        endGroup.style.display = 'none';
    }
}

function exportReport(format) {
    const form = document.getElementById('reportFilter');
    const formData = new FormData(form);
    
    const params = new URLSearchParams(formData);
    params.append('export', format);
    
    // Open in new window for PDF, download directly for Excel
    if (format === 'pdf') {
        window.open('{{ route("admin.reports.export") }}?' + params.toString(), '_blank');
    } else {
        window.location.href = '{{ route("admin.reports.export") }}?' + params.toString();
    }
}

function printReport() {
    window.print();
}

function changePageSize() {
    const pageSize = document.getElementById('tablePageSize').value;
    const url = new URL(window.location);
    url.searchParams.set('per_page', pageSize);
    window.location = url;
}

function resendTicket(bookingId) {
    if (confirm('Kirim ulang tiket ke email pengunjung?')) {
        fetch(`/admin/bookings/${bookingId}/resend-ticket`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Tiket berhasil dikirim ulang!');
            } else {
                alert('Gagal mengirim tiket: ' + data.message);
            }
        });
    }
}
</script>

<style>
@media print {
    .btn, .dropdown, .breadcrumb, .card-header .d-flex > div:last-child {
        display: none !important;
    }
    
    .card {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>
@endsection