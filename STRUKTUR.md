# Struktur Proyek Laravel Modernize

## Overview

Proyek ini menggunakan konsep **partial layout** untuk memisahkan komponen-komponen UI menjadi file-file Blade terpisah yang dapat digunakan kembali (reusable).

## Struktur Folder

```
laravel-modernize/
├── app/                          # Application logic
│   ├── Http/
│   │   └── Controllers/          # Controllers (kosong, menggunakan route closures)
│   └── Models/                   # Models
│
├── bootstrap/                    # Bootstrap framework
│
├── config/                       # Configuration files
│
├── database/                     # Database migrations, seeds, factories
│
├── public/                       # Public accessible folder
│   ├── index.php                 # Entry point
│   └── assets/                   # Frontend assets
│       ├── css/                  # Stylesheets
│       │   ├── styles.min.css
│       │   └── icons/
│       ├── js/                   # JavaScript files
│       │   ├── app.min.js
│       │   ├── sidebarmenu.js
│       │   └── dashboard.js
│       ├── images/               # Images
│       │   ├── logos/
│       │   ├── products/
│       │   ├── profile/
│       │   └── backgrounds/
│       ├── libs/                 # Third-party libraries
│       │   ├── bootstrap/
│       │   ├── jquery/
│       │   ├── apexcharts/
│       │   └── simplebar/
│       └── scss/                 # Source SCSS files
│           ├── styles.scss
│           ├── layouts/
│           ├── components/
│           └── utilities/
│
├── resources/                    # Resources (views, raw assets)
│   └── views/                    # Blade templates
│       ├── layouts/              # Layout templates
│       │   ├── app.blade.php     # Main layout (dengan sidebar)
│       │   └── auth.blade.php    # Auth layout (tanpa sidebar)
│       │
│       ├── partials/             # Partial components
│       │   ├── header.blade.php  # Header navbar
│       │   ├── sidebar.blade.php # Sidebar navigation
│       │   └── footer.blade.php  # Footer
│       │
│       ├── auth/                 # Authentication pages
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       │
│       ├── ui/                   # UI component pages
│       │   ├── buttons.blade.php
│       │   ├── alerts.blade.php
│       │   ├── card.blade.php
│       │   ├── forms.blade.php
│       │   └── typography.blade.php
│       │
│       ├── pages/                # Other pages
│       │   ├── icons.blade.php
│       │   └── sample-page.blade.php
│       │
│       └── dashboard.blade.php   # Dashboard main page
│
├── routes/                       # Route definitions
│   ├── web.php                   # Web routes
│   ├── api.php                   # API routes
│   └── console.php               # Console commands
│
├── storage/                      # Storage (logs, cache, uploads)
│
├── tests/                        # Testing files
│
├── vendor/                       # Composer dependencies
│
├── .env                          # Environment configuration
├── .env.example                  # Environment example
├── composer.json                 # PHP dependencies
├── artisan                       # Artisan CLI
├── README.md                     # Main documentation
├── INSTALL.md                    # Installation guide
└── STRUKTUR.md                   # This file
```

## Penjelasan Konsep Partial Layout

### 1. Main Layout (`layouts/app.blade.php`)

Layout utama yang berisi struktur HTML lengkap dengan sidebar dan header. Digunakan untuk semua halaman dashboard dan UI components.

**Struktur:**
```blade
<!DOCTYPE html>
<html>
<head>
    <!-- Meta tags & CSS -->
</head>
<body>
    <div class="page-wrapper">
        @include('partials.sidebar')
        
        <div class="body-wrapper">
            @include('partials.header')
            
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- Scripts -->
</body>
</html>
```

**Cara Pakai:**
```blade
@extends('layouts.app')

@section('title', 'Halaman Title')

@section('content')
    <!-- Konten halaman disini -->
@endsection
```

### 2. Auth Layout (`layouts/auth.blade.php`)

Layout khusus untuk halaman authentication tanpa sidebar, hanya menampilkan form di tengah layar.

**Cara Pakai:**
```blade
@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <!-- Form login/register disini -->
@endsection
```

### 3. Partial Components

#### Header (`partials/header.blade.php`)
Komponen header yang berisi:
- Toggle button untuk mobile sidebar
- Notification icon
- Profile dropdown menu

#### Sidebar (`partials/sidebar.blade.php`)
Komponen sidebar yang berisi:
- Logo aplikasi
- Navigation menu
- Promotional banner

