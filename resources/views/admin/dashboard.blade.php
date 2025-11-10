@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Dashboard Admin</h4>
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
                            <p class="text-truncate font-size-14 mb-2">Total Booking</p>
                            <h4 class="mb-2">{{ $stats['total_bookings'] }}</h4>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-primary rounded-3">
                                <i class="ri-shopping-cart-2-line font-size-24"></i>
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
                                <i class="ri-time-line font-size-24"></i>
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
                            <p class="text-truncate font-size-14 mb-2">Booking Confirmed</p>
                            <h4 class="mb-2">{{ $stats['confirmed_bookings'] }}</h4>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-success rounded-3">
                                <i class="ri-checkbox-circle-line font-size-24"></i>
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
                            <p class="text-truncate font-size-14 mb-2">Total Revenue</p>
                            <h4 class="mb-2">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h4>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-info rounded-3">
                                <i class="ri-money-dollar-circle-line font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Bookings -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="card-title mb-0">Booking Terbaru</h4>
                        <a href="{{ route('admin.bookings') }}" class="btn btn-primary btn-sm">
                            Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($recent_bookings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th>Booking Code</th>
                                    <th>Nama Pengunjung</th>
                                    <th>Paket Wisata</th>
                                    <th>Tanggal Kunjungan</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_bookings as $booking)
                                <tr>
                                    <td>{{ $booking->booking_code }}</td>
                                    <td>{{ $booking->visitor_name }}</td>
                                    <td>{{ $booking->wisataPackage->name }}</td>
                                    <td>{{ $booking->visit_date->format('d/m/Y') }}</td>
                                    <td>{{ $booking->formatted_total_amount }}</td>
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
                                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-primary btn-sm">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="ri-inbox-line font-size-48 text-muted"></i>
                        <h5 class="mt-3">Belum ada booking</h5>
                        <p class="text-muted">Booking baru akan muncul di sini</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection