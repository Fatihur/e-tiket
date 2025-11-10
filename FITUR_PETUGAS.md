# Fitur Input Data Petugas Tiket

Fitur lengkap untuk mengelola data petugas tiket dengan berbagai informasi detail dan hak akses yang dapat dikonfigurasi.

## 🎯 Fitur Utama

### 1. **Tambah Petugas Baru**
- **Form lengkap** dengan validasi server-side
- **Generate ID Pegawai otomatis** (PTK001, PTK002, dst.)
- **Password dengan konfirmasi** dan toggle visibility
- **Upload foto profil** (opsional)

### 2. **Data Pribadi**
- Nama lengkap
- Email (unique)
- No. telepon
- ID Pegawai (auto-generate atau manual)

### 3. **Data Pekerjaan**
- **Shift kerja**: Pagi (07:00-15:00), Siang (15:00-23:00), Malam (23:00-07:00), Full Time
- **Tanggal mulai kerja**
- **Catatan** tambahan

### 4. **Hak Akses (Permissions)**
- ✅ **Dapat melakukan scan tiket** - Izin akses ke QR scanner
- ✅ **Dapat melihat laporan scanning** - Akses ke laporan aktivitas
- ✅ **Status aktif/non-aktif** - Kontrol login petugas

### 5. **Manajemen Status**
- **Aktivasi/Deaktivasi** petugas
- **Soft delete** dengan proteksi data scanning
- **Update data** tanpa reset password

## 📊 Dashboard Petugas

### Statistik Real-time
- **Total petugas** terdaftar
- **Petugas aktif** saat ini
- **Scanning hari ini** dari semua petugas
- **Total scanning** keseluruhan

### Daftar Petugas
- **View tabel** dengan informasi lengkap
- **Search & filter** berdasarkan status
- **Aksi cepat**: Edit, Detail, Aktivasi, Hapus
- **Avatar** dengan inisial nama
- **Badge status** untuk shift dan aktivitas

## 🔧 Fungsi Lengkap

### Form Input Petugas (`/admin/petugas/create`)
```php
Route::get('/admin/petugas/create', [AdminController::class, 'petugasCreate']);
Route::post('/admin/petugas', [AdminController::class, 'petugasStore']);
```

**Validasi Input:**
- Name: Required, max 255 chars
- Email: Required, unique, valid email format
- Password: Required, min 8 chars, confirmed
- Employee ID: Optional, unique (auto-generate jika kosong)
- Phone: Optional, max 20 chars
- Shift: Optional, enum values
- Permissions: Boolean checkboxes

### Detail Petugas (`/admin/petugas/{id}`)
**Menampilkan:**
- ✅ Profile card dengan avatar
- ✅ Statistik scanning (hari ini, minggu, bulan, total)
- ✅ Informasi pribadi lengkap
- ✅ Informasi pekerjaan dan hak akses
- ✅ Riwayat scanning terakhir
- ✅ Quick actions (Edit, Aktivasi, Hapus)

### Edit Petugas (`/admin/petugas/{id}/edit`)
**Fitur:**
- ✅ Update semua data tanpa reset password
- ✅ Password optional (hanya jika diisi)
- ✅ Validasi unique email kecuali untuk user sendiri
- ✅ Toggle status aktif/non-aktif

### Manajemen Status
**Aktivasi:** `PATCH /admin/petugas/{id}/activate`
**Deaktivasi:** `PATCH /admin/petugas/{id}/deactivate`
**Hapus:** `DELETE /admin/petugas/{id}` (dengan proteksi data scanning)

## 💾 Database Schema

**Migration: `add_petugas_fields_to_users_table`**
```php
$table->string('employee_id')->nullable()->unique();
$table->string('phone')->nullable();
$table->enum('shift', ['pagi', 'siang', 'malam', 'full'])->nullable();
$table->date('start_date')->nullable();
$table->text('notes')->nullable();
$table->boolean('can_scan')->default(true);
$table->boolean('can_view_reports')->default(false);
```

## 🎨 UI/UX Features

### Responsive Design
- ✅ **Bootstrap 5** dengan grid system
- ✅ **Mobile-friendly** forms dan tables
- ✅ **Icon set** dari Remixicon

### Interactive Elements
- ✅ **Password toggle** show/hide
- ✅ **Dropdown actions** untuk setiap petugas
- ✅ **Modal confirmations** untuk delete/deactivate
- ✅ **Alert messages** untuk feedback

### Visual Indicators
- ✅ **Color-coded badges** untuk status dan shift
- ✅ **Avatar dengan inisial** nama petugas
- ✅ **Progress indicators** untuk statistik
- ✅ **Icon-based navigation** yang intuitive

## 🔐 Security Features

### Access Control
- ✅ **Role-based middleware** (hanya admin)
- ✅ **CSRF protection** pada semua forms
- ✅ **Input validation** server-side
- ✅ **Password hashing** dengan Laravel Hash

### Data Protection
- ✅ **Soft delete protection** - Petugas dengan riwayat scan tidak bisa dihapus
- ✅ **Unique constraints** pada email dan employee_id
- ✅ **Foreign key relationships** untuk data integrity

## 📱 Workflow Penggunaan

### 1. Admin Login
```
POST /login → Dashboard Admin
```

### 2. Kelola Petugas
```
GET /admin/petugas → Daftar Petugas
GET /admin/petugas/create → Form Tambah Petugas  
POST /admin/petugas → Simpan Petugas Baru
```

### 3. Monitor Aktivitas
```
GET /admin/petugas/{id} → Detail & Statistik Petugas
GET /admin/petugas/{id}/edit → Edit Data Petugas
PATCH /admin/petugas/{id} → Update Data
```

### 4. Control Status
```
PATCH /admin/petugas/{id}/activate → Aktifkan Petugas
PATCH /admin/petugas/{id}/deactivate → Non-aktifkan Petugas
DELETE /admin/petugas/{id} → Hapus Petugas
```

## ⚙️ Konfigurasi

### Auto-Generated Employee ID
Format: `PTK001`, `PTK002`, `PTK003`, ...
```php
public function generateEmployeeId()
{
    $prefix = 'PTK';
    $lastId = User::where('employee_id', 'LIKE', $prefix . '%')
                 ->orderBy('employee_id', 'desc')->first();
    
    $number = $lastId ? intval(substr($lastId->employee_id, 3)) + 1 : 1;
    return $prefix . str_pad($number, 3, '0', STR_PAD_LEFT);
}
```

### Shift Configuration
```php
$shifts = [
    'pagi' => 'Pagi (07:00 - 15:00)',
    'siang' => 'Siang (15:00 - 23:00)', 
    'malam' => 'Malam (23:00 - 07:00)',
    'full' => 'Full Time'
];
```

## 🚀 Testing

### Manual Testing Steps
1. **Create Petugas**: Test form validation, auto-generate ID
2. **View Detail**: Check statistik dan riwayat scanning
3. **Edit Data**: Update tanpa reset password
4. **Status Control**: Test activate/deactivate
5. **Delete Protection**: Coba hapus petugas dengan riwayat scan

### Sample Data
```php
// AdminSeeder sudah include sample petugas
User::create([
    'name' => 'Petugas Tiket',
    'email' => 'petugas@etiket.com',
    'password' => Hash::make('petugas123'),
    'role' => 'petugas',
    'employee_id' => 'PTK001',
    'shift' => 'pagi',
    'can_scan' => true,
    'is_active' => true,
]);
```

Fitur ini memberikan kontrol penuh kepada admin untuk mengelola tim petugas tiket dengan efisien dan professional! 🎫✨