Untuk menambah menu baru:
```blade
<li class="sidebar-item">
    <a class="sidebar-link" href="{{ route('your.route') }}" aria-expanded="false">
        <span>
            <i class="ti ti-icon-name"></i>
        </span>
        <span class="hide-menu">Menu Name</span>
    </a>
</li>
```

#### Footer (`partials/footer.blade.php`)
Komponen footer yang berisi copyright dan credits.

## Routing Convention

### Named Routes

Semua routes menggunakan named routes untuk memudahkan referensi:

```php
// Dashboard
Route::get('/', ...)->name('dashboard');

// UI Components (dengan prefix)
Route::prefix('ui')->name('ui.')->group(function () {
    Route::get('/buttons', ...)->name('buttons');  // route name: ui.buttons
});

// Auth (dengan prefix)
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/login', ...)->name('login');      // route name: auth.login
});
```

### Menggunakan Named Routes di Blade

```blade
<a href="{{ route('dashboard') }}">Dashboard</a>
<a href="{{ route('ui.buttons') }}">Buttons</a>
<a href="{{ route('auth.login') }}">Login</a>
```

## Asset Management

### Mengakses Assets

Gunakan helper `asset()` untuk mengakses file di folder `public/`:

```blade
<!-- CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">

<!-- JavaScript -->
<script src="{{ asset('assets/js/app.min.js') }}"></script>

<!-- Images -->
<img src="{{ asset('assets/images/logos/dark-logo.svg') }}" alt="Logo">
```

### Menambah CSS/JS per Halaman

Gunakan `@stack()` dan `@push()`:

**Di layout:**
```blade
<head>
    <!-- CSS global -->
    @stack('styles')
</head>
<body>
    <!-- Content -->
    @stack('scripts')
</body>
```

**Di halaman:**
```blade
@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('custom.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('custom.js') }}"></script>
@endpush

@section('content')
    <!-- Content -->
@endsection
```

## Best Practices

### 1. Gunakan Named Routes

✅ **Good:**
```blade
<a href="{{ route('dashboard') }}">Dashboard</a>
```

❌ **Bad:**
```blade
<a href="/dashboard">Dashboard</a>
```

### 2. Gunakan Asset Helper

✅ **Good:**
```blade
<img src="{{ asset('assets/images/logo.png') }}" alt="Logo">
```

❌ **Bad:**
```blade
<img src="/assets/images/logo.png" alt="Logo">
```

### 3. Pisahkan Logic dari View

Gunakan Controller untuk logic yang kompleks, bukan closure di routes.

### 4. Gunakan Blade Components

Untuk komponen yang sering dipakai, pertimbangkan membuat Blade Component:

```bash
php artisan make:component Alert
```

### 5. Naming Convention

- **Views**: `kebab-case.blade.php` (e.g., `sample-page.blade.php`)
- **Routes**: `kebab-case` (e.g., `/sample-page`)
- **Route Names**: `dot.notation` (e.g., `ui.buttons`)

## Customization Guide

### Menambah Halaman Baru

1. Buat view file di `resources/views/`
2. Tambahkan route di `routes/web.php`
3. Update sidebar menu di `partials/sidebar.blade.php` (jika perlu)

**Contoh:**

```php
// routes/web.php
Route::get('/new-page', function () {
    return view('pages.new-page');
})->name('new.page');
```

```blade
<!-- resources/views/pages/new-page.blade.php -->
@extends('layouts.app')

@section('title', 'New Page')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">New Page</h5>
            <p>Your content here...</p>
        </div>
    </div>
@endsection
```

```blade
<!-- partials/sidebar.blade.php -->
<li class="sidebar-item">
    <a class="sidebar-link" href="{{ route('new.page') }}" aria-expanded="false">
        <span>
            <i class="ti ti-file"></i>
        </span>
        <span class="hide-menu">New Page</span>
    </a>
</li>
```

## Libraries & Dependencies

### PHP Dependencies (Composer)
- Laravel Framework 12.x
- (Lihat `composer.json` untuk detail lengkap)

### Frontend Libraries
- Bootstrap 5.2.3
- jQuery 3.6.3
- ApexCharts 3.37.0
- Tabler Icons
- Simplebar

Semua library frontend sudah ter-bundle di folder `public/assets/libs/`

