@extends('layouts.auth')

@section('title', 'Login - E-Tiket Wisata')

@section('content')
<div class="card mb-0">
  <div class="card-body">
    <div class="text-center py-3">
      <img src="{{ asset('assets/images/logos/dark-logo.svg') }}" width="180" alt="E-Tiket Wisata">
      <h4 class="mt-3 text-primary">E-Tiket Wisata</h4>
      <p class="text-muted">Login untuk mengakses sistem</p>
    </div>

    @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('auth.login') }}" method="POST">
      @csrf
      
      <div class="mb-3">
        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" 
               id="email" name="email" placeholder="Masukkan email Anda" 
               value="{{ old('email') }}" required autofocus>
        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-4">
        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
        <div class="position-relative">
          <input type="password" class="form-control @error('password') is-invalid @enderror" 
                 id="password" name="password" placeholder="Masukkan password" required>
          <button class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-muted" 
                  type="button" id="password-addon">
            <i class="ri-eye-fill" id="password-icon"></i>
          </button>
        </div>
        @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
          <label class="form-check-label text-dark" for="remember">
            Ingat saya
          </label>
        </div>
      </div>

      <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">
        <i class="ri-login-line me-2"></i>Masuk
      </button>

      <!-- Demo Accounts -->
      <div class="card bg-light border-0 mb-3">
        <div class="card-body p-3">
          <h6 class="mb-2"><i class="ri-information-line me-2"></i>Demo Akun:</h6>
          <div class="row small">
            <div class="col-6">
              <div class="demo-account" onclick="fillDemo('admin@etiket.com', 'admin123')" style="cursor: pointer;" title="Klik untuk auto-fill">
                <strong>Admin:</strong><br>
                admin@etiket.com<br>
                admin123
              </div>
            </div>
            <div class="col-6">
              <div class="demo-account" onclick="fillDemo('petugas@etiket.com', 'petugas123')" style="cursor: pointer;" title="Klik untuk auto-fill">
                <strong>Petugas:</strong><br>
                petugas@etiket.com<br>
                petugas123
              </div>
            </div>
          </div>
          <div class="row small mt-2">
            <div class="col-6">
              <div class="demo-account" onclick="fillDemo('bendahara@etiket.com', 'bendahara123')" style="cursor: pointer;" title="Klik untuk auto-fill">
                <strong>Bendahara:</strong><br>
                bendahara@etiket.com<br>
                bendahara123
              </div>
            </div>
            <div class="col-6">
              <div class="demo-account" onclick="fillDemo('owner@etiket.com', 'owner123')" style="cursor: pointer;" title="Klik untuk auto-fill">
                <strong>Owner:</strong><br>
                owner@etiket.com<br>
                owner123
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="text-center">
        <p class="mb-0 text-muted">
          <i class="ri-shield-check-line me-1"></i>
          Sistem E-Tiket Wisata - Secure Access
        </p>
      </div>
    </form>
  </div>
</div>

<script>
// Password toggle functionality
document.getElementById('password-addon').addEventListener('click', function() {
    const passwordInput = document.getElementById('password');
    const icon = document.getElementById('password-icon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.className = 'ri-eye-off-fill';
    } else {
        passwordInput.type = 'password';
        icon.className = 'ri-eye-fill';
    }
});

// Auto-fill demo credentials
function fillDemo(email, password) {
    document.getElementById('email').value = email;
    document.getElementById('password').value = password;
}

// Add hover effect to demo accounts
document.addEventListener('DOMContentLoaded', function() {
    const demoAccounts = document.querySelectorAll('.demo-account');
    demoAccounts.forEach(account => {
        account.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#e9ecef';
            this.style.borderRadius = '4px';
            this.style.padding = '2px';
        });
        account.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
            this.style.borderRadius = '';
            this.style.padding = '';
        });
    });
});
</script>
@endsection

