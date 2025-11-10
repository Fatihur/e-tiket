# Cara Test Scanner QR Code

## ✅ Yang Sudah Diperbaiki:

### 1. **Scanner QR Code**
- ✅ Error handling yang lebih robust
- ✅ Console logging untuk debugging
- ✅ Prevention untuk multiple scan bersamaan
- ✅ Auto-hide result setelah 10 detik
- ✅ Dukungan Input Manual jika kamera bermasalah
- ✅ Instruksi lengkap di halaman scanner

### 2. **Tampilan QR Code**
- ✅ Tombol "Lihat QR" di halaman detail booking
- ✅ Modal pop-up untuk menampilkan QR Code
- ✅ QR Code ukuran 256x256 px
- ✅ Display data QR untuk debugging

### 3. **Dokumentasi**
- ✅ TROUBLESHOOTING_SCANNER.md
- ✅ Instruksi lengkap di halaman scanner
- ✅ Tips dan perhatian untuk petugas

---

## 📋 Langkah-Langkah Test Scanner

### **STEP 1: Start Server & Database**

```bash
# Terminal 1 - Start MySQL
# Pastikan MySQL/MariaDB sudah running

# Terminal 2 - Start Laravel
cd D:\ORDER\TIA\e-tiket
php artisan serve
```

Akses: http://127.0.0.1:8000

---

### **STEP 2: Buat Test Booking (sebagai Pengunjung)**

1. Buka browser: http://127.0.0.1:8000
2. Klik tombol **"Pesan Tiket"** atau lihat paket wisata
3. Pilih paket wisata, isi form:
   - Nama: Test Pengunjung
   - Email: test@email.com
   - Telepon: 081234567890
   - Tanggal Kunjungan: **Pilih hari ini** (PENTING!)
   - Jumlah: 2 orang
4. Upload bukti pembayaran (gambar apa saja)
5. Klik **"Booking Sekarang"**
6. Catat **Kode Booking** yang muncul

---

### **STEP 3: Approve Booking (sebagai Admin)**

1. Login sebagai Admin:
   - Email: admin@wisatalapade.com
   - Password: password

2. Klik menu **"Booking"** di sidebar

3. Cari booking test tadi (status: Pending)

4. Klik tombol **"Lihat Detail"**

5. Klik tombol **"Setujui Booking"**
   - Catatan: (opsional)
   - Klik **"Setujui Booking"**

6. Sistem akan:
   - ✅ Generate 2 tiket (sesuai quantity)
   - ✅ Generate QR Code untuk setiap tiket
   - ✅ Kirim email ke test@email.com (jika email sudah dikonfigurasi)
   - ✅ Update status jadi "Confirmed"

---

### **STEP 4: Lihat QR Code**

1. Masih di halaman detail booking yang sama

2. Scroll ke bagian **"Tiket yang Digenerate"**

3. Akan ada tabel dengan kolom:
   - Kode Tiket
   - Status
   - Waktu Scan
   - **Aksi** → Tombol "Lihat QR"

4. Klik tombol **"Lihat QR"** pada tiket pertama

5. Modal akan muncul dengan:
   - QR Code berukuran 256x256
   - Data QR dalam format JSON

6. **Biarkan modal ini terbuka** (jangan tutup dulu)

---

### **STEP 5: Test Scanner (sebagai Petugas)**

#### **Opsi A: Scan dengan Kamera**

1. Buka **tab baru** di browser (jangan tutup tab admin)

2. Login sebagai Petugas:
   - Email: petugas@wisatalapade.com
   - Password: password

3. Klik menu **"Scanner QR Code"** di sidebar

4. Browser akan minta **akses kamera**:
   - Klik **"Allow"** / **"Izinkan"**

5. Scanner akan aktif (ada kotak biru untuk QR)

6. **Cara Scan:**
   - **Komputer:** Arahkan layar modal QR (tab admin) ke webcam
   - **Smartphone:** 
     - Buka tab admin di HP lain
     - Tampilkan QR Code
     - Scan dengan HP petugas

7. **Hasil yang Diharapkan:**
   ```
   ✅ Alert Hijau: "Berhasil! Tiket berhasil discan!"
   ✅ Detail Tiket Muncul:
      - Kode Tiket: T-xxx
      - Nama Pengunjung: Test Pengunjung
      - Paket Wisata: (nama paket)
      - Tanggal Kunjungan: 09/11/2025
      - Waktu Scan: 09/11/2025 20:30:00
   ```

#### **Opsi B: Input Manual (Jika Kamera Bermasalah)**

1. Di halaman Scanner, klik tombol **"Input Manual"**

2. Kembali ke tab Admin, copy **data QR** dari modal (text di bawah QR Code)
   ```json
   {"ticket_code":"T-1-1-abc123","booking_id":1,"visitor_name":"Test Pengunjung","visit_date":"2025-11-09"}
   ```

