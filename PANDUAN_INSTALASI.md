# 📖 Panduan Instalasi - E-Tiket Wisata Lapade

## 📋 Daftar Isi
1. [Persyaratan Sistem](#persyaratan-sistem)
2. [Instalasi](#instalasi)
3. [Konfigurasi](#konfigurasi)
4. [Menjalankan Aplikasi](#menjalankan-aplikasi)
5. [Default Login](#default-login)
6. [Troubleshooting](#troubleshooting)

---

## 💻 Persyaratan Sistem

Sebelum memulai instalasi, pastikan sistem Anda memenuhi persyaratan berikut:

### Minimum Requirements:
- **PHP**: >= 8.2
- **Composer**: 2.x
- **Node.js**: >= 18.x
- **NPM**: >= 9.x
- **Database**: SQLite (default) / MySQL / PostgreSQL
- **Web Server**: Apache / Nginx (opsional, bisa menggunakan PHP built-in server)

### PHP Extensions (Required):
- BCMath
- Ctype
- cURL
- DOM
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- PDO_SQLite (jika menggunakan SQLite)
- Tokenizer
- XML
- GD atau Imagick (untuk manipulasi gambar)

---

## 🚀 Instalasi

### 1. Clone atau Download Repository

```bash
# Jika menggunakan Git
git clone <repository-url> e-tiket
cd e-tiket

# Atau extract jika menggunakan ZIP
unzip e-tiket.zip
cd e-tiket
```

### 2. Install Dependencies PHP

```bash
composer install
```

Jika ada error, coba:
```bash
composer install --ignore-platform-reqs
```

### 3. Install Dependencies JavaScript (Opsional)

```bash
npm install
```

### 4. Setup Environment File

```bash
# Windows
copy .env.example .env

# Linux/Mac
cp .env.example .env
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

---

## ⚙️ Konfigurasi

### 1. Edit File `.env`

Buka file `.env` dan sesuaikan konfigurasi:

#### Database Configuration (SQLite - Default)
```env
DB_CONNECTION=sqlite
# DB_DATABASE akan otomatis menggunakan database/database.sqlite
```

#### Database Configuration (MySQL - Optional)
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=etiket_lapade
DB_USERNAME=root
DB_PASSWORD=
```

#### Application Settings
```env
APP_NAME="E-Tiket Wisata Lapade"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
```

#### Mail Configuration
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@wisatalapade.com
MAIL_FROM_NAME="${APP_NAME}"
```

> **Catatan**: Untuk Gmail, gunakan App Password bukan password biasa.
> Cara membuat App Password: https://support.google.com/accounts/answer/185833

### 2. Create Database (SQLite sudah included)

Jika menggunakan SQLite, file database sudah tersedia di `database/database.sqlite`.

Jika menggunakan MySQL, buat database baru:
```sql
CREATE DATABASE etiket_lapade CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 3. Run Migrations

```bash
php artisan migrate
```

Jika ada error atau ingin fresh install:
```bash
php artisan migrate:fresh
```

### 4. Seed Database dengan Data Awal

```bash
php artisan db:seed --class=AdminSeeder
```

Seeder ini akan membuat:
- 4 users default (Admin, Petugas, Bendahara, Owner)
- 4 paket wisata contoh

### 5. Setup Storage Link

```bash
php artisan storage:link
```

Command ini membuat symbolic link dari `public/storage` ke `storage/app/public` untuk akses file upload.

### 6. Set Permissions (Linux/Mac)

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

---

## 🏃 Menjalankan Aplikasi

### Development Mode

#### Menggunakan PHP Built-in Server (Recommended untuk Development)

```bash
php artisan serve
```

Aplikasi akan berjalan di: `http://localhost:8000`

Untuk mengubah port:
```bash
php artisan serve --port=8080
```

#### Menggunakan Laravel Vite Dev Server (Optional untuk Asset Development)

Jika Anda mengembangkan frontend:

Terminal 1:
```bash
php artisan serve
```

Terminal 2:
```bash
npm run dev
```

### Production Mode

#### Menggunakan Apache

1. Arahkan Document Root ke folder `public`
2. Enable mod_rewrite
3. Konfigurasi `.htaccess` sudah tersedia

#### Menggunakan Nginx

Contoh konfigurasi Nginx:
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/e-tiket/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

---

## 🔐 Default Login

### Administrator
- **URL**: http://localhost:8000/login
- **Email**: admin@etiket.com
- **Password**: admin123

### Petugas Tiket
- **Email**: petugas@etiket.com
- **Password**: petugas123

### Bendahara
- **Email**: bendahara@etiket.com
- **Password**: bendahara123

### Owner
- **Email**: owner@etiket.com
- **Password**: owner123

> **⚠️ PENTING**: Segera ubah password default setelah instalasi!

---

## 🧪 Testing Aplikasi

### 1. Test Landing Page
1. Buka `http://localhost:8000`
2. Pilih paket wisata
3. Klik "Booking Sekarang"
4. Isi form booking dan upload bukti transfer
5. Submit booking

### 2. Test Admin
1. Login sebagai admin
2. Buka menu "Booking"
3. Validasi booking yang baru dibuat
4. Approve booking
5. Cek email pengunjung untuk menerima tiket

### 3. Test Petugas
1. Login sebagai petugas
2. Buka menu "Scanner"
3. Scan QR Code dari tiket yang sudah dikirim
4. Verifikasi tiket berhasil discan

### 4. Test Bendahara
1. Login sebagai bendahara
2. Lihat daftar transaksi
3. Verifikasi laporan

### 5. Test Owner
1. Login sebagai owner
2. Lihat dashboard dengan grafik
3. Lihat laporan lengkap
4. Analisis paket wisata

---

## 🔧 Troubleshooting

### Error: "No application encryption key has been specified"
```bash
php artisan key:generate
```

### Error: "SQLSTATE[HY000] [14] unable to open database file"
```bash
touch database/database.sqlite
chmod 664 database/database.sqlite
```

### Error: "The stream or file could not be opened"
```bash
chmod -R 775 storage bootstrap/cache
```

### Error: "Class 'PDO' not found"
Install PHP PDO extension:
```bash
# Ubuntu/Debian
sudo apt-get install php8.2-sqlite3

# Windows
# Enable extension di php.ini:
extension=pdo_sqlite
```

### Error: "npm install" gagal
```bash
# Hapus node_modules dan package-lock.json
rm -rf node_modules package-lock.json

# Install ulang
npm install
```

### Email tidak terkirim
1. Pastikan konfigurasi MAIL di `.env` sudah benar
2. Jika menggunakan Gmail, aktifkan "Less secure app access" atau gunakan App Password
3. Cek firewall yang mungkin memblokir port SMTP

### QR Code tidak muncul di email
1. Pastikan koneksi internet aktif (menggunakan external QR code service)
2. Atau implementasikan QR code library local

### Upload gambar error
```bash
php artisan storage:link
chmod -R 775 storage/app/public
```

---

## 📚 Perintah Artisan Berguna

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Clear all caches at once
php artisan optimize:clear

# Fresh migration (hapus semua data)
php artisan migrate:fresh --seed

# Rollback migration
php artisan migrate:rollback

# Check routes
php artisan route:list

# Run queue worker (jika menggunakan queue)
php artisan queue:work
```

---

## 🚀 Tips Deployment Production

1. **Set APP_ENV dan APP_DEBUG**
   ```env
   APP_ENV=production
   APP_DEBUG=false
   ```

2. **Optimize Application**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

3. **Set Proper Permissions**
   ```bash
   chmod -R 755 storage bootstrap/cache
   ```

4. **Use Queue for Email**
   Set `QUEUE_CONNECTION=database` di .env dan jalankan:
   ```bash
   php artisan queue:work --daemon
   ```

5. **Enable HTTPS**
   Update APP_URL di .env:
   ```env
   APP_URL=https://yourdomain.com
   ```

6. **Backup Database Regularly**
   ```bash
   # SQLite
   cp database/database.sqlite database/backup_$(date +%Y%m%d).sqlite
   
   # MySQL
   mysqldump -u root -p etiket_lapade > backup_$(date +%Y%m%d).sql
   ```

---

## 📞 Support

Jika mengalami kesulitan saat instalasi, hubungi:
- Email: support@wisatalapade.com
- WhatsApp: +62 812-3456-7890

---

**Selamat menggunakan Aplikasi E-Tiket Wisata Lapade! 🎉**

