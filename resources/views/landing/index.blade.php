<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Tiket Wisata - Pesan Tiket Online</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary: #0ea5e9;
            --secondary-dark: #0284c7;
            --background: #f4f6fb;
            --card: #ffffff;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-muted: #94a3b8;
            --border: #e2e8f0;
            --shadow-sm: 0 15px 30px rgba(15, 23, 42, 0.08);
            --shadow-md: 0 30px 60px rgba(15, 23, 42, 0.12);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--background);
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
            overflow-x: hidden;
        }

        img {
            max-width: 100%;
            display: block;
        }

        a {
            text-decoration: none;
        }

        .section-base {
            padding: 6rem 0;
        }

        .navbar {
            position: sticky;
            top: 0;
            width: 100%;
            z-index: 20;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            box-shadow: none;
            transition: box-shadow 0.3s ease;
        }

        .navbar.scrolled {
            box-shadow: var(--shadow-sm);
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary) !important;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-link {
            font-weight: 500;
            color: var(--text-secondary) !important;
            margin: 0 0.25rem;
        }

        .nav-link:hover {
            color: var(--primary) !important;
        }

        .btn-pill {
            border-radius: 999px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            color: #fff;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
            color: #fff;
        }

        .btn-ghost {
            border: 1px solid var(--border);
            color: var(--text-primary);
            background: transparent;
        }

        .btn-ghost:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .hero-section {
            padding: 8rem 0 5rem;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.08), rgba(14, 165, 233, 0.08));
            border-bottom-left-radius: 3rem;
            border-bottom-right-radius: 3rem;
        }

        .hero-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: rgba(37, 99, 235, 0.12);
            color: var(--primary);
            padding: 0.35rem 1rem;
            border-radius: 999px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .hero-section h1 {
            font-size: clamp(2.4rem, 4vw, 3.4rem);
            margin-bottom: 1.5rem;
            font-weight: 700;
            letter-spacing: -0.03em;
            color: var(--text-primary);
        }

        .hero-section p {
            color: var(--text-secondary);
            font-size: 1.1rem;
            margin-bottom: 2.5rem;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: center;
        }

        .hero-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 1rem;
            margin-top: 3rem;
        }

        .stat-card {
            background: var(--card);
            border-radius: 1.25rem;
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
        }

        .stat-card h3 {
            margin: 0;
            font-weight: 700;
            font-size: 2rem;
        }

        .stat-card span {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .hero-media {
            position: relative;
        }

        .hero-media::after {
            content: '';
            position: absolute;
            inset: 20px;
            border-radius: 2rem;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.3), rgba(14, 165, 233, 0.3));
            filter: blur(60px);
            z-index: 0;
        }

        .hero-card {
            position: relative;
            background: var(--card);
            border-radius: 1.75rem;
            padding: 2rem;
            box-shadow: var(--shadow-md);
            z-index: 1;
            overflow: hidden;
        }

        .hero-card .badge {
            background: rgba(248, 250, 252, 0.85);
            color: var(--primary);
            font-weight: 600;
            border-radius: 999px;
            padding: 0.35rem 1rem;
            font-size: 0.85rem;
        }

        .hero-card img {
            border-radius: 1.25rem;
            margin: 1.5rem 0;
            height: 260px;
            width: 100%;
            object-fit: cover;
        }

        .hero-card footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .hero-card footer span {
            color: var(--text-muted);
        }

        .trusted-logos {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: center;
            margin-top: 3rem;
            color: var(--text-muted);
        }

        .trusted-logos .logo-badge {
            background: #fff;
            padding: 0.75rem 1.25rem;
            border-radius: 999px;
            font-weight: 600;
            color: var(--text-secondary);
            border: 1px solid rgba(148, 163, 184, 0.3);
        }

        .section-head {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-head h2 {
            font-weight: 700;
            margin-bottom: 0.75rem;
            font-size: clamp(1.8rem, 3vw, 2.5rem);
        }

        .section-head p {
            color: var(--text-secondary);
            max-width: 620px;
            margin: 0 auto;
        }

        .highlight-card {
            background: var(--card);
            border-radius: 1.5rem;
            padding: 2rem;
            box-shadow: var(--shadow-sm);
            height: 100%;
        }

        .highlight-card i {
            font-size: 1.5rem;
            color: var(--primary);
            background: rgba(37, 99, 235, 0.08);
            padding: 0.75rem;
            border-radius: 1rem;
            margin-bottom: 1.25rem;
        }

        .packages-section {
            background: #fff;
        }

        .package-card {
            background: var(--card);
            border-radius: 1.5rem;
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .package-media {
            position: relative;
            height: 220px;
            background: rgba(148, 163, 184, 0.1);
        }

        .package-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .price-chip {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: rgba(15, 23, 42, 0.75);
            color: #fff;
            padding: 0.4rem 1rem;
            border-radius: 999px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .package-body {
            padding: 1.75rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            flex: 1;
        }

        .package-body h5 {
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .facility-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            background: rgba(14, 165, 233, 0.12);
            color: var(--secondary-dark);
            padding: 0.5rem 0.85rem;
            border-radius: 999px;
            font-size: 0.85rem;
        }

        .package-meta {
            display: flex;
            align-items: center;
            gap: 0.35rem;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .package-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: auto;
        }

        .package-actions a {
            flex: 1;
            justify-content: center;
        }

        .empty-state {
            background: rgba(255, 255, 255, 0.8);
            border: 1px dashed var(--border);
            border-radius: 1.5rem;
            padding: 3rem;
            text-align: center;
        }

        .empty-state i {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .about-section .feature-list {
            list-style: none;
            margin: 2rem 0;
            padding: 0;
            display: grid;
            gap: 1rem;
        }

        .feature-list li {
            display: flex;
            gap: 0.75rem;
            align-items: flex-start;
            color: var(--text-secondary);
        }

        .feature-list i {
            color: var(--primary);
            background: rgba(37, 99, 235, 0.1);
            border-radius: 999px;
            padding: 0.4rem;
            margin-top: 0.15rem;
        }

        .timeline-card {
            background: var(--card);
            border-radius: 1.5rem;
            padding: 2rem;
            box-shadow: var(--shadow-sm);
        }

        .timeline-step {
            display: flex;
            gap: 1rem;
            padding: 1.25rem 0;
            border-bottom: 1px solid var(--border);
        }

        .timeline-step:last-child {
            border-bottom: none;
        }

        .step-number {
            width: 48px;
            height: 48px;
            border-radius: 999px;
            background: rgba(37, 99, 235, 0.15);
            color: var(--primary);
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cta-section {
            padding: 5rem 0;
        }

        .cta-box {
            background: linear-gradient(135deg, var(--primary), var(--secondary-dark));
            border-radius: 2rem;
            padding: 4rem;
            color: #fff;
            text-align: center;
            box-shadow: var(--shadow-md);
        }

        footer {
            padding: 2.5rem 0;
            color: var(--text-secondary);
            text-align: center;
            background: transparent;
        }

        @media (max-width: 991px) {
            .hero-section {
                padding-top: 7rem;
            }

            .hero-card {
                margin-top: 2rem;
            }

            .timeline-step {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg py-3">
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
                <li class="nav-item"><a class="nav-link" href="#home">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="#packages">Paket</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">Tentang</a></li>
                <li class="nav-item ms-lg-3">
                    <a class="btn btn-primary btn-pill" href="{{ route('login') }}">Masuk</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main>
    <section class="hero-section" id="home">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <div class="hero-chip">
                        <i class="fas fa-star"></i>
                        Rencanakan liburan modern
                    </div>
                    <h1>Booking tiket wisata kini lebih personal dan clean.</h1>
                    <p>Temukan destinasi terbaik, atur jadwal, dan dapatkan e-tiket instan tanpa antre. Semua kebutuhan perjalanan Anda dalam satu platform yang intuitif.</p>
                    <div class="hero-actions">
                        <a href="#packages" class="btn btn-primary btn-pill">
                            <i class="fas fa-compass me-2"></i>Jelajahi Paket
                        </a>
                        @if($packages->isNotEmpty())
                        <a href="{{ route('landing.booking', $packages->first()->id) }}" class="btn btn-ghost btn-pill d-flex align-items-center gap-2">
                            <i class="fas fa-ticket-alt"></i>Booking Langsung
                        </a>
                        @else
                        <a href="#packages" class="btn btn-ghost btn-pill d-flex align-items-center gap-2">
                            <i class="fas fa-ticket-alt"></i>Booking Langsung
                        </a>
                        @endif
                    </div>
                    <div class="hero-stats">
                        <div class="stat-card">
                            <h3>120+</h3>
                            <span>Destinasi terkurasi</span>
                        </div>
                        <div class="stat-card">
                            <h3>15K</h3>
                            <span>Pengguna aktif</span>
                        </div>
                        <div class="stat-card">
                            <h3>4.8/5</h3>
                            <span>Rating pengalaman</span>
                        </div>
                    </div>
                    <div class="trusted-logos">
                        <span>Dipercaya pengelola destinasi:</span>
                        <div class="logo-badge">NusaTrip</div>
                        <div class="logo-badge">Bromo Park</div>
                        <div class="logo-badge">Labuan Bajo</div>
                    </div>
                </div>
                <div class="col-lg-6 hero-media">
                    <div class="hero-card">
                        <div class="badge">
                            <i class="fas fa-bolt me-2"></i>Live Availability
                        </div>
                        <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=900&q=80" alt="Destinasi wisata">
                        <footer>
                            <div>
                                <h5 class="mb-0">Pantai Eksotis</h5>
                                <span>Slot tersisa 12</span>
                            </div>
                            <div class="text-end">
                                <small>Mulai</small>
                                <h5 class="mb-0">Rp450K</h5>
                            </div>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-base">
        <div class="container">
            <div class="section-head">
                <h2>Clean journey, smart decision.</h2>
                <p>Semua insight penting tersedia dalam satu tampilan supaya Anda fokus menikmati perjalanan.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <article class="highlight-card">
                        <i class="fas fa-layer-group"></i>
                        <h5>Personalized flow</h5>
                        <p>Antarmuka minimalis dengan highlight informasi utama seperti kuota, fasilitas, dan harga terbaik.</p>
                    </article>
                </div>
                <div class="col-md-4">
                    <article class="highlight-card">
                        <i class="fas fa-mobile-screen-button"></i>
                        <h5>Responsif & cepat</h5>
                        <p>Landing page ringan, responsif di semua device, plus transisi halus yang nyaman di mata.</p>
                    </article>
                </div>
                <div class="col-md-4">
                    <article class="highlight-card">
                        <i class="fas fa-shield-check"></i>
                        <h5>Secure booking</h5>
                        <p>Setiap transaksi terlindungi, bukti pembayaran terverifikasi otomatis, dan QR tiket siap pakai.</p>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section class="section-base packages-section" id="packages">
        <div class="container">
            <div class="section-head">
                <h2>Paket wisata terpopuler</h2>
                <p>Seleksi destinasi curated dengan harga transparan dan fasilitas yang relevan.</p>
            </div>

            <div class="row g-4">
                @forelse($packages as $package)
                <div class="col-xl-3 col-md-6">
                    <article class="package-card">
                        <div class="package-media">
                            <div class="price-chip">{{ $package->formatted_price }}</div>
                            @if($package->image)
                                <img src="{{ asset('storage/' . $package->image) }}" alt="{{ $package->name }}">
                            @else
                                <div class="h-100 w-100 d-flex align-items-center justify-content-center text-muted">
                                    <i class="fas fa-image fa-2x"></i>
                                </div>
                            @endif
                        </div>
                        <div class="package-body">
                            <div>
                                <h5>{{ $package->name }}</h5>
                                <p class="mb-2 text-muted">{{ \Illuminate\Support\Str::limit($package->description ?? 'Destinasi unggulan dengan fasilitas lengkap dan jadwal fleksibel.', 90) }}</p>
                                @if($package->facilities)
                                <span class="facility-tag">
                                    <i class="fas fa-check"></i>
                                    {{ \Illuminate\Support\Str::limit($package->facilities, 60) }}
                                </span>
                                @endif
                            </div>
                            <div class="package-meta">
                                <i class="fas fa-users"></i>
                                Maks {{ $package->max_capacity }} orang
                            </div>
                            <div class="package-actions">
                                <a href="{{ route('landing.package.detail', $package->id) }}" class="btn btn-ghost btn-pill">
                                    Detail
                                </a>
                                <a href="{{ route('landing.booking', $package->id) }}" class="btn btn-primary btn-pill">
                                    Pesan
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
                @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class="fas fa-search"></i>
                        <h5>Belum ada paket aktif</h5>
                        <p class="mb-0">Tim kami sedang menyiapkan destinasi terbaik. Silakan cek kembali dalam waktu dekat.</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="section-base about-section" id="about">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <div class="section-head text-start mb-0">
                        <h2>Tentang platform</h2>
                        <p>Kami merancang E-Tiket Wisata agar setiap touchpoint terasa rapi, ringkas, dan relevan. Mulai dari penelusuran paket hingga e-tiket di email Anda.</p>
                    </div>
                    <ul class="feature-list">
                        <li><i class="fas fa-circle-check"></i> Live kuota dan kapasitas per destinasi</li>
                        <li><i class="fas fa-circle-check"></i> Pembayaran tervalidasi otomatis</li>
                        <li><i class="fas fa-circle-check"></i> QR e-tiket siap pindai petugas</li>
                        <li><i class="fas fa-circle-check"></i> Dukungan petugas responsif 24/7</li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <div class="timeline-card">
                        <h5 class="mb-4">Flow booking 4 langkah</h5>
                        <div class="timeline-step">
                            <div class="step-number">1</div>
                            <div>
                                <h6>Pilih paket favorit</h6>
                                <small class="text-muted">Filter sesuai lokasi, fasilitas, atau anggaran.</small>
                            </div>
                        </div>
                        <div class="timeline-step">
                            <div class="step-number">2</div>
                            <div>
                                <h6>Isi detail perjalanan</h6>
                                <small class="text-muted">Masukkan data pengunjung dan tanggal kunjungan.</small>
                            </div>
                        </div>
                        <div class="timeline-step">
                            <div class="step-number">3</div>
                            <div>
                                <h6>Konfirmasi & bayar</h6>
                                <small class="text-muted">Upload bukti transfer, sistem akan verifikasi otomatis.</small>
                            </div>
                        </div>
                        <div class="timeline-step">
                            <div class="step-number">4</div>
                            <div>
                                <h6>Terima e-tiket digital</h6>
                                <small class="text-muted">QR code Anda siap dipindai di lokasi wisata.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="container">
            <div class="cta-box">
                <p class="text-uppercase mb-2 fw-semibold opacity-75">Mulai sekarang</p>
                <h2 class="mb-4">Siapkan perjalanan terbaik Anda bersama E-Tiket Wisata.</h2>
                <p class="mb-4">Navigasi yang bersih, data transparan, dan notifikasi real-time akan mendampingi setiap langkah.</p>
                <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                    <a href="#packages" class="btn btn-light btn-pill text-primary fw-semibold">Lihat Paket</a>
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-pill fw-semibold">Masuk Dashboard</a>
                </div>
            </div>
        </div>
    </section>
</main>

<footer>
    <div class="container">
        <p class="mb-1"><strong>E-Tiket Wisata</strong> · platform pemesanan destinasi modern.</p>
        <small>&copy; {{ now()->year }} E-Tiket Wisata. All rights reserved.</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 40) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
</script>
</body>
</html>
