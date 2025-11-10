@extends('layouts.app')

@section('title', 'Edit Petugas')

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Edit Data Petugas</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-muted" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a class="text-muted" href="{{ route('admin.petugas.index') }}">Petugas</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.petugas.update', $petugas->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $petugas->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $petugas->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">ID Karyawan</label>
                                <input type="text" name="employee_id" class="form-control @error('employee_id') is-invalid @enderror" value="{{ old('employee_id', $petugas->employee_id) }}">
                                @error('employee_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">No. Telepon</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $petugas->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Shift</label>
                                <select name="shift" class="form-select @error('shift') is-invalid @enderror">
                                    <option value="">Pilih Shift</option>
                                    <option value="pagi" {{ old('shift', $petugas->shift) == 'pagi' ? 'selected' : '' }}>Pagi (07:00 - 15:00)</option>
                                    <option value="siang" {{ old('shift', $petugas->shift) == 'siang' ? 'selected' : '' }}>Siang (15:00 - 23:00)</option>
                                    <option value="malam" {{ old('shift', $petugas->shift) == 'malam' ? 'selected' : '' }}>Malam (23:00 - 07:00)</option>
                                    <option value="full" {{ old('shift', $petugas->shift) == 'full' ? 'selected' : '' }}>Full Time</option>
                                </select>
                                @error('shift')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date', $petugas->start_date ? $petugas->start_date->format('Y-m-d') : '') }}">
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catatan</label>
                            <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes', $petugas->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="can_scan" id="can_scan" value="1" {{ old('can_scan', $petugas->can_scan) ? 'checked' : '' }}>
                                <label class="form-check-label" for="can_scan">
                                    Dapat melakukan scanning tiket
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="can_view_reports" id="can_view_reports" value="1" {{ old('can_view_reports', $petugas->can_view_reports) ? 'checked' : '' }}>
                                <label class="form-check-label" for="can_view_reports">
                                    Dapat melihat laporan
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $petugas->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Status Aktif
                                </label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.petugas.index') }}" class="btn btn-secondary">
                                <i class="ti ti-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

