# Panduan Instalasi Laravel Modernize

## Persyaratan Sistem

- PHP >= 8.2
- Composer
- Node.js & NPM (opsional, untuk kompilasi assets jika diperlukan)

## Langkah Instalasi

### 1. Install Dependencies

```bash
composer install
```

### 2. Setup Environment

Copy file `.env.example` menjadi `.env`:

```bash
# Windows
copy .env.example .env

# Linux/Mac
cp .env.example .env
```

### 3. Generate Application Key

```bash
php artisan key:generate
```

### 4. Setup Database (Opsional)

Jika Anda ingin menggunakan database, edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_modernize
DB_USERNAME=root
DB_PASSWORD=
```

Kemudian jalankan migrasi:

```bash
php artisan migrate
```

### 5. Jalankan Development Server

```bash
php artisan serve
```

Aplikasi akan berjalan di: `http://localhost:8000`

## Struktur URL

Setelah aplikasi berjalan, Anda dapat mengakses halaman-halaman berikut:

### Dashboard & Main Pages
- **Dashboard**: http://localhost:8000/
- **Sample Page**: http://localhost:8000/sample-page
- **Icons**: http://localhost:8000/icons

### UI Components
- **Buttons**: http://localhost:8000/ui/buttons
- **Alerts**: http://localhost:8000/ui/alerts
- **Cards**: http://localhost:8000/ui/card
- **Forms**: http://localhost:8000/ui/forms
- **Typography**: http://localhost:8000/ui/typography

### Authentication
- **Login**: http://localhost:8000/auth/login
- **Register**: http://localhost:8000/auth/register

## Troubleshooting

### Error: "No application encryption key has been specified"

Jalankan:
```bash
php artisan key:generate
```

### Error: "Class 'X' not found"

Jalankan:
```bash
composer dump-autoload
```

### Assets tidak muncul

Pastikan folder `public/assets` berisi semua file CSS, JS, dan images dari template original.

### Port 8000 sudah digunakan

Gunakan port lain:
```bash
php artisan serve --port=8080
```

## Customization

### Mengubah Judul Aplikasi

Edit file `.env`:
```env
APP_NAME="Your App Name"
```

### Mengubah Logo

Ganti file di:
- `public/assets/images/logos/dark-logo.svg` - Logo di sidebar
- `public/assets/images/logos/favicon.png` - Favicon

### Menambah Menu Sidebar

Edit file `resources/views/partials/sidebar.blade.php`

### Mengubah Warna Tema

Edit file `public/assets/css/styles.min.css` atau compile dari SCSS di `public/assets/scss/`

## Deployment

### Production Setup

1. Set environment ke production di `.env`:
```env
APP_ENV=production
APP_DEBUG=false
```

2. Optimize aplikasi:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3. Set permission untuk storage dan bootstrap/cache:
```bash
chmod -R 775 storage bootstrap/cache
```

## Support

Untuk pertanyaan atau issue, silakan buat issue di repository ini.

