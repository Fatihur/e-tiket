@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Tambah Petugas Tiket</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.petugas.index') }}">Petugas</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="ri-user-add-line me-2"></i>Form Tambah Petugas Tiket
                    </h4>
                </div>
                <div class="card-body">
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <h6>Terdapat kesalahan:</h6>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('admin.petugas.store') }}" method="POST">
                        @csrf

                        <!-- Data Pribadi -->
                        <div class="mb-4">
                            <h5 class="mb-3">
                                <i class="ri-user-line me-2"></i>Data Pribadi
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" 
                                               value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="employee_id" class="form-label">ID Pegawai</label>
                                        <input type="text" class="form-control" id="employee_id" name="employee_id" 
                                               value="{{ old('employee_id') }}" placeholder="Contoh: PTK001">
                                        <small class="text-muted">Kosongkan untuk generate otomatis</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email" 
                                               value="{{ old('email') }}" placeholder="Contoh: petugas@wisata.com" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">No. Telepon</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" 
                                               value="{{ old('phone') }}" placeholder="Contoh: 08123456789">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Data Akun -->
                        <div class="mb-4">
                            <h5 class="mb-3">
                                <i class="ri-lock-line me-2"></i>Data Akun
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password" name="password" 
                                                   placeholder="Minimal 8 karakter" required>
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                                <i class="ri-eye-line" id="password-icon"></i>
                                            </button>
                                        </div>
                                        <small class="text-muted">Minimal 8 karakter, kombinasi huruf dan angka</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" 
                                                   placeholder="Ulangi password" required>
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
                                                <i class="ri-eye-line" id="password_confirmation-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Data Pekerjaan -->
                        <div class="mb-4">
                            <h5 class="mb-3">
                                <i class="ri-briefcase-line me-2"></i>Data Pekerjaan
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="shift" class="form-label">Shift Kerja</label>
                                        <select class="form-select" id="shift" name="shift">
                                            <option value="">Pilih Shift</option>
                                            <option value="pagi" {{ old('shift') == 'pagi' ? 'selected' : '' }}>Pagi (07:00 - 15:00)</option>
                                            <option value="siang" {{ old('shift') == 'siang' ? 'selected' : '' }}>Siang (15:00 - 23:00)</option>
                                            <option value="malam" {{ old('shift') == 'malam' ? 'selected' : '' }}>Malam (23:00 - 07:00)</option>
                                            <option value="full" {{ old('shift') == 'full' ? 'selected' : '' }}>Full Time</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="start_date" class="form-label">Tanggal Mulai Kerja</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" 
                                               value="{{ old('start_date', date('Y-m-d')) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Catatan</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3" 
                                          placeholder="Catatan tambahan tentang petugas (opsional)">{{ old('notes') }}</textarea>
                            </div>
                        </div>

                        <!-- Permissions -->
                        <div class="mb-4">
                            <h5 class="mb-3">
                                <i class="ri-shield-check-line me-2"></i>Hak Akses
                            </h5>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="can_scan" name="can_scan" 
                                               value="1" {{ old('can_scan', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="can_scan">
                                            <strong>Dapat melakukan scan tiket</strong>
                                            <small class="d-block text-muted">Izinkan petugas untuk scan QR code tiket pengunjung</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="can_view_reports" name="can_view_reports" 
                                               value="1" {{ old('can_view_reports') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="can_view_reports">
                                            <strong>Dapat melihat laporan scanning</strong>
                                            <small class="d-block text-muted">Izinkan petugas untuk melihat laporan aktivitas scanning</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <h5 class="mb-3">
                                <i class="ri-toggle-line me-2"></i>Status
                            </h5>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                       value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    <strong>Petugas Aktif</strong>
                                    <small class="d-block text-muted">Petugas dapat login dan menggunakan sistem</small>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="text-end">
                            <a href="{{ route('admin.petugas.index') }}" class="btn btn-light me-2">
                                <i class="ri-arrow-left-line me-1"></i>Batal
                            </a>
                            <button type="reset" class="btn btn-outline-secondary me-2">
                                <i class="ri-refresh-line me-1"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-save-line me-1"></i>Simpan Petugas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.className = 'ri-eye-off-line';
    } else {
        field.type = 'password';
        icon.className = 'ri-eye-line';
    }
}
</script>
@endsection