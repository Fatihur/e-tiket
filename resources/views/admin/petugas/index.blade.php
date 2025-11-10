@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Data Petugas Tiket</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Petugas Tiket</li>
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
                            <p class="text-truncate font-size-14 mb-2">Total Petugas</p>
                            <h4 class="mb-2">{{ $stats['total_petugas'] }}</h4>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-primary rounded-3">
                                <i class="ri-user-line font-size-24"></i>
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
                            <p class="text-truncate font-size-14 mb-2">Petugas Aktif</p>
                            <h4 class="mb-2">{{ $stats['petugas_aktif'] }}</h4>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-success rounded-3">
                                <i class="ri-user-check-line font-size-24"></i>
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
                            <p class="text-truncate font-size-14 mb-2">Scan Hari Ini</p>
                            <h4 class="mb-2">{{ $stats['scan_today'] }}</h4>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-info rounded-3">
                                <i class="ri-qr-scan-line font-size-24"></i>
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
                            <p class="text-truncate font-size-14 mb-2">Total Scan</p>
                            <h4 class="mb-2">{{ $stats['total_scan'] }}</h4>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-warning rounded-3">
                                <i class="ri-scan-line font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Petugas List -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="card-title mb-0">Daftar Petugas Tiket</h4>
                        <div>
                            <a href="{{ route('admin.petugas.create') }}" class="btn btn-primary">
                                <i class="ri-add-line me-2"></i>Tambah Petugas Baru
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

                    @if($petugas->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-nowrap table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Email</th>
                                    <th>No. Telepon</th>
                                    <th>Shift</th>
                                    <th>Status</th>
                                    <th>Total Scan</th>
                                    <th>Bergabung</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($petugas as $index => $p)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-3">
                                                <div class="avatar-title bg-soft-primary text-primary rounded-circle">
                                                    {{ strtoupper(substr($p->name, 0, 1)) }}
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $p->name }}</h6>
                                                <small class="text-muted">{{ $p->employee_id ?? 'ID' . str_pad($p->id, 4, '0', STR_PAD_LEFT) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $p->email }}</td>
                                    <td>{{ $p->phone ?? '-' }}</td>
                                    <td>
                                        @if($p->shift)
                                        <span class="badge bg-info">{{ ucfirst($p->shift) }}</span>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($p->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                        @else
                                        <span class="badge bg-danger">Non-Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $p->scanned_tickets_count ?? 0 }}</span>
                                    </td>
                                    <td>{{ $p->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-light btn-sm dropdown-toggle" type="button" 
                                                    data-bs-toggle="dropdown">
                                                <i class="ri-more-2-line"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.petugas.show', $p->id) }}">
                                                        <i class="ri-eye-line me-2"></i>Detail
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.petugas.edit', $p->id) }}">
                                                        <i class="ri-edit-line me-2"></i>Edit
                                                    </a>
                                                </li>
                                                @if($p->is_active)
                                                <li>
                                                    <form action="{{ route('admin.petugas.deactivate', $p->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="dropdown-item text-warning" 
                                                                onclick="return confirm('Yakin ingin menonaktifkan petugas ini?')">
                                                            <i class="ri-user-unfollow-line me-2"></i>Non-aktifkan
                                                        </button>
                                                    </form>
                                                </li>
                                                @else
                                                <li>
                                                    <form action="{{ route('admin.petugas.activate', $p->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="dropdown-item text-success">
                                                            <i class="ri-user-follow-line me-2"></i>Aktifkan
                                                        </button>
                                                    </form>
                                                </li>
                                                @endif
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('admin.petugas.destroy', $p->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger" 
                                                                onclick="return confirm('Yakin ingin menghapus petugas ini? Data yang terkait akan tetap tersimpan.')">
                                                            <i class="ri-delete-bin-line me-2"></i>Hapus
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="ri-user-line font-size-48 text-muted"></i>
                        <h5 class="mt-3">Belum ada petugas tiket</h5>
                        <p class="text-muted">Tambahkan petugas tiket untuk mulai mengelola validasi tiket</p>
                        <a href="{{ route('admin.petugas.create') }}" class="btn btn-primary">
                            <i class="ri-add-line me-2"></i>Tambah Petugas Pertama
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection