@extends('layouts.app')

@section('title', 'Analisis Paket Wisata')

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Analisis Paket Wisata</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-muted" href="{{ route('owner.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Analisis Paket</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Package Analysis -->
    <div class="row">
        @foreach($packages as $package)
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    @if($package->image)
                    <img src="{{ Storage::url($package->image) }}" class="img-fluid rounded mb-3" alt="{{ $package->name }}">
                    @endif
                    
                    <h5 class="card-title">{{ $package->name }}</h5>
                    <p class="text-muted mb-3">{{ Str::limit($package->description, 100) }}</p>
                    
                    <div class="row text-center mb-3">
                        <div class="col-6">
                            <h6 class="text-muted mb-1">Total Booking</h6>
                            <h4 class="mb-0">{{ $package->bookings_count }}</h4>
                        </div>
                        <div class="col-6">
                            <h6 class="text-muted mb-1">Pendapatan</h6>
                            <h4 class="mb-0">{{ 'Rp ' . number_format($package->bookings_sum_total_amount ?? 0, 0, ',', '.') }}</h4>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">{{ $package->formatted_price }}</span>
                        @if($package->is_active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Tidak Aktif</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

