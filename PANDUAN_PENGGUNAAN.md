# 📱 Panduan Penggunaan - E-Tiket Wisata Lapade

## 📋 Daftar Isi
1. [Alur Sistem](#alur-sistem)
2. [Panduan untuk Admin](#panduan-untuk-admin)
3. [Panduan untuk Petugas Tiket](#panduan-untuk-petugas-tiket)
4. [Panduan untuk Bendahara](#panduan-untuk-bendahara)
5. [Panduan untuk Owner](#panduan-untuk-owner)
6. [Panduan untuk Pengunjung](#panduan-untuk-pengunjung)

---

## 🔄 Alur Sistem

```
[Pengunjung] 
    ↓ Booking & Upload Bukti Transfer
[Admin]
    ↓ Validasi & Generate Tiket QR Code
[Email]
    ↓ Kirim Tiket ke Pengunjung
[Pengunjung]
    ↓ Datang ke Wisata dengan QR Code
[Petugas]
    ↓ Scan QR Code
[Tiket Tervalidasi]
    ↓ Data Transaksi
[Bendahara] ← Verifikasi Laporan
    ↓
[Owner] ← Monitor & Analisis
```

---

## 👨‍💼 Panduan untuk Admin

### Login
1. Buka `http://localhost:8000/login`
2. Masukkan email: `admin@etiket.com`
3. Masukkan password: `admin123`
4. Klik "Login"

### Dashboard
Setelah login, Anda akan melihat:
- **Total Booking**: Jumlah semua booking
- **Booking Pending**: Booking yang menunggu validasi
- **Booking Confirmed**: Booking yang sudah disetujui
- **Total Pendapatan**: Total dari booking confirmed
- **Daftar Booking Terbaru**

### Manajemen User

#### Melihat Daftar User
1. Klik menu **"User"** di sidebar
2. Akan muncul daftar semua user dengan informasi:
   - Nama
   - Email
   - Role
   - Status (Aktif/Tidak Aktif)
   - Last Login

#### Menambah User Baru
1. Klik tombol **"Tambah User"**
2. Isi form:
   - Nama Lengkap
   - Email
   - Role (Admin/Petugas/Bendahara/Owner)
   - Password (min 8 karakter)
   - Konfirmasi Password
3. Klik **"Simpan"**

#### Menonaktifkan User
1. Di daftar user, klik icon **⚠️** (warning) pada user yang ingin dinonaktifkan
2. Konfirmasi aksi
3. User akan dinonaktifkan dan tidak bisa login

#### Mengaktifkan User
1. Di daftar user, klik icon **✓** (check) pada user yang ingin diaktifkan
2. Konfirmasi aksi
3. User dapat login kembali

### Manajemen Paket Wisata

#### Melihat Daftar Paket
1. Klik menu **"Paket Wisata"** di sidebar
2. Akan muncul daftar paket dengan:
   - Foto paket
   - Nama paket
   - Harga
   - Kapasitas
   - Total booking
   - Status (Aktif/Tidak Aktif)

#### Menambah Paket Wisata Baru
1. Klik tombol **"Tambah Paket"**
2. Isi form:
   - Nama Paket *
   - Deskripsi *
   - Harga (Rp) *
   - Kapasitas Maksimal *
   - Fasilitas (pisahkan dengan koma)
   - Upload Gambar (max 2MB, format: jpg/png/jpeg)
   - Centang "Featured" jika ingin ditampilkan di halaman utama
   - Centang "Status Aktif" jika ingin langsung aktif
3. Klik **"Simpan"**

#### Mengedit Paket Wisata
1. Di detail paket atau daftar paket, klik **"Edit"**
2. Ubah informasi yang diperlukan
3. Klik **"Simpan Perubahan"**

#### Menonaktifkan Paket
1. Di detail paket, klik **"Nonaktifkan"**
2. Paket tidak akan muncul di halaman booking publik

#### Menghapus Paket
1. Di detail paket, klik **"Hapus"**
2. **CATATAN**: Paket yang sudah memiliki booking tidak bisa dihapus

### Manajemen Petugas

#### Melihat Daftar Petugas
1. Klik menu **"Petugas"** di sidebar
2. Akan muncul daftar petugas dengan:
   - ID Karyawan
   - Nama
   - Email
   - Shift
   - Total Scan
   - Status

#### Menambah Petugas Baru
1. Klik tombol **"Tambah Petugas"**
2. Isi form:
   - Nama Lengkap *
   - Email *
   - Password *
   - ID Karyawan (auto-generate jika kosong)
   - No. Telepon
   - Shift (Pagi/Siang/Malam/Full Time)
   - Tanggal Mulai
   - Catatan
   - Izin Scan (default: Ya)
   - Izin Lihat Laporan (default: Tidak)
3. Klik **"Simpan"**

#### Mengedit Petugas
1. Di daftar petugas, klik nama petugas atau **"Detail"**
2. Klik **"Edit"**
3. Ubah informasi yang diperlukan
4. Klik **"Simpan Perubahan"**

### Manajemen Booking

#### Melihat Daftar Booking
1. Klik menu **"Booking"** di sidebar
2. Gunakan filter untuk:
   - Status (Pending/Confirmed/Rejected/Expired)
   - Tanggal Kunjungan
   - Pencarian (Nama/Email/Kode Booking)

#### Validasi Booking (Approve)
1. Klik **"Detail"** pada booking yang ingin divalidasi
2. Cek informasi booking dan bukti pembayaran
3. Jika valid:
   - Isi catatan (opsional)
   - Klik **"Setujui Booking"**
4. Sistem akan:
   - Generate tiket dengan QR Code
   - Kirim tiket ke email pengunjung
   - Update status menjadi "Confirmed"

#### Menolak Booking (Reject)
1. Klik **"Detail"** pada booking
2. Klik **"Tolak Booking"**
3. Isi alasan penolakan *
4. Klik **"Tolak Booking"**
5. Status akan berubah menjadi "Rejected"

### Laporan Penjualan

#### Melihat Laporan
1. Klik menu **"Laporan"** di sidebar
2. Pilih periode:
   - Hari Ini / Kemarin
   - Minggu Ini / Minggu Lalu
   - Bulan Ini / Bulan Lalu
   - Tahun Ini
   - Custom (pilih tanggal)
3. Filter tambahan:
   - Paket Wisata
   - Status Booking

#### Informasi Laporan
- Total Penjualan
- Total Pendapatan
- Total Pengunjung
- Tiket Terpakai
- Rata-rata Transaksi
- Grafik Pendapatan
- Grafik Transaksi
- Breakdown per Paket

#### Export Laporan
Klik **"Export"** untuk download laporan (fitur dalam pengembangan)

---

## 🎫 Panduan untuk Petugas Tiket

### Login
1. Buka `http://localhost:8000/login`
2. Masukkan email petugas
3. Masukkan password
4. Klik "Login"

### Dashboard
Melihat informasi:
- Scan Hari Ini
- Total Scan
- Tiket Pending (yang belum digunakan)

### Scanning Tiket

#### Menggunakan Scanner QR Code
1. Klik menu **"Scanner"** atau tombol **"Buka Scanner"**
2. Berikan izin akses kamera jika diminta
3. Arahkan kamera ke QR Code tiket pengunjung
4. Sistem akan otomatis memvalidasi:
   - ✅ **Valid**: Tiket bisa digunakan
   - ❌ **Invalid**: Tiket sudah digunakan, expired, atau tidak valid
5. Hasil scan akan ditampilkan

#### Status Validasi Tiket
- **Berhasil**: Tiket valid dan bisa masuk
- **Sudah Digunakan**: Tiket pernah di-scan sebelumnya
- **Tanggal Tidak Valid**: Tiket tidak berlaku untuk hari ini
- **Booking Belum Dikonfirmasi**: Menunggu validasi admin
- **Tidak Ditemukan**: QR Code tidak valid

### Melihat Riwayat Scan
1. Klik menu **"Riwayat Scan"**
2. Akan muncul daftar:
   - Kode Tiket
   - Booking Code
   - Nama Pengunjung
   - Paket Wisata
   - Waktu Scan
   - Petugas yang Scan

---

## 💰 Panduan untuk Bendahara

### Login
1. Buka `http://localhost:8000/login`
2. Masukkan email: `bendahara@etiket.com`
3. Masukkan password: `bendahara123`

### Dashboard
Melihat informasi:
- Total Pendapatan (semua waktu)
- Pendapatan Hari Ini
- Pending Verifikasi
- Transaksi Terverifikasi

### Melihat Transaksi
1. Klik menu **"Transaksi"**
2. Akan muncul daftar semua transaksi confirmed:
   - Tanggal
   - Kode Booking
   - Pengunjung
   - Paket
   - Total Pembayaran
   - Status Verifikasi

### Verifikasi Transaksi
1. Di halaman Transaksi
2. Centang transaksi yang ingin diverifikasi
3. Atau klik **"Pilih Semua"** untuk semua transaksi
4. Klik **"Verifikasi Terpilih"**
5. Konfirmasi verifikasi

### Laporan Keuangan
1. Klik menu **"Laporan"**
2. Melihat:
   - Pendapatan Harian
   - Pendapatan Mingguan
   - Pendapatan Bulanan
   - Pendapatan Tahunan
   - Grafik per Bulan

---

## 📊 Panduan untuk Owner

### Login
1. Buka `http://localhost:8000/login`
2. Masukkan email: `owner@etiket.com`
3. Masukkan password: `owner123`

### Dashboard Eksekutif
Melihat overview bisnis:
- Total Pendapatan (lifetime)
- Total Pengunjung
- Paket Aktif
- Booking Pending
- **Grafik Pendapatan** 12 bulan terakhir
- **Grafik Pengunjung** 12 bulan terakhir

### Laporan Penjualan
1. Klik menu **"Laporan"**
2. Pilih periode:
   - Harian (30 hari terakhir)
   - Mingguan (12 minggu terakhir)
   - Bulanan (12 bulan terakhir)
3. Melihat tabel dengan:
   - Periode
   - Pendapatan
   - Jumlah Pengunjung
   - Total

### Analisis Paket Wisata
1. Klik menu **"Analisis Paket"**
2. Melihat performa setiap paket:
   - Foto paket
   - Nama & Deskripsi
   - Total Booking
   - Total Pendapatan
   - Harga
   - Status

---

## 🌐 Panduan untuk Pengunjung (Public)

### Booking Tiket

#### 1. Pilih Paket Wisata
1. Buka `http://localhost:8000`
2. Lihat daftar paket wisata yang tersedia
3. Klik **"Lihat Detail"** atau **"Booking"** pada paket yang diinginkan

#### 2. Isi Form Booking
Lengkapi form dengan:
- **Nama Lengkap** *
- **Email** * (untuk menerima tiket)
- **No. Telepon** *
- **Tanggal Kunjungan** * (minimal H+1)
- **Jumlah Pengunjung** *
- **Upload Bukti Transfer** * (max 2MB, format: jpg/png/jpeg)

#### 3. Informasi Pembayaran
Transfer ke rekening:
```
Bank BCA
No. Rek: 1234567890
A.n: Wisata Lapade
```

Total: Harga × Jumlah Pengunjung

#### 4. Submit Booking
1. Pastikan semua data sudah benar
2. Klik **"Booking Sekarang"**
3. Akan muncul halaman konfirmasi dengan **Kode Booking**
4. **SIMPAN** kode booking Anda

#### 5. Menunggu Validasi
- Admin akan memvalidasi pembayaran Anda (1×24 jam)
- Cek email secara berkala
- Jika approved, tiket QR Code akan dikirim ke email

#### 6. Menerima Tiket
Email berisi:
- Detail booking
- QR Code tiket (1 QR per orang)
- Instruksi penggunaan
- Kode tiket

**SIMPAN email atau download QR Code**

#### 7. Berkunjung
1. Datang sesuai tanggal yang dipesan
2. Tunjukkan QR Code ke petugas
3. Petugas akan scan QR Code
4. Masuk dan nikmati wisata! 🎉

---

## ❓ FAQ (Frequently Asked Questions)

### Untuk Pengunjung

**Q: Apakah bisa booking untuk hari ini?**
A: Tidak, booking minimal H+1 (besok)

**Q: Berapa lama proses validasi?**
A: Maksimal 1×24 jam kerja

**Q: Jika pembayaran tidak valid?**
A: Booking akan ditolak dan Anda akan menerima notifikasi

**Q: Bisa refund jika tidak jadi berkunjung?**
A: Tidak, tiket tidak dapat direfund atau ditukar

**Q: QR Code hilang, bagaimana?**
A: Hubungi admin untuk kirim ulang tiket

**Q: Bisa reschedule tanggal kunjungan?**
A: Hubungi admin untuk request perubahan

### Untuk Admin/Petugas

**Q: Tiket bisa di-scan berapa kali?**
A: Hanya 1 kali per tiket

**Q: Jika scan tidak berhasil?**
A: Cek koneksi internet, pastikan QR Code jelas

**Q: Bisa validate booking tanpa bukti transfer?**
A: Tidak recommended, tapi admin bisa override

---

## 🔔 Tips Penggunaan

### Untuk Admin
✅ Cek bukti transfer secara detail sebelum approve
✅ Gunakan catatan untuk komunikasi dengan pengunjung
✅ Monitor booking pending secara rutin
✅ Backup database secara berkala

### Untuk Petugas
✅ Pastikan kamera dalam kondisi baik
✅ Cahaya yang cukup saat scanning
✅ Minta pengunjung menunjukkan QR Code dengan jelas
✅ Cek nama pengunjung untuk validasi tambahan

### Untuk Bendahara
✅ Verifikasi transaksi secara berkala
✅ Cross-check dengan bukti transfer
✅ Export laporan untuk arsip

### Untuk Owner
✅ Monitor tren penjualan
✅ Analisis paket mana yang paling laris
✅ Tentukan strategi promosi berdasarkan data

### Untuk Pengunjung
✅ Booking jauh-jauh hari untuk kepastian
✅ Transfer segera setelah booking
✅ Simpan QR Code offline (screenshot/print)
✅ Datang tepat waktu sesuai jadwal

---

## 📞 Bantuan & Support

Jika mengalami kesulitan:

**Email**: support@wisatalapade.com
**WhatsApp**: +62 812-3456-7890
**Jam Operasional**: 08:00 - 17:00 WIB

---

**Selamat menggunakan dan menikmati wisata! 🎊**

