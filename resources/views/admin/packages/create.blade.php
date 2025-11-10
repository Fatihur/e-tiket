@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Tambah Paket Wisata</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.packages') }}">Paket Wisata</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
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
                        <i class="ri-gift-line me-2"></i>Form Tambah Paket Wisata
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

                    <form action="{{ route('admin.packages.store') }}" method="POST" enctype="multipart/form-data" id="packageForm">
                        @csrf

                        <!-- Informasi Dasar -->
                        <div class="mb-4">
                            <h5 class="mb-3">
                                <i class="ri-information-line me-2"></i>Informasi Dasar
                            </h5>
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Paket Wisata <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="{{ old('name') }}" placeholder="Contoh: Paket Wisata Pantai Indah" required>
                                <small class="text-muted">Nama yang menarik dan mudah diingat pengunjung</small>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi Paket <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="description" name="description" rows="4" 
                                          placeholder="Deskripsikan pengalaman wisata yang akan didapatkan pengunjung..." required>{{ old('description') }}</textarea>
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
                                                   value="{{ old('price') }}" min="0" step="1000" 
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
                                                   value="{{ old('max_capacity') }}" min="1" max="1000" 
                                                   placeholder="50" required>
                                            <span class="input-group-text">orang</span>
                                        </div>
                                        <small class="text-muted">Jumlah pengunjung maksimal per hari</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Price Preview -->
                            <div class="alert alert-info" id="pricePreview" style="display: none;">
                                <i class="ri-information-line me-2"></i>
                                <span id="priceText"></span>
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
                                          placeholder="Contoh: Toilet bersih, Musholla, Warung makan, Tempat parkir luas, Area bermain anak">{{ old('facilities') }}</textarea>
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
                            
                            <div class="mb-3">
                                <label for="image" class="form-label">Upload Gambar</label>
                                <input type="file" class="form-control" id="image" name="image" 
                                       accept="image/jpeg,image/png,image/jpg">
                                <small class="text-muted">Format: JPG, PNG, JPEG. Maksimal 2MB. Ukuran optimal: 800x600px</small>
                            </div>

                            <!-- Image Preview -->
                            <div id="imagePreview" style="display: none;">
                                <img id="previewImg" src="#" alt="Preview" class="img-thumbnail" style="max-width: 300px; max-height: 200px;">
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
                                               value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            <strong>Paket Aktif</strong>
                                            <small class="d-block text-muted">Paket dapat dipesan oleh pengunjung</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="featured" name="featured" 
                                               value="1" {{ old('featured') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="featured">
                                            <strong>Paket Unggulan</strong>
                                            <small class="d-block text-muted">Ditampilkan di bagian atas website</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Preview Section -->
                        <div class="mb-4">
                            <h5 class="mb-3">
                                <i class="ri-eye-line me-2"></i>Preview Paket
                            </h5>
                            <div class="card bg-light" id="packagePreview">
                                <div class="card-body">
                                    <h6 class="text-muted mb-2">Pratinjau akan muncul saat Anda mengisi form</h6>
                                    <p class="text-muted mb-0">Paket akan ditampilkan seperti ini di website</p>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="text-end">
                            <a href="{{ route('admin.packages') }}" class="btn btn-light me-2">
                                <i class="ri-arrow-left-line me-1"></i>Batal
                            </a>
                            <button type="button" class="btn btn-outline-secondary me-2" onclick="resetForm()">
                                <i class="ri-refresh-line me-1"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-save-line me-1"></i>Simpan Paket Wisata
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Price formatting and preview
document.getElementById('price').addEventListener('input', function() {
    const price = parseInt(this.value) || 0;
    const preview = document.getElementById('pricePreview');
    const priceText = document.getElementById('priceText');
    
    if (price > 0) {
        const formatted = 'Rp ' + price.toLocaleString('id-ID');
        priceText.textContent = `Harga per orang: ${formatted}`;
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
    }
    
    updatePackagePreview();
});

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
    
    updatePackagePreview();
});

// Package preview update
function updatePackagePreview() {
    const name = document.getElementById('name').value;
    const description = document.getElementById('description').value;
    const price = document.getElementById('price').value;
    const capacity = document.getElementById('max_capacity').value;
    const facilities = document.getElementById('facilities').value;
    const previewDiv = document.getElementById('packagePreview');
    
    if (name || description || price) {
        const formattedPrice = price ? 'Rp ' + parseInt(price).toLocaleString('id-ID') : 'Rp 0';
        
        previewDiv.innerHTML = `
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="card-title mb-0">${name || 'Nama Paket'}</h5>
                    <span class="badge bg-primary">${formattedPrice}</span>
                </div>
                <p class="card-text text-muted">${description || 'Deskripsi paket wisata...'}</p>
                ${facilities ? `<p class="small text-success"><i class="ri-star-line me-1"></i>${facilities.substring(0, 100)}...</p>` : ''}
                ${capacity ? `<p class="small text-info"><i class="ri-users-line me-1"></i>Maksimal ${capacity} orang</p>` : ''}
            </div>
        `;
    } else {
        previewDiv.innerHTML = `
            <div class="card-body">
                <h6 class="text-muted mb-2">Pratinjau akan muncul saat Anda mengisi form</h6>
                <p class="text-muted mb-0">Paket akan ditampilkan seperti ini di website</p>
            </div>
        `;
    }
}

// Auto-update preview on input
['name', 'description', 'max_capacity', 'facilities'].forEach(id => {
    document.getElementById(id).addEventListener('input', updatePackagePreview);
});

// Reset form function
function resetForm() {
    if (confirm('Yakin ingin mereset semua data yang sudah diisi?')) {
        document.getElementById('packageForm').reset();
        document.getElementById('imagePreview').style.display = 'none';
        document.getElementById('pricePreview').style.display = 'none';
        updatePackagePreview();
    }
}
</script>
@endsection