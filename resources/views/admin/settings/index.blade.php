@extends('layouts.app')

@section('title', 'Pengaturan Aplikasi')

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Pengaturan Aplikasi</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-muted" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pengaturan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="ti ti-check"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="ti ti-alert-triangle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <!-- Tabs Navigation -->
            <ul class="nav nav-pills mb-4" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="pill" href="#general-tab" role="tab">
                        <i class="ti ti-settings me-2"></i>Pengaturan Umum
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="pill" href="#email-tab" role="tab">
                        <i class="ti ti-mail me-2"></i>Konfigurasi Email
                    </a>
                </li>
            </ul>

            <!-- Tabs Content -->
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                
                <div class="tab-content">
                    <!-- General Settings Tab -->
                    <div class="tab-pane fade show active" id="general-tab" role="tabpanel">
                        <h5 class="mb-3">Informasi Aplikasi</h5>
                        <p class="text-muted mb-4">Pengaturan informasi dasar aplikasi yang akan ditampilkan di website</p>

                        @foreach($generalSettings as $setting)
                        <div class="mb-3">
                            <label class="form-label">{{ ucwords(str_replace('_', ' ', str_replace('app_', '', $setting->key))) }}</label>
                            
                            @if($setting->type == 'textarea')
                                <textarea name="settings[{{ $setting->key }}]" class="form-control" rows="3">{{ $setting->value }}</textarea>
                            @elseif($setting->type == 'email')
                                <input type="email" name="settings[{{ $setting->key }}]" class="form-control" value="{{ $setting->value }}">
                            @else
                                <input type="text" name="settings[{{ $setting->key }}]" class="form-control" value="{{ $setting->value }}">
                            @endif
                            
                            @if($setting->key == 'app_name')
                                <small class="text-muted">Nama aplikasi yang akan ditampilkan di header dan email</small>
                            @elseif($setting->key == 'app_email')
                                <small class="text-muted">Email kontak yang akan ditampilkan di website</small>
                            @elseif($setting->key == 'app_phone')
                                <small class="text-muted">Nomor telepon/WhatsApp untuk kontak pengunjung</small>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    <!-- Email Settings Tab -->
                    <div class="tab-pane fade" id="email-tab" role="tabpanel">
                        <div class="alert alert-info">
                            <i class="ti ti-info-circle me-2"></i>
                            <strong>Panduan Konfigurasi Email:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Gunakan <strong>Gmail App Password</strong> jika menggunakan Gmail (bukan password biasa)</li>
                                <li>Aktifkan "Less secure app access" atau buat App Password di Google Account</li>
                                <li>Untuk Gmail: Host=smtp.gmail.com, Port=587, Encryption=tls</li>
                                <li>Test email setelah konfigurasi untuk memastikan berfungsi</li>
                            </ul>
                        </div>

                        <h5 class="mb-3">Konfigurasi SMTP</h5>
                        <p class="text-muted mb-4">Pengaturan email untuk pengiriman tiket ke pengunjung</p>

                        @foreach($emailSettings as $setting)
                        <div class="mb-3">
                            <label class="form-label">
                                {{ ucwords(str_replace('_', ' ', str_replace('mail_', '', $setting->key))) }}
                                @if(in_array($setting->key, ['mail_username', 'mail_password']))
                                    <span class="text-danger">*</span>
                                @endif
                            </label>
                            
                            @if($setting->type == 'password')
                                <input type="password" name="settings[{{ $setting->key }}]" class="form-control" value="{{ $setting->value }}" placeholder="Masukkan password email">
                                <small class="text-muted">Password/App Password untuk SMTP</small>
                            @elseif($setting->type == 'number')
                                <input type="number" name="settings[{{ $setting->key }}]" class="form-control" value="{{ $setting->value }}">
                            @elseif($setting->type == 'email')
                                <input type="email" name="settings[{{ $setting->key }}]" class="form-control" value="{{ $setting->value }}">
                            @else
                                <input type="text" name="settings[{{ $setting->key }}]" class="form-control" value="{{ $setting->value }}">
                            @endif
                            
                            @if($setting->key == 'mail_host')
                                <small class="text-muted">Contoh: smtp.gmail.com, smtp.mailtrap.io</small>
                            @elseif($setting->key == 'mail_port')
                                <small class="text-muted">Port SMTP (587 untuk TLS, 465 untuk SSL)</small>
                            @elseif($setting->key == 'mail_encryption')
                                <small class="text-muted">tls atau ssl</small>
                            @elseif($setting->key == 'mail_username')
                                <small class="text-muted">Email lengkap yang digunakan untuk SMTP</small>
                            @elseif($setting->key == 'mail_from_address')
                                <small class="text-muted">Email pengirim yang akan muncul di inbox pengunjung</small>
                            @endif
                        </div>
                        @endforeach

                        <!-- Test Email Section -->
                        <div class="border-top pt-4 mt-4">
                            <h5 class="mb-3">Test Pengiriman Email</h5>
                            <p class="text-muted">Kirim email test untuk memastikan konfigurasi benar</p>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="email" id="testEmail" class="form-control" placeholder="Masukkan email tujuan test">
                                        <button type="button" class="btn btn-info" onclick="sendTestEmail()">
                                            <i class="ti ti-send"></i> Kirim Test Email
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="testEmailResult" class="mt-3"></div>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="border-top pt-4 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy me-2"></i>Simpan Pengaturan
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                        <i class="ti ti-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function sendTestEmail() {
    const email = document.getElementById('testEmail').value;
    const resultDiv = document.getElementById('testEmailResult');
    
    if (!email) {
        resultDiv.innerHTML = '<div class="alert alert-warning"><i class="ti ti-alert-triangle"></i> Masukkan email tujuan test</div>';
        return;
    }
    
    resultDiv.innerHTML = '<div class="alert alert-info"><i class="ti ti-loader"></i> Mengirim email test...</div>';
    
    fetch('{{ route("admin.settings.test-email") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ test_email: email })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            resultDiv.innerHTML = `<div class="alert alert-success"><i class="ti ti-check"></i> ${data.message}</div>`;
        } else {
            resultDiv.innerHTML = `<div class="alert alert-danger"><i class="ti ti-x"></i> ${data.message}</div>`;
        }
    })
    .catch(error => {
        resultDiv.innerHTML = '<div class="alert alert-danger"><i class="ti ti-x"></i> Terjadi kesalahan saat mengirim email</div>';
    });
}
</script>
@endpush
@endsection

