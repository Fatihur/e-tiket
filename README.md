# 🎫 E-Tiket Wisata Lapade

Sistem pemesanan tiket online berbasis web untuk tempat wisata dengan fitur QR Code validation dan multi-role management.

![Laravel](https://img.shields.io/badge/Laravel-12.x-red)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue)
![License](https://img.shields.io/badge/License-MIT-green)

## 📖 Tentang Aplikasi

E-Tiket Wisata Lapade adalah aplikasi manajemen pemesanan tiket wisata yang memungkinkan:
- **Pengunjung** melakukan booking online dan mendapat tiket QR Code via email
- **Admin** mengelola paket wisata, validasi booking, dan generate tiket
- **Petugas** memvalidasi tiket pengunjung dengan QR Code scanner
- **Bendahara** memonitor dan memverifikasi transaksi keuangan
- **Owner** melihat laporan dan analisis bisnis

## ✨ Fitur Utama

### 🌐 Landing Page (Public)
- ✅ Katalog paket wisata dengan foto dan deskripsi
- ✅ Form booking online tanpa registrasi
- ✅ Upload bukti pembayaran
- ✅ Halaman konfirmasi booking
- ✅ Responsive design untuk mobile

### 👨‍💼 Admin Dashboard
- ✅ Manajemen user (Admin, Petugas, Bendahara, Owner)
- ✅ Manajemen paket wisata (CRUD dengan upload gambar)
- ✅ Manajemen petugas tiket dengan detail lengkap
- ✅ Validasi booking (approve/reject)
- ✅ Generate tiket QR Code otomatis
- ✅ Kirim tiket via email
- ✅ Laporan penjualan (harian, mingguan, bulanan)
- ✅ Dashboard dengan statistik lengkap
- ✅ Filter dan pencarian

### 🎫 Petugas Tiket Dashboard
- ✅ QR Code scanner dengan kamera
- ✅ Validasi tiket real-time
- ✅ Cek status tiket (sudah digunakan/belum)
- ✅ Validasi tanggal kunjungan
- ✅ Riwayat scanning
- ✅ Dashboard statistik scanning
- ✅ Prevent duplicate scanning

### 💰 Bendahara Dashboard
- ✅ Daftar transaksi confirmed
- ✅ Verifikasi transaksi multiple
- ✅ Laporan keuangan (harian/mingguan/bulanan/tahunan)
- ✅ Grafik pendapatan bulanan
- ✅ Dashboard overview keuangan

### 📊 Owner Dashboard
- ✅ Dashboard eksekutif dengan grafik
- ✅ Laporan penjualan komprehensif
- ✅ Analisis performa paket wisata
- ✅ Monitor pengunjung dan pendapatan
- ✅ Grafik 12 bulan terakhir
- ✅ Export laporan

## 🛠️ Teknologi yang Digunakan

### Backend
- **Laravel 12.x** - PHP Framework
- **PHP 8.2+** - Programming Language
- **SQLite/MySQL** - Database
- **Laravel Mail** - Email Service
- **SimpleSoftwareIO QR Code** - QR Code Generator

### Frontend
- **Bootstrap 5** - CSS Framework
- **jQuery** - JavaScript Library
- **Chart.js** - Data Visualization
- **HTML5 QR Code Scanner** - QR Scanning
- **Tabler Icons** - Icon Library

## 📦 Instalasi

### Persyaratan Sistem
- PHP >= 8.2
- Composer 2.x
- Node.js >= 18.x (optional)
- SQLite/MySQL
- Web Server (Apache/Nginx) atau PHP built-in server

### Langkah Instalasi

1. **Clone Repository**
```bash
git clone <repository-url> e-tiket
cd e-tiket
```

2. **Install Dependencies**
```bash
composer install
```

3. **Setup Environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Konfigurasi Database**

Edit file `.env`:
```env
DB_CONNECTION=sqlite
# atau untuk MySQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_DATABASE=etiket_lapade
```

5. **Run Migrations & Seeders**
```bash
php artisan migrate
php artisan db:seed --class=AdminSeeder
```

6. **Setup Storage**
```bash
php artisan storage:link
```

7. **Jalankan Aplikasi**
```bash
php artisan serve
```

Aplikasi akan berjalan di: `http://localhost:8000`

📚 **Dokumentasi Lengkap**: Lihat [PANDUAN_INSTALASI.md](PANDUAN_INSTALASI.md)

## 🔐 Default Login

| Role | Email | Password |
|------|-------|----------|
| **Admin** | admin@etiket.com | admin123 |
| **Petugas** | petugas@etiket.com | petugas123 |
| **Bendahara** | bendahara@etiket.com | bendahara123 |
| **Owner** | owner@etiket.com | owner123 |

⚠️ **Penting**: Ubah password default setelah instalasi!

## 📱 Cara Penggunaan

### Flow Umum Sistem

```
1. Pengunjung → Booking di Landing Page
2. Upload Bukti Transfer
3. Admin → Validasi & Approve Booking
4. Sistem → Generate QR Code & Kirim Email
5. Pengunjung → Datang ke Wisata
6. Petugas → Scan QR Code
7. Tiket Tervalidasi (Tidak bisa digunakan lagi)
```

### Panduan Detail

Untuk panduan lengkap penggunaan setiap role, lihat: [PANDUAN_PENGGUNAAN.md](PANDUAN_PENGGUNAAN.md)

## 📁 Struktur Project

```
e-tiket/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php
│   │   │   ├── AuthController.php
│   │   │   ├── BendaharaController.php
│   │   │   ├── LandingController.php
│   │   │   ├── OwnerController.php
│   │   │   └── PetugasController.php
│   │   └── Middleware/
│   │       └── CheckRole.php
│   ├── Mail/
│   │   └── TicketEmail.php
│   └── Models/
│       ├── Booking.php
│       ├── Ticket.php
│       ├── User.php
│       └── WisataPackage.php
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── database.sqlite
├── resources/
│   └── views/
│       ├── admin/
│       ├── bendahara/
│       ├── emails/
│       ├── landing/
│       ├── layouts/
│       ├── owner/
│       └── petugas/
├── routes/
│   └── web.php
└── public/
    └── assets/
```

## 🔒 Keamanan

- ✅ Role-based access control dengan middleware
- ✅ CSRF protection pada semua forms
- ✅ Password hashing dengan bcrypt
- ✅ File upload validation
- ✅ SQL injection protection (Eloquent ORM)
- ✅ XSS protection
- ✅ User authentication & authorization
- ✅ Active/inactive user status check

## 🌟 Fitur Unggulan

### 1. QR Code Validation
- Generate unique QR code untuk setiap tiket
- One-time use (tidak bisa di-scan ulang)
- Validasi tanggal kunjungan
- Real-time validation feedback

### 2. Email Notification
- Otomatis kirim tiket via email setelah approved
- HTML email template yang menarik
- Include QR code dan detail booking
- Instruksi penggunaan jelas

### 3. Multi-Role Dashboard
- Dashboard khusus untuk setiap role
- Statistik real-time
- Grafik dan visualisasi data
- Responsive dan user-friendly

### 4. Laporan Lengkap
- Laporan penjualan per periode
- Analisis paket wisata
- Export data (dalam pengembangan)
- Grafik trend penjualan

## 🧪 Testing

### Manual Testing
1. **Test Landing Page**: Booking paket wisata
2. **Test Admin**: Validasi booking & generate tiket
3. **Test Email**: Cek email untuk menerima tiket
4. **Test Petugas**: Scan QR Code tiket
5. **Test Bendahara**: Verifikasi transaksi
6. **Test Owner**: Lihat laporan

### Test Data
Seeder sudah menyediakan:
- 4 default users
- 4 paket wisata contoh

## 📝 Database Schema

### Users
- Menyimpan data semua user (admin, petugas, bendahara, owner)
- Fields: role, is_active, employee_id, phone, shift, dll

### Wisata Packages
- Menyimpan data paket wisata
- Fields: name, description, price, max_capacity, image, facilities

### Bookings
- Menyimpan data pemesanan
- Fields: booking_code, visitor_*, visit_date, quantity, total_amount, payment_proof, status

### Tickets
- Menyimpan data tiket
- Fields: ticket_code, booking_id, qr_code, is_used, used_at, scanned_by

## 🐛 Troubleshooting

### Email tidak terkirim?
- Cek konfigurasi MAIL di `.env`
- Untuk Gmail, gunakan App Password
- Pastikan firewall tidak memblokir SMTP

### QR Scanner tidak berfungsi?
- Berikan izin akses kamera
- Gunakan HTTPS di production
- Cek koneksi internet

### Error "storage link"?
```bash
php artisan storage:link
chmod -R 775 storage
```

Lihat troubleshooting lengkap di [PANDUAN_INSTALASI.md](PANDUAN_INSTALASI.md)

## 📈 Roadmap

- [ ] Export laporan ke Excel/PDF
- [ ] Payment gateway integration
- [ ] WhatsApp notification
- [ ] Mobile app (Flutter/React Native)
- [ ] Multi-language support
- [ ] Advanced analytics
- [ ] Booking reminder via email

## 🤝 Kontribusi

Kontribusi sangat diterima! Silakan:
1. Fork project ini
2. Buat feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📄 Lisensi

Aplikasi ini menggunakan lisensi MIT. Lihat file [LICENSE](LICENSE) untuk detail.

## 👥 Tim Pengembang

Dikembangkan dengan ❤️ untuk Wisata Lapade

## 📞 Kontak & Support

- **Email**: support@wisatalapade.com
- **WhatsApp**: +62 812-3456-7890
- **Website**: https://wisatalapade.com

---

**⭐ Jika aplikasi ini bermanfaat, berikan star di repository ini!**

---

## 📚 Dokumentasi Tambahan

- [Panduan Instalasi Lengkap](PANDUAN_INSTALASI.md)
- [Panduan Penggunaan](PANDUAN_PENGGUNAAN.md)
- [Struktur Aplikasi](STRUKTUR.md)

---

Made with ❤️ using Laravel
