@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Detail Paket Wisata</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.packages') }}">Paket Wisata</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Package Info -->
        <div class="col-lg-8">
            <div class="card">
                @if($package->image)
                <img src="{{ asset('storage/' . $package->image) }}" class="card-img-top" alt="{{ $package->name }}" style="height: 400px; object-fit: cover;">
                @else
                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                    <div class="text-center">
                        <i class="ri-image-line fa-5x text-muted"></i>
                        <p class="text-muted mt-3 mb-0">Tidak ada gambar</p>
                    </div>
                </div>
                @endif

                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h3 class="card-title mb-2">{{ $package->name }}</h3>
                            <div class="d-flex gap-2 mb-2">
                                @if($package->is_active)
                                <span class="badge bg-success">Aktif</span>
                                @else
                                <span class="badge bg-danger">Non-Aktif</span>
                                @endif
                                
                                @if($package->featured ?? false)
                                <span class="badge bg-warning">Unggulan</span>
                                @endif
                            </div>
                        </div>
                        <div class="text-end">
                            <h3 class="text-primary mb-0">{{ $package->formatted_price }}</h3>
                            <small class="text-muted">per orang</small>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5>Deskripsi</h5>
                        <p class="text-muted">{{ $package->description }}</p>
                    </div>

                    @if($package->facilities)
                    <div class="mb-4">
                        <h5>Fasilitas</h5>
                        <div class="row">
                            @php
                                $facilities = explode(',', $package->facilities);
                            @endphp
                            @foreach($facilities as $facility)
                            <div class="col-md-6 mb-2">
                                <i class="ri-check-line text-success me-2"></i>{{ trim($facility) }}
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <h6>Informasi Paket</h6>
                            <ul class="list-unstyled">
                                <li><strong>Kapasitas Maksimal:</strong> {{ $package->max_capacity }} orang</li>
                                <li><strong>Dibuat:</strong> {{ $package->created_at->format('d M Y, H:i') }}</li>
                                <li><strong>Terakhir Diupdate:</strong> {{ $package->updated_at->format('d M Y, H:i') }}</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>Quick Actions</h6>
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.packages.edit', $package->id) }}" class="btn btn-primary">
                                    <i class="ri-edit-line me-2"></i>Edit Paket
                                </a>
                                <a href="{{ route('landing.package.detail', $package->id) }}" target="_blank" class="btn btn-outline-info">
                                    <i class="ri-external-link-line me-2"></i>Lihat di Website
                                </a>
                                @if($package->is_active)
                                <form action="{{ route('admin.packages.deactivate', $package->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-outline-warning" onclick="return confirm('Yakin ingin menonaktifkan paket ini?')">
                                        <i class="ri-pause-circle-line me-2"></i>Non-aktifkan
                                    </button>
                                </form>
                                @else
                                <form action="{{ route('admin.packages.activate', $package->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-outline-success">
                                        <i class="ri-play-circle-line me-2"></i>Aktifkan
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="col-lg-4">
            <!-- Performance Stats -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-bar-chart-line me-2"></i>Statistik Performa
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <h3 class="text-primary">{{ $stats['total_bookings'] }}</h3>
                        <p class="text-muted mb-0">Total Booking</p>
                    </div>
                    
                    <div class="row text-center">
                        <div class="col-6">
                            <h5 class="text-success">{{ $stats['confirmed_bookings'] }}</h5>
                            <p class="text-muted small mb-0">Confirmed</p>
                        </div>
                        <div class="col-6">
                            <h5 class="text-warning">{{ $stats['pending_bookings'] }}</h5>
                            <p class="text-muted small mb-0">Pending</p>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="text-center">
                        <h4 class="text-success">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h4>
                        <p class="text-muted mb-0">Total Revenue</p>
                    </div>
                </div>
            </div>

            <!-- Monthly Performance -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-calendar-line me-2"></i>Performa Bulan Ini
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <h5>{{ $stats['monthly_bookings'] }}</h5>
                            <p class="text-muted small mb-0">Booking</p>
                        </div>
                        <div class="col-6">
                            <h5>{{ $stats['monthly_visitors'] }}</h5>
                            <p class="text-muted small mb-0">Pengunjung</p>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center">
                        <h5 class="text-success">Rp {{ number_format($stats['monthly_revenue'], 0, ',', '.') }}</h5>
                        <p class="text-muted small mb-0">Revenue Bulan Ini</p>
                    </div>
                </div>
            </div>

            <!-- Rating & Reviews -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-star-line me-2"></i>Rating & Ulasan
                    </h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <h3>4.5 <span class="h5 text-muted">/ 5.0</span></h3>
                        <div class="text-warning mb-2">
                            ⭐⭐⭐⭐⭐
                        </div>
                        <p class="text-muted small">Berdasarkan 23 ulasan</p>
                    </div>
                    
                    <div class="progress-stacked mb-2">
                        <div class="progress" role="progressbar" style="width: 70%">
                            <div class="progress-bar bg-warning"></div>
                        </div>
                    </div>
                    <small class="text-muted">70% pengunjung memberikan rating ⭐⭐⭐⭐⭐</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Bookings -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="ri-shopping-cart-line me-2"></i>Booking Terbaru
                        </h5>
                        <a href="{{ route('admin.bookings') }}?package={{ $package->id }}" class="btn btn-outline-primary btn-sm">
                            Lihat Semua Booking
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($recentBookings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-nowrap">
                            <thead>
                                <tr>
                                    <th>Booking Code</th>
                                    <th>Nama Pengunjung</th>
                                    <th>Tanggal Kunjungan</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentBookings as $booking)
                                <tr>
                                    <td><code>{{ $booking->booking_code }}</code></td>
                                    <td>{{ $booking->visitor_name }}</td>
                                    <td>{{ $booking->visit_date->format('d/m/Y') }}</td>
                                    <td>{{ $booking->quantity }} orang</td>
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
                                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-sm btn-outline-primary">
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
                        <i class="ri-shopping-cart-line font-size-48 text-muted"></i>
                        <h6 class="mt-3">Belum ada booking</h6>
                        <p class="text-muted">Booking untuk paket ini akan muncul di sini</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection