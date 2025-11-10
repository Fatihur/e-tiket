<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $package->name }} - E-Tiket Wisata Lapade</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #00B4D8;
            --secondary-color: #0077B6;
            --accent-color: #90E0EF;
            --dark-color: #023E8A;
            --light-color: #CAF0F8;
            --text-dark: #03045E;
            --text-light: #6c757d;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
            background-color: #f8f9fa;
        }
        
        /* Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
            padding: 1rem 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .navbar-nav .nav-link {
            color: var(--text-dark) !important;
            font-weight: 500;
            margin: 0 0.5rem;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .navbar-nav .nav-link:hover {
            background-color: var(--light-color);
            color: var(--primary-color) !important;
        }
        
        /* Breadcrumb */
        .breadcrumb-section {
            background: white;
            padding: 1.5rem 0;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .breadcrumb {
            margin-bottom: 0;
            background: transparent;
        }
        
        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .breadcrumb-item.active {
            color: var(--text-light);
        }
        
        /* Package Image */
        .package-image-wrapper {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }
        
        .package-image-wrapper img {
            width: 100%;
            height: 500px;
            object-fit: cover;
        }
        
        .image-placeholder {
            background: linear-gradient(135deg, var(--light-color), var(--accent-color));
            height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        
        .image-placeholder i {
            font-size: 6rem;
            color: white;
            opacity: 0.7;
        }
        
        /* Package Title */
        .package-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }
        
        .price-section {
            display: flex;
            align-items: baseline;
            gap: 0.5rem;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, var(--light-color), white);
            border-radius: 15px;
            border-left: 4px solid var(--primary-color);
        }
        
        .price-amount {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .price-unit {
            font-size: 1rem;
            color: var(--text-light);
            font-weight: 400;
        }
        
        /* Info Cards */
        .info-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 180, 216, 0.15);
        }
        
        .info-card-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .info-card-title i {
            color: var(--primary-color);
            font-size: 1.5rem;
        }
        
        .info-card p {
            color: var(--text-light);
            line-height: 1.8;
            margin-bottom: 0;
        }
        
        /* Facilities List */
        .facilities-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .facilities-list li {
            padding: 0.8rem 0;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 1rem;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .facilities-list li:last-child {
            border-bottom: none;
        }
        
        .facilities-list i {
            font-size: 1.2rem;
            color: #28a745;
            flex-shrink: 0;
        }
        
        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
        
        .info-item {
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8f9fa, white);
            border-radius: 12px;
            /* border-left: 3px solid var(--accent-color); */
        }
        
        .info-item strong {
            display: block;
            color: var(--text-dark);
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        .info-item span {
            font-size: 1.1rem;
            color: var(--text-light);
        }
        
        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .status-badge.active {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }
        
        .status-badge.inactive {
            background: #6c757d;
            color: white;
        }
        
        /* Booking Card */
        .booking-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 100px;
        }
        
        .booking-card-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .price-summary {
            background: linear-gradient(135deg, var(--light-color), white);
            padding: 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
        }
        
        .price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }
        
        .price-row span:first-child {
            color: var(--text-light);
            font-size: 0.95rem;
        }
        
        .price-row strong {
            font-size: 1.3rem;
            color: var(--primary-color);
            font-weight: 700;
        }
        
        .btn-booking {
            width: 100%;
            padding: 1rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 12px;
            border: none;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .btn-booking:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 180, 216, 0.3);
        }
        
        .btn-booking:disabled {
            background: #6c757d;
            cursor: not-allowed;
        }
        
        .btn-booking:disabled:hover {
            transform: none;
            box-shadow: none;
        }
        
        .booking-info {
            background: #e7f3ff;
            border-left: 4px solid var(--primary-color);
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1.5rem;
        }
        
        .booking-info i {
            color: var(--primary-color);
        }
        
        .booking-info small {
            color: var(--text-dark);
            line-height: 1.6;
        }
        
        /* Footer */
        footer {
            background: linear-gradient(135deg, var(--dark-color), var(--secondary-color));
            color: white;
            padding: 3rem 0 1.5rem;
            margin-top: 4rem;
        }
        
        footer p {
            margin: 0;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .package-title {
                font-size: 1.8rem;
            }
            
            .price-amount {
                font-size: 2rem;
            }
            
            .package-image-wrapper img,
            .image-placeholder {
                height: 300px;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .booking-card {
                position: relative;
                top: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('landing.index') }}">
                <i class="bi bi-umbrella-beach"></i> E-Tiket Wisata Lapade
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('landing.index') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Breadcrumb -->
    <div class="breadcrumb-section">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('landing.index') }}">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $package->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Package Detail -->
    <div class="container my-5">
        <div class="row g-4">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- Package Image -->
                <div class="package-image-wrapper">
                    @if($package->image)
                    <img src="{{ Storage::url($package->image) }}" alt="{{ $package->name }}">
                    @else
                    <div class="image-placeholder">
                        <i class="bi bi-image"></i>
                        <p class="mt-3 text-white">Tidak ada gambar</p>
                    </div>
                    @endif
                </div>

                <!-- Package Title & Price -->
                <h1 class="package-title">{{ $package->name }}</h1>
                
                <div class="price-section">
                    <span class="price-amount">{{ $package->formatted_price }}</span>
                    <span class="price-unit">/ orang</span>
                </div>

                <!-- Description -->
                <div class="info-card">
                    <h5 class="info-card-title">
                        <i class="bi bi-file-text"></i>
                        Deskripsi Paket
                    </h5>
                    <p>{{ $package->description }}</p>
                </div>

                <!-- Facilities -->
                @if($package->facilities)
                <div class="info-card">
                    <h5 class="info-card-title">
                        <i class="bi bi-list-check"></i>
                        Fasilitas yang Tersedia
                    </h5>
                    <ul class="facilities-list">
                        @foreach(explode(',', $package->facilities) as $facility)
                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            <span>{{ trim($facility) }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Info -->
                <div class="info-card">
                    <h5 class="info-card-title">
                        <i class="bi bi-info-circle"></i>
                        Informasi Penting
                    </h5>
                    <div class="info-grid">
                        <div class="info-item">
                            <strong>Kapasitas Maksimal</strong>
                            <span>{{ $package->max_capacity }} orang per hari</span>
                        </div>
                        <div class="info-item">
                            <strong>Status Ketersediaan</strong>
                            @if($package->is_active)
                                <span class="status-badge active">
                                    <i class="bi bi-check-circle-fill me-1"></i>Tersedia
                                </span>
                            @else
                                <span class="status-badge inactive">
                                    <i class="bi bi-x-circle-fill me-1"></i>Tidak Tersedia
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Booking Card -->
            <div class="col-lg-4">
                <div class="booking-card">
                    <h5 class="booking-card-title">
                        <i class="bi bi-calendar-check"></i> Pesan Paket Ini
                    </h5>
                    
                    <div class="price-summary">
                        <div class="price-row">
                            <span>Harga per orang:</span>
                            <strong>{{ $package->formatted_price }}</strong>
                        </div>
                    </div>

                    @if($package->is_active)
                        <a href="{{ route('landing.booking', $package->id) }}" class="btn btn-booking">
                            <i class="bi bi-cart-plus"></i>
                            <span>Booking Sekarang</span>
                        </a>
                    @else
                        <button class="btn btn-booking" disabled>
                            <i class="bi bi-x-circle"></i>
                            <span>Tidak Tersedia</span>
                        </button>
                    @endif

                    <div class="booking-info">
                        <small>
                            <i class="bi bi-info-circle"></i>
                            <strong>Informasi Booking:</strong><br>
                            • Booking minimal 1 hari sebelum kunjungan<br>
                            • E-Tiket dikirim via email setelah pembayaran terverifikasi<br>
                            • Tunjukkan QR Code saat check-in
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <p>&copy; {{ date('Y') }} E-Tiket Wisata Lapade. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
