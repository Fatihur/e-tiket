@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Edit Paket Wisata</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.packages') }}">Paket Wisata</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="ri-edit-line me-2"></i>Edit: {{ $package->name }}
                    </h4>
                </div>
                <div class="card-body">
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <h6>Terdapat kesalahan:</h6>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('admin.packages.update', $package->id) }}" method="POST" enctype="multipart/form-data" id="packageForm">
                        @csrf
                        @method('PATCH')

                        <!-- Informasi Dasar -->
                        <div class="mb-4">
                            <h5 class="mb-3">
                                <i class="ri-information-line me-2"></i>Informasi Dasar
                            </h5>
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Paket Wisata <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="{{ old('name', $package->name) }}" placeholder="Contoh: Paket Wisata Pantai Indah" required>
                                <small class="text-muted">Nama yang menarik dan mudah diingat pengunjung</small>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi Paket <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="description" name="description" rows="4" 
                                          placeholder="Deskripsikan pengalaman wisata yang akan didapatkan pengunjung..." required>{{ old('description', $package->description) }}</textarea>
                                <small class="text-muted">Jelaskan secara detail apa saja yang termasuk dalam paket ini</small>
                            </div>
                        </div>

                        <!-- Harga dan Kapasitas -->
                        <div class="mb-4">
                            <h5 class="mb-3">
                                <i class="ri-money-dollar-circle-line me-2"></i>Harga dan Kapasitas
                            </h5>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Harga per Orang <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" class="form-control" id="price" name="price" 
                                                   value="{{ old('price', $package->price) }}" min="0" step="1000" 
                                                   placeholder="50000" required>
                                        </div>
                                        <small class="text-muted">Harga dalam rupiah (tanpa titik atau koma)</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="max_capacity" class="form-label">Kapasitas Maksimal <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="max_capacity" name="max_capacity" 
                                                   value="{{ old('max_capacity', $package->max_capacity) }}" min="1" max="1000" 
                                                   placeholder="50" required>
                                            <span class="input-group-text">orang</span>
                                        </div>
                                        <small class="text-muted">Jumlah pengunjung maksimal per hari</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Current Stats -->
                            <div class="alert alert-info">
                                <div class="row">
                                    <div class="col-md-3">
                                        <strong>Total Booking:</strong><br>
                                        <span class="h5">{{ $package->bookings_count ?? 0 }}</span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Revenue:</strong><br>
                                        <span class="h5 text-success">Rp {{ number_format($package->total_revenue ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Rating:</strong><br>
                                        <span class="h5">⭐ 4.5/5</span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Status:</strong><br>
                                        @if($package->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                        @else
                                        <span class="badge bg-danger">Non-Aktif</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Fasilitas -->
                        <div class="mb-4">
                            <h5 class="mb-3">
                                <i class="ri-star-line me-2"></i>Fasilitas dan Fitur
                            </h5>
                            
                            <div class="mb-3">
                                <label for="facilities" class="form-label">Fasilitas yang Tersedia</label>
                                <textarea class="form-control" id="facilities" name="facilities" rows="3" 
                                          placeholder="Contoh: Toilet bersih, Musholla, Warung makan, Tempat parkir luas, Area bermain anak">{{ old('facilities', $package->facilities) }}</textarea>
                                <small class="text-muted">Pisahkan setiap fasilitas dengan koma atau enter</small>
                            </div>

                            <!-- Quick Facilities Buttons -->
                            <div class="mb-3">
                                <label class="form-label">Fasilitas Umum (Klik untuk menambah)</label>
                                <div class="d-flex flex-wrap gap-2">
                                    <button type="button" class="btn btn-outline-secondary btn-sm facility-btn" data-facility="Toilet bersih">Toilet</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm facility-btn" data-facility="Musholla">Musholla</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm facility-btn" data-facility="Warung makan">Warung Makan</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm facility-btn" data-facility="Tempat parkir">Parkir</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm facility-btn" data-facility="Area bermain anak">Area Bermain</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm facility-btn" data-facility="WiFi gratis">WiFi</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm facility-btn" data-facility="Guide profesional">Guide</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm facility-btn" data-facility="Spot foto Instagramable">Spot Foto</button>
                                </div>
                            </div>
                        </div>

                        <!-- Gambar -->
                        <div class="mb-4">
                            <h5 class="mb-3">
                                <i class="ri-image-line me-2"></i>Gambar Paket Wisata
                            </h5>
                            
                            <!-- Current Image -->
                            @if($package->image)
                            <div class="mb-3">
                                <label class="form-label">Gambar Saat Ini</label>
                                <div class="position-relative d-inline-block">
                                    <img src="{{ asset('storage/' . $package->image) }}" alt="{{ $package->name }}" 
                                         class="img-thumbnail" style="max-width: 300px; max-height: 200px;">
                                    <div class="position-absolute top-0 end-0 m-2">
                                        <label class="btn btn-sm btn-danger" for="remove_image">
                                            <i class="ri-delete-bin-line"></i>
                                        </label>
                                        <input type="checkbox" id="remove_image" name="remove_image" value="1" style="display: none;">
                                    </div>
                                </div>
                                <small class="d-block text-muted mt-1">Centang tombol merah untuk menghapus gambar</small>
                            </div>
                            @endif
                            
                            <div class="mb-3">
                                <label for="image" class="form-label">
                                    @if($package->image) Ganti Gambar @else Upload Gambar @endif
                                </label>
                                <input type="file" class="form-control" id="image" name="image" 
                                       accept="image/jpeg,image/png,image/jpg">
                                <small class="text-muted">Format: JPG, PNG, JPEG. Maksimal 2MB. Ukuran optimal: 800x600px</small>
                            </div>

                            <!-- New Image Preview -->
                            <div id="imagePreview" style="display: none;">
                                <label class="form-label">Preview Gambar Baru</label>
                                <img id="previewImg" src="#" alt="Preview" class="img-thumbnail d-block" style="max-width: 300px; max-height: 200px;">
                            </div>
                        </div>

                        <!-- Pengaturan -->
                        <div class="mb-4">
                            <h5 class="mb-3">
                                <i class="ri-settings-line me-2"></i>Pengaturan
                            </h5>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                               value="1" {{ old('is_active', $package->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            <strong>Paket Aktif</strong>
                                            <small class="d-block text-muted">Paket dapat dipesan oleh pengunjung</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="featured" name="featured" 
                                               value="1" {{ old('featured', $package->featured ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="featured">
                                            <strong>Paket Unggulan</strong>
                                            <small class="d-block text-muted">Ditampilkan di bagian atas website</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Danger Zone -->
                        @if($package->bookings_count == 0)
                        <div class="mb-4">
                            <div class="card border-danger">
                                <div class="card-header bg-danger text-white">
                                    <h6 class="mb-0"><i class="ri-alert-line me-2"></i>Zona Berbahaya</h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-2">Paket ini belum memiliki booking. Anda dapat menghapusnya jika tidak diperlukan.</p>
                                    <form action="{{ route('admin.packages.destroy', $package->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                onclick="return confirm('Yakin ingin menghapus paket ini? Aksi ini tidak dapat dibatalkan!')">
                                            <i class="ri-delete-bin-line me-1"></i>Hapus Paket
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="{{ route('admin.packages') }}" class="btn btn-light">
                                    <i class="ri-arrow-left-line me-1"></i>Kembali ke Daftar
                                </a>
                                <a href="{{ route('admin.packages.show', $package->id) }}" class="btn btn-outline-info">
                                    <i class="ri-eye-line me-1"></i>Lihat Detail
                                </a>
                            </div>
                            <div>
                                <button type="button" class="btn btn-outline-secondary me-2" onclick="resetToOriginal()">
                                    <i class="ri-refresh-line me-1"></i>Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ri-save-line me-1"></i>Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Store original values for reset
const originalValues = {
    name: '{{ $package->name }}',
    description: '{{ $package->description }}',
    price: '{{ $package->price }}',
    max_capacity: '{{ $package->max_capacity }}',
    facilities: '{{ $package->facilities }}',
    is_active: {{ $package->is_active ? 'true' : 'false' }},
    featured: {{ ($package->featured ?? false) ? 'true' : 'false' }}
};

// Facility buttons
document.querySelectorAll('.facility-btn').forEach(button => {
    button.addEventListener('click', function() {
        const facility = this.dataset.facility;
        const facilitiesTextarea = document.getElementById('facilities');
        const currentValue = facilitiesTextarea.value;
        
        if (currentValue) {
            facilitiesTextarea.value = currentValue + ', ' + facility;
        } else {
            facilitiesTextarea.value = facility;
        }
        
        this.classList.add('btn-success');
        this.classList.remove('btn-outline-secondary');
        
        setTimeout(() => {
            this.classList.remove('btn-success');
            this.classList.add('btn-outline-secondary');
        }, 1000);
    });
});

// Image preview
document.getElementById('image').addEventListener('change', function() {
    const file = this.files[0];
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
});

// Remove image checkbox
document.getElementById('remove_image').addEventListener('change', function() {
    const label = this.previousElementSibling;
    if (this.checked) {
        label.classList.remove('btn-danger');
        label.classList.add('btn-success');
        label.innerHTML = '<i class="ri-check-line"></i>';
    } else {
        label.classList.remove('btn-success');
        label.classList.add('btn-danger');
        label.innerHTML = '<i class="ri-delete-bin-line"></i>';
    }
});

// Reset to original function
function resetToOriginal() {
    if (confirm('Yakin ingin mereset ke data asli? Semua perubahan akan hilang.')) {
        document.getElementById('name').value = originalValues.name;
        document.getElementById('description').value = originalValues.description;
        document.getElementById('price').value = originalValues.price;
        document.getElementById('max_capacity').value = originalValues.max_capacity;
        document.getElementById('facilities').value = originalValues.facilities;
        document.getElementById('is_active').checked = originalValues.is_active;
        document.getElementById('featured').checked = originalValues.featured;
        document.getElementById('image').value = '';
        document.getElementById('imagePreview').style.display = 'none';
        document.getElementById('remove_image').checked = false;
        
        // Reset remove image button
        const removeLabel = document.querySelector('label[for="remove_image"]');
        removeLabel.classList.remove('btn-success');
        removeLabel.classList.add('btn-danger');
        removeLabel.innerHTML = '<i class="ri-delete-bin-line"></i>';
    }
}
</script>
@endsection