3. Paste di textarea "Input Manual"

4. Klik **"Proses Data"**

5. Hasil akan sama seperti scan dengan kamera

---

### **STEP 6: Verifikasi**

1. **Cek Console Browser (F12):**
   ```
   ✅ "Page loaded, initializing scanner..."
   ✅ "Scanner initialized successfully"
   ✅ "QR Code detected: {..."
   ✅ "Processing QR Data: ..."
   ✅ "Response status: 200"
   ✅ "Response data: {success: true, ...}"
   ```

2. **Cek Database:**
   ```sql
   SELECT * FROM tickets WHERE ticket_code = 'T-xxx';
   -- is_used: 1
   -- used_at: 2025-11-09 20:30:00
   -- scanned_by: (ID petugas)
   ```

3. **Coba Scan Lagi Tiket yang Sama:**
   ```
   ❌ Alert Merah: "Tiket sudah pernah digunakan pada 09/11/2025 20:30:00"
   ```

4. **Scan Tiket Kedua:**
   ```
   ✅ Akan berhasil karena tiket kedua belum di-scan
   ```

---

## 🔧 Troubleshooting

### **1. Kamera Tidak Muncul**

**Cek Console (F12):**
```
Error: "NotAllowedError: Permission denied"
```

**Solusi:**
1. Klik icon **kunci/gembok** di address bar
2. Ubah Camera permission ke **"Allow"**
3. Refresh halaman (F5)

**Atau:**
1. Chrome: `chrome://settings/content/camera`
2. Tambahkan `http://127.0.0.1:8000` ke "Allow"

### **2. QR Code Tidak Terbaca**

**Solusi:**
- Pastikan QR Code jelas dan tidak blur
- Atur jarak 15-20 cm
- Tingkatkan pencahayaan
- Gunakan **Input Manual** sebagai backup

### **3. Error "Tiket tidak berlaku untuk hari ini"**

**Penyebab:** Tanggal kunjungan tidak sama dengan hari ini

**Solusi:**
- Saat membuat booking, pilih **tanggal hari ini**
- Atau ubah tanggal sistem komputer untuk testing

### **4. Error "Booking belum dikonfirmasi"**

**Penyebab:** Booking belum di-approve admin

**Solusi:**
- Login sebagai admin
- Approve booking dulu
- Baru bisa di-scan

---

## 📱 Test di Production (HTTPS)

Jika deploy ke server production:

1. **Wajib HTTPS:**
   ```
   ❌ http://domain.com  → Kamera tidak akan jalan
   ✅ https://domain.com → Kamera OK
   ```

2. **SSL Certificate:**
   - Let's Encrypt (gratis)
   - Cloudflare SSL
   - Provider hosting biasanya sediakan

3. **Browser Permissions:**
   - User harus allow camera access
   - HTTPS domain akan muncul di trusted list

---

## 🎯 Checklist Test Lengkap

- [ ] Browser bisa akses kamera
- [ ] Scanner muncul dengan kotak biru
- [ ] QR Code bisa di-generate di admin
- [ ] Modal QR Code muncul saat klik "Lihat QR"
- [ ] Scanner bisa baca QR Code
- [ ] Alert sukses muncul setelah scan
- [ ] Detail tiket ditampilkan dengan benar
- [ ] Tiket yang sama tidak bisa di-scan 2x
- [ ] Input manual berfungsi
- [ ] Console tidak ada error

---

## 📧 Konfigurasi Email (Opsional)

Jika ingin test email tiket:

1. Login sebagai Admin
2. Klik menu **"Pengaturan"**
3. Tab **"Konfigurasi Email"**
4. Isi dengan Gmail:
   ```
   Host: smtp.gmail.com
   Port: 587
   Encryption: tls
   Username: email@gmail.com
   Password: (App Password Gmail - bukan password biasa)
   ```
5. Test dengan tombol **"Kirim Test Email"**
6. Jika berhasil, email tiket akan otomatis terkirim saat approve booking

---

## 💡 Tips Development

1. **Test dengan 2 Device:**
   - Laptop: Admin (tampilkan QR)
   - HP: Petugas (scan QR)

2. **Print QR Code:**
   - Screenshot QR dari modal
   - Print ukuran 5x5 cm
   - Scan printed QR

3. **Multiple Petugas:**
   - Buat beberapa akun petugas
   - Test concurrent scanning
   - Cek di "Tiket Tervalidasi"

4. **Test Berbagai Skenario:**
   - ✅ Tiket valid hari ini
   - ❌ Tiket tanggal besok
   - ❌ Tiket sudah digunakan
   - ❌ Tiket booking pending
   - ❌ QR Code rusak/invalid

---

**Selamat Testing! 🚀**

Jika ada kendala, buka **TROUBLESHOOTING_SCANNER.md** atau cek console browser (F12) untuk error details.

