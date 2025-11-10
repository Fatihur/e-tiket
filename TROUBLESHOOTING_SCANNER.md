# Troubleshooting QR Scanner

## Masalah Umum dan Solusi

### 1. Scanner Tidak Muncul / Kamera Tidak Aktif

**Kemungkinan Penyebab:**
- Browser tidak memiliki akses ke kamera
- Kamera sedang digunakan aplikasi lain
- Website tidak diakses via HTTPS (di production)
- Browser tidak support kamera API

**Solusi:**
1. **Izinkan Akses Kamera:**
   - Ketika browser meminta izin kamera, klik "Allow/Izinkan"
   - Jika sudah di-block, klik icon kunci/gembok di address bar
   - Ubah permission kamera menjadi "Allow"
   - Refresh halaman (F5)

2. **Pastikan Kamera Tidak Digunakan:**
   - Tutup aplikasi lain yang menggunakan kamera (Zoom, Teams, Skype, dll)
   - Tutup tab browser lain yang menggunakan kamera

3. **Browser Compatibility:**
   - **Rekomendasi:** Chrome, Firefox, Edge (versi terbaru)
   - **Tidak Support:** Internet Explorer
   - Update browser ke versi terbaru

4. **HTTPS di Production:**
   - Kamera API hanya berfungsi di HTTPS atau localhost
   - Di production, pastikan website menggunakan SSL certificate

### 2. QR Code Tidak Terbaca

**Kemungkinan Penyebab:**
- QR Code kabur atau rusak
- Pencahayaan kurang
- Jarak terlalu jauh/dekat
- QR Code terlalu kecil

**Solusi:**
1. **Perbaiki Pencahayaan:**
   - Pastikan ada cahaya yang cukup
   - Hindari backlight yang terlalu terang
   - Gunakan lampu tambahan jika perlu

2. **Atur Jarak:**
   - Jaga jarak 15-20 cm dari kamera
   - QR Code harus dalam kotak biru di scanner

3. **Pastikan QR Code Jelas:**
   - Print dengan kualitas tinggi
   - Hindari lipatan atau kusut
   - Jangan ada refleksi atau kilauan

4. **Gunakan Input Manual:**
   - Klik tombol "Input Manual"
   - Copy-paste data QR Code
   - Klik "Proses Data"

### 3. Error "Tiket Tidak Valid"

**Kemungkinan Penyebab:**
- Booking belum di-approve admin
- Tanggal kunjungan tidak sesuai
- Tiket sudah pernah di-scan
- Data QR Code corrupt

**Solusi:**
1. **Cek Status Booking:**
   - Login sebagai Admin
   - Buka menu "Booking"
   - Pastikan status "Confirmed"

2. **Cek Tanggal Kunjungan:**
   - Tiket hanya berlaku di tanggal yang dipilih
   - Jika tanggal salah, hubungi admin

3. **Tiket Sudah Digunakan:**
   - Setiap tiket hanya bisa di-scan 1x
   - Cek riwayat di "Tiket Tervalidasi"

### 4. Scanner Lambat / Freeze

**Solusi:**
1. **Refresh Halaman:**
   - Tekan F5 atau refresh browser
   - Clear browser cache (Ctrl+Shift+Delete)

2. **Restart Browser:**
   - Tutup semua tab browser
   - Buka kembali dan login

3. **Cek Koneksi Internet:**
   - Pastikan koneksi stabil
   - Test dengan ping website

4. **Gunakan Device Lain:**
   - Coba di HP/tablet
   - Gunakan browser berbeda

### 5. Testing Scanner

**Cara Test dengan Benar:**

1. **Generate Test Booking:**
   ```
   - Login sebagai Admin
   - Buka menu "Booking"
   - Pilih booking dengan status "Pending"
   - Klik "Setujui Booking"
   - Sistem akan generate QR Code
   ```

2. **Lihat QR Code:**
   ```
   - Klik detail booking yang sudah approved
   - Di bagian "Tiket yang Digenerate"
   - Klik tombol "Lihat QR" pada tiket
   - QR Code akan muncul di modal
   ```

3. **Test Scan:**
   ```
   - Login sebagai Petugas
   - Buka menu "Scanner QR Code"
   - Arahkan kamera ke QR Code di modal
   - Atau gunakan Input Manual dengan copy data QR
   ```

4. **Verifikasi Hasil:**
   ```
   - Jika berhasil: Alert hijau + Detail tiket muncul
   - Jika gagal: Alert merah + Pesan error
   ```

## Debugging dengan Console

Buka Developer Console (F12) untuk melihat log:

```javascript
// Log yang muncul saat scanner berjalan normal:
"Page loaded, initializing scanner..."
"Scanner initialized successfully"
"QR Code detected: {ticket_code:...}"
"Processing QR Data: ..."
"Response status: 200"
"Response data: {success: true, ...}"
```

**Jika ada error, cari pesan:**
- `Permission denied` → Kamera di-block
- `NotFoundError` → Kamera tidak ditemukan
- `NotAllowedError` → User menolak akses kamera
- `NetworkError` → Masalah koneksi

## Konfigurasi Server

### Development (Laravel Serve)
```bash
php artisan serve --host=0.0.0.0 --port=8000
```
Akses: `http://localhost:8000`

### Production
- **Wajib HTTPS** untuk akses kamera
- Setup SSL certificate (Let's Encrypt, Cloudflare, dll)
- Pastikan firewall tidak block port 443

## Browser Settings

### Chrome
1. `chrome://settings/content/camera`
2. Tambahkan website ke "Allow"
3. Restart browser

### Firefox
1. `about:preferences#privacy`
2. Scroll ke "Permissions"
3. Camera → Settings
4. Allow untuk website

### Edge
1. `edge://settings/content/camera`
2. Allow untuk website

## Tips Optimal

1. **Gunakan Smartphone untuk Scanner:**
   - Kamera lebih baik dari laptop
   - Lebih mobile dan fleksibel

2. **Print QR Code Ukuran 5x5 cm:**
   - Tidak terlalu kecil
   - Mudah di-scan

3. **Test Sebelum Event:**
   - Buat test booking
   - Scan beberapa tiket
   - Pastikan email terkirim

4. **Backup Plan:**
   - Selalu ada "Input Manual"
   - Catat kode tiket manual jika scanner bermasalah

## Kontak Support

Jika masalah masih berlanjut:
1. Screenshot error/pesan
2. Buka Developer Console (F12)
3. Screenshot console log
4. Hubungi developer dengan info lengkap

---

**Update Terakhir:** 9 November 2025

