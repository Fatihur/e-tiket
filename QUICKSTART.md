# Quick Start Guide

Panduan cepat untuk memulai proyek Laravel Modernize.

## 🚀 Quick Install (5 menit)

```bash
# 1. Masuk ke folder proyek
cd laravel-modernize

# 2. Install dependencies
composer install

# 3. Setup environment
copy .env.example .env

# 4. Generate key
php artisan key:generate

# 5. Jalankan server
php artisan serve
```

Buka browser: **http://localhost:8000**

## 📱 Halaman Yang Tersedia

### Main Pages
| URL | Deskripsi |
|-----|-----------|
| `/` | Dashboard dengan charts |
| `/sample-page` | Contoh halaman sederhana |
| `/icons` | Daftar Tabler Icons |

### UI Components (`/ui/*`)
| URL | Deskripsi |
|-----|-----------|
| `/ui/buttons` | Button components |
| `/ui/alerts` | Alert components |
| `/ui/card` | Card components |
| `/ui/forms` | Form components |
| `/ui/typography` | Typography examples |

### Authentication (`/auth/*`)
| URL | Deskripsi |
|-----|-----------|
| `/auth/login` | Login page |
| `/auth/register` | Register page |

## 🎨 Customization Cepat

### Ubah Logo
Ganti file:
```
public/assets/images/logos/dark-logo.svg
public/assets/images/logos/favicon.png
```

### Tambah Menu Sidebar
Edit file: `resources/views/partials/sidebar.blade.php`

```blade
<li class="sidebar-item">
    <a class="sidebar-link" href="{{ route('your.route') }}">
        <span><i class="ti ti-icon"></i></span>
        <span class="hide-menu">Menu Name</span>
    </a>
</li>
```

### Buat Halaman Baru

**1. Buat View** (`resources/views/pages/my-page.blade.php`):
```blade
@extends('layouts.app')

@section('title', 'My Page')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">My Page</h5>
            <p>Content here...</p>
        </div>
    </div>
@endsection
```

**2. Tambah Route** (`routes/web.php`):
```php
Route::get('/my-page', function () {
    return view('pages.my-page');
})->name('my.page');
```

**3. Tambah ke Sidebar** (opsional):
```blade
<li class="sidebar-item">
    <a class="sidebar-link" href="{{ route('my.page') }}">
        <span><i class="ti ti-file"></i></span>
        <span class="hide-menu">My Page</span>
    </a>
</li>
```

## 📖 Struktur Folder Penting

```
laravel-modernize/
├── public/assets/          # CSS, JS, Images
├── resources/views/
│   ├── layouts/            # Layout templates
│   ├── partials/           # Header, Sidebar, Footer
│   ├── auth/               # Login, Register
│   ├── ui/                 # UI component pages
│   ├── pages/              # Other pages
│   └── dashboard.blade.php # Main dashboard
└── routes/web.php          # Route definitions
```

## 🔗 Useful Links

- [README.md](README.md) - Dokumentasi lengkap
- [INSTALL.md](INSTALL.md) - Panduan instalasi detail
- [STRUKTUR.md](STRUKTUR.md) - Penjelasan struktur folder

## 💡 Tips

### Development
```bash
# Clear cache
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# List semua routes
php artisan route:list

# Optimize untuk production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Debugging
- Set `APP_DEBUG=true` di `.env` untuk development
- Cek log di `storage/logs/laravel.log`
- Gunakan `dd()` untuk debugging

## ❓ Troubleshooting Cepat

**Server error 500:**
```bash
php artisan key:generate
composer dump-autoload
```

**Assets tidak muncul:**
- Pastikan folder `public/assets` ada dan berisi file
- Cek permission folder: `chmod -R 755 public/assets`

**Route not found:**
```bash
php artisan route:list
php artisan route:clear
```

## 🎯 Next Steps

1. ✅ Install Laravel - **DONE**
2. ✅ Setup environment - **DONE**
3. ✅ Test halaman - Buka http://localhost:8000
4. 📝 Customize template sesuai kebutuhan
5. 🔐 Implement authentication logic (opsional)
6. 💾 Setup database (opsional)
7. 🚀 Deploy ke production

## 📞 Need Help?

- Baca [dokumentasi lengkap](README.md)
- Check [struktur folder](STRUKTUR.md)
- Review [changelog](CHANGELOG.md)

Happy coding! 🎉

