@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Manajemen Paket Wisata</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Paket Wisata</li>
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
                            <p class="text-truncate font-size-14 mb-2">Total Paket</p>
                            <h4 class="mb-2">{{ $stats['total_packages'] }}</h4>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-primary rounded-3">
                                <i class="ri-gift-line font-size-24"></i>
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
                            <h4 class="mb-2">{{ $stats['active_packages'] }}</h4>
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
                            <p class="text-truncate font-size-14 mb-2">Total Booking</p>
                            <h4 class="mb-2">{{ $stats['total_bookings'] }}</h4>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-info rounded-3">
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
                            <p class="text-truncate font-size-14 mb-2">Revenue</p>
                            <h4 class="mb-2">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h4>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-warning rounded-3">
                                <i class="ri-money-dollar-circle-line font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter and Search -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="price_range" class="form-select">
                                <option value="">Semua Harga</option>
                                <option value="0-50000" {{ request('price_range') == '0-50000' ? 'selected' : '' }}>< Rp 50.000</option>
                                <option value="50000-100000" {{ request('price_range') == '50000-100000' ? 'selected' : '' }}>Rp 50.000 - Rp 100.000</option>
                                <option value="100000-200000" {{ request('price_range') == '100000-200000' ? 'selected' : '' }}>Rp 100.000 - Rp 200.000</option>
                                <option value="200000+" {{ request('price_range') == '200000+' ? 'selected' : '' }}>> Rp 200.000</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Cari nama paket..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="ri-search-line me-1"></i>Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Packages List -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="card-title mb-0">Daftar Paket Wisata</h4>
                        <div>
                            <a href="{{ route('admin.packages.create') }}" class="btn btn-primary">
                                <i class="ri-add-line me-2"></i>Tambah Paket Baru
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @if($packages->count() > 0)
                    <div class="row">
                        @foreach($packages as $package)
                        <div class="col-lg-6 col-xl-4">
                            <div class="card h-100 position-relative">
                                <!-- Status Badge -->
                                <div class="position-absolute top-0 start-0 m-3" style="z-index: 10;">
                                    @if($package->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                    @else
                                    <span class="badge bg-danger">Non-Aktif</span>
                                    @endif
                                </div>

                                <!-- Price Badge -->
                                <div class="position-absolute top-0 end-0 m-3" style="z-index: 10;">
                                    <span class="badge bg-primary fs-6">{{ $package->formatted_price }}</span>
                                </div>

                                <!-- Package Image -->
                                @if($package->image)
                                <img src="{{ asset('storage/' . $package->image) }}" class="card-img-top" alt="{{ $package->name }}" style="height: 200px; object-fit: cover;">
                                @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <div class="text-center">
                                        <i class="ri-image-line fa-3x text-muted"></i>
                                        <p class="text-muted mt-2 mb-0">Tidak ada gambar</p>
                                    </div>
                                </div>
                                @endif

                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $package->name }}</h5>
                                    <p class="card-text text-muted flex-grow-1">
                                        {{ Str::limit($package->description, 100) }}
                                    </p>

                                    <!-- Package Info -->
                                    <div class="mb-3">
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <small class="text-muted">
                                                    <i class="ri-users-line me-1"></i>
                                                    Max {{ $package->max_capacity }} orang
                                                </small>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted">
                                                    <i class="ri-shopping-cart-line me-1"></i>
                                                    {{ $package->bookings_count ?? 0 }} booking
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    @if($package->facilities)
                                    <div class="mb-3">
                                        <small class="text-muted">
                                            <i class="ri-star-line me-1"></i>
                                            {{ Str::limit($package->facilities, 50) }}
                                        </small>
                                    </div>
                                    @endif

                                    <!-- Action Buttons -->
                                    <div class="d-grid gap-2">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.packages.show', $package->id) }}" class="btn btn-outline-primary btn-sm">
                                                <i class="ri-eye-line me-1"></i>Detail
                                            </a>
                                            <a href="{{ route('admin.packages.edit', $package->id) }}" class="btn btn-outline-secondary btn-sm">
                                                <i class="ri-edit-line me-1"></i>Edit
                                            </a>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-outline-info btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    @if($package->is_active)
                                                    <li>
                                                        <form action="{{ route('admin.packages.deactivate', $package->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="dropdown-item text-warning" onclick="return confirm('Yakin ingin menonaktifkan paket ini?')">
                                                                <i class="ri-pause-circle-line me-2"></i>Non-aktifkan
                                                            </button>
                                                        </form>
                                                    </li>
                                                    @else
                                                    <li>
                                                        <form action="{{ route('admin.packages.activate', $package->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="dropdown-item text-success">
                                                                <i class="ri-play-circle-line me-2"></i>Aktifkan
                                                            </button>
                                                        </form>
                                                    </li>
                                                    @endif
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('landing.package.detail', $package->id) }}" target="_blank">
                                                            <i class="ri-external-link-line me-2"></i>Lihat di Website
                                                        </a>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <form action="{{ route('admin.packages.destroy', $package->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Yakin ingin menghapus paket ini? Data booking yang terkait akan tetap tersimpan.')">
                                                                <i class="ri-delete-bin-line me-2"></i>Hapus
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer bg-light">
                                    <small class="text-muted">
                                        Dibuat: {{ $package->created_at->format('d/m/Y') }}
                                        @if($package->updated_at != $package->created_at)
                                        | Diupdate: {{ $package->updated_at->format('d/m/Y') }}
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($packages->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $packages->links() }}
                    </div>
                    @endif

                    @else
                    <div class="text-center py-5">
                        <i class="ri-gift-line font-size-48 text-muted"></i>
                        <h5 class="mt-3">Belum ada paket wisata</h5>
                        <p class="text-muted">Tambahkan paket wisata pertama untuk mulai menerima booking</p>
                        <a href="{{ route('admin.packages.create') }}" class="btn btn-primary">
                            <i class="ri-add-line me-2"></i>Tambah Paket Pertama
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection