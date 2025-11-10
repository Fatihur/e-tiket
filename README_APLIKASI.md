# Aplikasi E-Tiket Wisata

Aplikasi pemesanan tiket online untuk wisata dengan sistem role-based access dan QR Code validation.

## 🚀 Fitur Utama

### Landing Page (Public)
- Tampilan daftar paket wisata
- Form pemesanan tiket online
- Upload bukti transfer
- Responsive design

### Role-based Dashboard

#### 1. Admin (Super Admin)
- **Login & Authentication**: Username dan password
- **Manajemen User**: CRUD petugas, bendahara, owner
- **Manajemen Paket Wisata**: CRUD paket wisata dengan gambar dan fasilitas
- **Validasi Booking**: Approve/reject pemesanan, generate tiket QR Code
- **Laporan**: Penjualan harian, mingguan, bulanan
- **Monitoring**: Pantau semua transaksi tiket masuk

#### 2. Petugas Tiket
- **Login & Authentication**: Username dan password  
- **QR Code Scanner**: Scan tiket di pintu masuk dengan kamera/manual input
- **Validasi Real-time**: Cek status tiket, tanggal kunjungan, duplikasi
- **Riwayat Scan**: Lihat data tiket yang telah divalidasi
- **Dashboard**: Statistik scanning harian

#### 3. Bendahara
- **Login & Authentication**: Username dan password
- **Laporan Transaksi**: View semua transaksi yang sudah confirmed
- **Verifikasi Laporan**: Validasi laporan penjualan yang dibuat sistem
- **Dashboard Keuangan**: Overview pendapatan dan statistik

#### 4. Owner / Pemilik Wisata
- **Login & Authentication**: Username dan password
- **Laporan Komprehensif**: Harian, mingguan, bulanan dengan chart
- **Monitor Pengunjung**: Jumlah pengunjung dan pendapatan
- **Analisis Paket**: Performa setiap paket wisata
- **Dashboard Eksekutif**: Overview lengkap bisnis wisata

## 🔄 Flow Aplikasi

1. **Pengunjung** mengakses landing page website (tanpa login)
2. **Pilih Paket** wisata yang tersedia
3. **Isi Form Booking** dengan data lengkap (nama, email, phone, tanggal kunjungan, jumlah)
4. **Upload Bukti Transfer** pembayaran
5. **Admin** mengecek transaksi dan validasi pembayaran
6. **Generate Tiket** dengan QR Code dikirim via email (jika approved)
7. **Pengunjung** datang ke tempat wisata dengan tiket digital
8. **Petugas** scan QR Code tiket di pintu masuk
9. **Tiket Tervalidasi** dan tidak bisa digunakan lagi

## 🛠 Teknologi

- **Framework**: Laravel 12.x
- **Database**: SQLite (development), MySQL (production)
- **QR Code**: SimpleSoftwareIO QR Code
- **Frontend**: Bootstrap 5, jQuery
- **QR Scanner**: HTML5 QR Code Scanner
- **Authentication**: Laravel built-in Auth

## 📋 Database Schema

### Users
- id, name, email, password, role, is_active, timestamps

### Wisata Packages  
- id, name, description, price, max_capacity, image, facilities, is_active, timestamps

### Bookings
- id, booking_code, wisata_package_id, visitor_name, visitor_email, visitor_phone
- visit_date, quantity, total_amount, payment_proof, status, validated_by, validated_at, notes, timestamps

### Tickets
- id, ticket_code, booking_id, qr_code, is_used, used_at, scanned_by, timestamps

## 🔐 Default Users

```
Admin:
- Email: admin@etiket.com
- Password: admin123

Petugas:  
- Email: petugas@etiket.com
- Password: petugas123

Bendahara:
- Email: bendahara@etiket.com  
- Password: bendahara123

Owner:
- Email: owner@etiket.com
- Password: owner123
```

## 📱 Instalasi & Setup

1. **Clone atau setup project Laravel**
```bash
cd laravel-modernize
```

2. **Install dependencies**
```bash
composer install
```

3. **Setup environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Jalankan migrations**
```bash
php artisan migrate
```

5. **Jalankan seeder untuk data awal**
```bash
php artisan db:seed --class=AdminSeeder
```

6. **Setup storage link untuk upload files**
```bash
php artisan storage:link
```

7. **Jalankan aplikasi**
```bash
php artisan serve
```

Akses aplikasi di `http://localhost:8000`

## 🗂 Struktur File Penting

```
app/
├── Models/
│   ├── User.php (dengan role methods)
│   ├── WisataPackage.php
│   ├── Booking.php
│   └── Ticket.php (dengan QR generation)
├── Http/Controllers/
│   ├── LandingController.php (public pages)
│   ├── AdminController.php (admin functions)
│   ├── PetugasController.php (QR scanner)
│   ├── BendaharaController.php (financial reports)
│   └── OwnerController.php (executive dashboard)

resources/views/
├── landing/ (public pages)
├── admin/ (admin dashboard & forms)
├── petugas/ (scanner interface)
├── bendahara/ (financial views)
└── owner/ (executive reports)

routes/
└── web.php (all application routes)
```

## 🔧 Konfigurasi Tambahan

### Email Configuration (Opsional)
Untuk mengirim tiket via email, setup SMTP di `.env`:
```
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_FROM_ADDRESS=noreply@yourdomain.com
```

### File Upload
Pastikan folder `storage/app/public` writable untuk upload:
- Payment proofs: `storage/app/public/payment-proofs/`
- Package images: `storage/app/public/packages/`

## 🎯 Testing

### Manual Testing Flow:
1. Buka landing page, pilih paket wisata
2. Isi form booking dan upload bukti transfer
3. Login sebagai admin, approve booking
4. Cek email untuk tiket QR Code (atau lihat di database)
5. Login sebagai petugas, test QR scanner
6. Login sebagai bendahara/owner, cek laporan

### QR Code Testing:
- Format QR berisi: `{"ticket_code":"xxx","booking_id":1,"visitor_name":"xxx","visit_date":"2024-xx-xx"}`
- Test dengan QR generator online atau dari tiket asli

## 🚨 Security Notes

1. **File Upload Validation**: Hanya terima image files untuk payment proof
2. **QR Code Validation**: Cek format, status booking, tanggal kunjungan
3. **Role-based Access**: Middleware untuk setiap controller
4. **CSRF Protection**: Aktif pada semua forms
5. **Input Validation**: Server-side validation pada semua inputs

## 📞 Support

Aplikasi ini dirancang untuk:
- Tempat wisata skala kecil hingga menengah
- Sistem booking online sederhana
- Validasi tiket real-time
- Multi-role management

Untuk pengembangan lebih lanjut, bisa ditambahkan:
- Payment gateway integration
- Email automation
- Mobile app
- Advanced analytics
- Multi-language support