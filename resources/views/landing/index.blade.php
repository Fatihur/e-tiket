<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Tiket Wisata - Pesan Tiket Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            overflow-x: hidden;
        }
        
        /* Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
            padding: 1rem 0;
            transition: all 0.3s ease;
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
            transform: translateY(-2px);
        }
        
        .btn-login {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white !important;
            padding: 0.5rem 1.5rem !important;
            border-radius: 25px;
            font-weight: 600;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 180, 216, 0.3);
        }
        
        /* Hero Section with Landscape Background */
        .hero-section {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            color: white;
            padding-top: 80px;
            overflow: hidden;
        }
        
        /* Background Image Layer */
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('https://images.unsplash.com/photo-1506905925346-21bda4d32df4?q=80&w=2070');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: -2;
        }
        
        /* Gradient Overlay */
        .hero-section::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(0, 180, 216, 0.75), rgba(0, 119, 182, 0.75));
            z-index: -1;
        }
        
        /* Bottom Wave Decoration */
        .hero-section .wave-bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 150px;
            background: linear-gradient(to top, white, transparent);
            z-index: 1;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
            animation: fadeInUp 1s ease;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .hero-section h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.4);
        }
        
        .hero-section p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            font-weight: 300;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.3);
        }
        
        .btn-hero {
            background: white;
            color: var(--primary-color);
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }
        
        .btn-hero:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            background: var(--light-color);
        }
        
        /* Section Title */
        .section-title {
            position: relative;
            margin-bottom: 3rem;
        }
        
        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }
        
        .section-title p {
            color: var(--text-light);
            font-size: 1.1rem;
        }
        
        .section-title::after {
            content: '';
            display: block;
            width: 60px;
            height: 4px;
            background: linear-gradient(to right, var(--primary-color), var(--accent-color));
            margin: 1rem auto 0;
            border-radius: 2px;
        }
        
        /* Package Cards */
        .packages-section {
            padding: 5rem 0;
            background: linear-gradient(to bottom, #fff 0%, var(--light-color) 100%);
        }
        
        .package-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: white;
            height: 100%;
        }
        
        .package-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 180, 216, 0.2);
        }
        
        .package-image {
            position: relative;
            overflow: hidden;
            height: 250px;
        }
        
        .package-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .package-card:hover .package-image img {
            transform: scale(1.1);
        }
        
        .package-image .placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--light-color), var(--accent-color));
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .price-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #FF6B6B, #FF8E53);
            color: white;
            padding: 0.5rem 1.2rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1rem;
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3);
            z-index: 1;
        }
        
        .package-card .card-body {
            padding: 1.8rem;
        }
        
        .package-card .card-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1.2rem;
        }
        
        .facilities-badge {
            background-color: var(--light-color);
            color: var(--secondary-color);
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-size: 0.85rem;
            display: inline-block;
            margin-bottom: 1rem;
        }
        
        .capacity-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-light);
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }
        
        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            border-radius: 10px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 10px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 180, 216, 0.3);
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 5rem 2rem;
        }
        
        .empty-state i {
            font-size: 5rem;
            color: var(--accent-color);
            margin-bottom: 1.5rem;
        }
        
        .empty-state h4 {
            color: var(--text-dark);
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        /* About Section */
        .about-section {
            padding: 5rem 0;
            background: white;
        }
        
        .about-content h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1.5rem;
        }
        
        .about-content p {
            font-size: 1.1rem;
            color: var(--text-light);
            line-height: 1.8;
            margin-bottom: 2rem;
        }
        
        .feature-list {
            list-style: none;
            padding: 0;
        }
        
        .feature-list li {
            padding: 0.8rem 0;
            font-size: 1rem;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .feature-list i {
            width: 30px;
            height: 30px;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
        }
        
        .steps-card {
            background: white;
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }
        
        .steps-card h4 {
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 2rem;
        }
        
        .step-item {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 2rem;
            align-items: start;
        }
        
        .step-item:last-child {
            margin-bottom: 0;
        }
        
        .step-number {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.2rem;
            flex-shrink: 0;
        }
        
        .step-content h6 {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.3rem;
        }
        
        .step-content small {
            color: var(--text-light);
            line-height: 1.6;
        }
        
        /* Footer */
        footer {
            background: linear-gradient(135deg, var(--dark-color), var(--secondary-color));
            color: white;
            padding: 3rem 0 1.5rem;
        }
        
        footer h5 {
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        footer p {
            color: rgba(255, 255, 255, 0.8);
            margin: 0;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-section h1 {
                font-size: 2.2rem;
            }
            
            .hero-section p {
                font-size: 1rem;
            }
            
            .section-title h2 {
                font-size: 2rem;
            }
            
            .about-content h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-umbrella-beach"></i>
                E-Tiket Wisata
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#packages">Paket Wisata</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-login" href="{{ route('login') }}">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="wave-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto text-center hero-content">
                    <h1>Jelajahi Keindahan<br>Wisata Indonesia</h1>
                    <p>Pesan tiket wisata secara online dengan mudah dan aman. Nikmati pengalaman liburan yang tak terlupakan bersama kami!</p>
                    <a href="#packages" class="btn btn-hero">
                        <i class="fas fa-compass me-2"></i>Lihat Paket Wisata
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Packages Section -->
    <section id="packages" class="packages-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center section-title">
                    <h2>Paket Wisata Pilihan</h2>
                    <p>Temukan destinasi impian Anda dengan harga terbaik</p>
                </div>
            </div>

            <div class="row g-4">
                @foreach($packages as $package)
                <div class="col-lg-3 col-md-6">
                    <div class="card package-card">
                        <div class="package-image">
                            <div class="price-badge">{{ $package->formatted_price }}</div>
                            
                            @if($package->image)
                            <img src="{{ asset('storage/' . $package->image) }}" alt="{{ $package->name }}">
                            @else
                            <div class="placeholder">
                                <i class="fas fa-image fa-4x text-white"></i>
                            </div>
                            @endif
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $package->name }}</h5>
                            
                            @if($package->facilities)
                            <div class="facilities-badge">
                                <i class="fas fa-check-circle me-1"></i>
                                {{ Str::limit($package->facilities, 70) }}
                            </div>
                            @endif

                            <div class="capacity-info">
                                <i class="fas fa-users"></i>
                                <span>Maksimal {{ $package->max_capacity }} orang</span>
                            </div>
                            
                            <div class="d-grid gap-2 mt-auto">
                                <a href="{{ route('landing.package.detail', $package->id) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-info-circle me-2"></i>Detail
                                </a>
                                <a href="{{ route('landing.booking', $package->id) }}" class="btn btn-primary">
                                    <i class="fas fa-ticket-alt me-2"></i>Pesan Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($packages->isEmpty())
            <div class="empty-state">
                <i class="fas fa-search"></i>
                <h4>Belum Ada Paket Wisata</h4>
                <p class="text-muted">Paket wisata akan segera tersedia. Pantau terus website kami!</p>
            </div>
            @endif
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 about-content">
                    <h2>Tentang E-Tiket Wisata</h2>
                    <p>Platform pemesanan tiket wisata online terpercaya yang memudahkan Anda merencanakan liburan impian. Dengan sistem terintegrasi, kami memberikan pengalaman booking yang cepat, aman, dan mudah.</p>
                    
                    <ul class="feature-list">
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Pemesanan online 24/7 tanpa antre</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Pembayaran aman dan terpercaya</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>E-Tiket digital dengan QR Code</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Customer service responsif siap membantu</span>
                        </li>
                    </ul>
                </div>
                
                <div class="col-lg-6">
                    <div class="steps-card">
                        <h4><i class="fas fa-route me-2"></i>Cara Pemesanan</h4>
                        
                        <div class="step-item">
                            <div class="step-number">1</div>
                            <div class="step-content">
                                <h6>Pilih Paket Wisata</h6>
                                <small>Browse dan pilih paket wisata sesuai keinginan Anda</small>
                            </div>
                        </div>
                        
                        <div class="step-item">
                            <div class="step-number">2</div>
                            <div class="step-content">
                                <h6>Isi Data Pemesanan</h6>
                                <small>Lengkapi informasi pengunjung dan jadwal kunjungan</small>
                            </div>
                        </div>
                        
                        <div class="step-item">
                            <div class="step-number">3</div>
                            <div class="step-content">
                                <h6>Lakukan Pembayaran</h6>
                                <small>Transfer dan upload bukti pembayaran Anda</small>
                            </div>
                        </div>
                        
                        <div class="step-item">
                            <div class="step-number">4</div>
                            <div class="step-content">
                                <h6>Terima E-Tiket</h6>
                                <small>E-Tiket akan dikirim via email setelah verifikasi</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <h5><i class="fas fa-umbrella-beach me-2"></i>E-Tiket Wisata</h5>
                    <p>Platform pemesanan tiket wisata online terpercaya</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p>&copy; 2024 E-Tiket Wisata. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
