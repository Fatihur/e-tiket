@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Detail Petugas Tiket</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.petugas.index') }}">Petugas</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Profile Card -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="avatar-lg mx-auto mb-4">
                        <div class="avatar-title bg-soft-primary text-primary rounded-circle display-6">
                            {{ strtoupper(substr($petugas->name, 0, 1)) }}
                        </div>
                    </div>
                    
                    <h5 class="mb-1">{{ $petugas->name }}</h5>
                    <p class="text-muted mb-3">{{ $petugas->employee_id ?? 'ID' . str_pad($petugas->id, 4, '0', STR_PAD_LEFT) }}</p>
                    
                    @if($petugas->is_active)
                    <span class="badge bg-success mb-3">Aktif</span>
                    @else
                    <span class="badge bg-danger mb-3">Non-Aktif</span>
                    @endif
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.petugas.edit', $petugas->id) }}" class="btn btn-primary">
                            <i class="ri-edit-line me-2"></i>Edit Data
                        </a>
                        @if($petugas->is_active)
                        <form action="{{ route('admin.petugas.deactivate', $petugas->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-warning w-100" onclick="return confirm('Yakin ingin menonaktifkan petugas ini?')">
                                <i class="ri-user-unfollow-line me-2"></i>Non-aktifkan
                            </button>
                        </form>
                        @else
                        <form action="{{ route('admin.petugas.activate', $petugas->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success w-100">
                                <i class="ri-user-follow-line me-2"></i>Aktifkan
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Statistik Scanning</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <h4 class="text-primary">{{ $scanStats['today_scans'] }}</h4>
                            <p class="text-muted mb-0">Hari Ini</p>
                        </div>
                        <div class="col-6">
                            <h4 class="text-info">{{ $scanStats['this_week'] }}</h4>
                            <p class="text-muted mb-0">Minggu Ini</p>
                        </div>
                        <div class="col-6 mt-3">
                            <h4 class="text-warning">{{ $scanStats['this_month'] }}</h4>
                            <p class="text-muted mb-0">Bulan Ini</p>
                        </div>
                        <div class="col-6 mt-3">
                            <h4 class="text-success">{{ $scanStats['total_scans'] }}</h4>
                            <p class="text-muted mb-0">Total</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Information -->
        <div class="col-lg-8">
            <!-- Personal Info -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-user-line me-2"></i>Informasi Pribadi
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Nama Lengkap</label>
                                <p class="mb-0">{{ $petugas->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">ID Pegawai</label>
                                <p class="mb-0">{{ $petugas->employee_id ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Email</label>
                                <p class="mb-0">{{ $petugas->email }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">No. Telepon</label>
                                <p class="mb-0">{{ $petugas->phone ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Work Info -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-briefcase-line me-2"></i>Informasi Pekerjaan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Shift Kerja</label>
                                <p class="mb-0">
                                    @if($petugas->shift)
                                    <span class="badge bg-info">{{ $petugas->formatted_shift }}</span>
                                    @else
                                    -
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Tanggal Mulai</label>
                                <p class="mb-0">{{ $petugas->start_date ? $petugas->start_date->format('d/m/Y') : '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Hak Akses Scan</label>
                                <p class="mb-0">
                                    @if($petugas->can_scan)
                                    <span class="badge bg-success">Ya</span>
                                    @else
                                    <span class="badge bg-danger">Tidak</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Lihat Laporan</label>
                                <p class="mb-0">
                                    @if($petugas->can_view_reports)
                                    <span class="badge bg-success">Ya</span>
                                    @else
                                    <span class="badge bg-danger">Tidak</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        @if($petugas->notes)
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label text-muted">Catatan</label>
                                <p class="mb-0">{{ $petugas->notes }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recent Scans -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-qr-scan-line me-2"></i>Scanning Terakhir
                    </h5>
                </div>
                <div class="card-body">
                    @if($recentScans->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Kode Tiket</th>
                                    <th>Pengunjung</th>
                                    <th>Paket</th>
                                    <th>Waktu Scan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentScans as $scan)
                                <tr>
                                    <td><code>{{ $scan->ticket_code }}</code></td>
                                    <td>{{ $scan->booking->visitor_name }}</td>
                                    <td>{{ $scan->booking->wisataPackage->name }}</td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $scan->used_at->format('d/m/Y H:i') }}
                                        </small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-3">
                        <i class="ri-qr-scan-line font-size-48 text-muted"></i>
                        <h6 class="mt-2">Belum ada aktivitas scanning</h6>
                        <p class="text-muted mb-0">Petugas belum melakukan scanning tiket</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection