<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Berhasil · E-Tiket Wisata</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2563eb;
            --secondary: #0ea5e9;
            --accent: #dbeafe;
            --success: #22c55e;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --muted: #94a3b8;
            --card: #ffffff;
            --background: #f4f6fb;
            --shadow-sm: 0 20px 45px rgba(15, 23, 42, 0.12);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: radial-gradient(circle at top, rgba(37, 99, 235, 0.15), transparent 55%), var(--background);
            color: var(--text-primary);
            min-height: 100vh;
            margin: 0;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            box-shadow: none;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .navbar.scrolled {
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary) !important;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .success-wrapper {
            padding: 4rem 0 2rem;
        }

        .success-card {
            background: var(--card);
            border-radius: 2rem;
            padding: 3rem;
            box-shadow: var(--shadow-sm);
        }

        .success-icon {
            width: 74px;
            height: 74px;
            border-radius: 999px;
            background: rgba(34, 197, 94, 0.15);
            color: var(--success);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1.25rem;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.25rem;
        }

        .detail-tile {
            background: rgba(248, 250, 252, 0.9);
            border-radius: 1.25rem;
            padding: 1.25rem;
            border: 1px solid rgba(148, 163, 184, 0.3);
        }

        .detail-tile span {
            display: block;
            font-size: 0.85rem;
            color: var(--muted);
            margin-bottom: 0.35rem;
        }

        .detail-tile strong {
            font-size: 1rem;
            color: var(--text-primary);
        }

        .badge-code {
            background: rgba(37, 99, 235, 0.12);
            color: var(--primary);
            border-radius: 999px;
            padding: 0.45rem 1.2rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .next-steps {
            background: rgba(219, 234, 254, 0.6);
            border-radius: 1.5rem;
            padding: 2rem;
        }

        .next-steps h5 {
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .next-steps li {
            margin-bottom: 0.85rem;
            color: var(--text-secondary);
        }

        .ticket-card {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff;
            border-radius: 1.75rem;
            padding: 2rem;
            box-shadow: var(--shadow-sm);
            height: 100%;
        }

        .ticket-card h4 {
            font-weight: 700;
        }

        footer {
            padding: 2.5rem 0;
            text-align: center;
            color: var(--text-secondary);
        }

        @media (max-width: 767px) {
            .success-card {
                padding: 2rem;
            }

            .detail-grid {
                grid-template-columns: 1fr;
            }

            .next-steps {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
@php
    $ticketReady = $booking->status === 'confirmed' && $booking->tickets->count() > 0;
@endphp

<nav class="navbar navbar-expand-lg py-3">
    <div class="container">
        <a class="navbar-brand" href="{{ route('landing.index') }}">
            <i class="fas fa-umbrella-beach"></i>
            E-Tiket Wisata
        </a>
    </div>
</nav>

<main class="success-wrapper">
    <div class="container">
        <div class="row g-4 align-items-stretch">
            <div class="col-lg-8">
                <section class="success-card h-100">
                    <div class="text-center">
                        <div class="success-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <p class="badge-code mb-3">
                            <i class="fas fa-ticket"></i>
                            {{ $booking->booking_code }}
                        </p>
                        <h2 class="fw-bold mb-2">Booking berhasil diverifikasi.</h2>
                        <p class="text-secondary mb-4">Terima kasih, {{ $booking->visitor_name }}. Detail perjalanan Anda siap kami proses.</p>
                    </div>

                    <div class="detail-grid mb-4">
                        <div class="detail-tile">
                            <span>Nama</span>
                            <strong>{{ $booking->visitor_name }}</strong>
                        </div>
                        <div class="detail-tile">
                            <span>Email</span>
                            <strong>{{ $booking->visitor_email }}</strong>
                        </div>
                        <div class="detail-tile">
                            <span>Paket Wisata</span>
                            <strong>{{ $booking->wisataPackage->name }}</strong>
                        </div>
                        <div class="detail-tile">
                            <span>Tanggal Kunjungan</span>
                            <strong>{{ $booking->visit_date->format('d F Y') }}</strong>
                        </div>
                        <div class="detail-tile">
                            <span>Jumlah Pengunjung</span>
                            <strong>{{ $booking->quantity }} orang</strong>
                        </div>
                        <div class="detail-tile">
                            <span>Total Pembayaran</span>
                            <strong>{{ $booking->formatted_total_amount }}</strong>
                        </div>
                    </div>

                    @if($ticketReady)
                        <div class="ticket-ready alert alert-success border-0 rounded-4 p-4">
                            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                                <div>
                                    <h5 class="fw-semibold mb-1">
                                        <i class="fas fa-qrcode me-2"></i>Tiket digital siap dipakai
                                    </h5>
                                    <p class="mb-0 text-secondary">QR code tersedia dalam file PDF. Simpan di perangkat Anda sebelum berangkat.</p>
                                </div>
                                <a href="{{ route('landing.booking.download-ticket', $booking->id) }}" class="btn btn-light text-primary fw-semibold px-4">
                                    <i class="fas fa-download me-2"></i>Unduh Tiket
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="next-steps">
                            <h5><i class="fas fa-info-circle me-2 text-primary"></i>Langkah selanjutnya</h5>
                            <ol class="mb-0 ps-3">
                                <li>Pembayaran sedang diverifikasi tim admin (maks 1x24 jam).</li>
                                <li>Setelah terkonfirmasi, tiket digital beserta QR code dikirim ke email Anda.</li>
                                <li>Tunjukkan QR code kepada petugas ketika tiba di lokasi wisata.</li>
                            </ol>
                        </div>
                    @endif

                    <div class="mt-4 d-flex flex-wrap gap-3 justify-content-center">
                        <a href="{{ route('landing.index') }}" class="btn btn-outline-primary px-4">
                            <i class="fas fa-house me-2"></i>Beranda
                        </a>
                        <a href="mailto:info@wisatalapade.com" class="btn btn-link text-decoration-none text-secondary">
                            <i class="fas fa-envelope me-1"></i> info@wisatalapade.com
                        </a>
                        <a href="https://wa.me/6281234567890" class="btn btn-link text-decoration-none text-secondary">
                            <i class="fab fa-whatsapp me-1"></i> +62 812-3456-7890
                        </a>
                    </div>
                </section>
            </div>
            <div class="col-lg-4">
                <aside class="ticket-card">
                    <p class="text-uppercase mb-1 fw-semibold opacity-75">Status Booking</p>
                    <h4 class="mb-3">{{ $ticketReady ? 'Tiket Siap' : 'Menunggu Verifikasi' }}</h4>
                    <ul class="list-unstyled text-white-50 mb-4">
                        <li class="mb-2"><i class="fas fa-check me-2"></i>Data pemesanan tersimpan</li>
                        <li class="mb-2"><i class="fas fa-check me-2"></i>Notifikasi email realtime</li>
                        <li class="mb-2"><i class="fas fa-check me-2"></i>QR code siap dipindai petugas</li>
                    </ul>
                    <div class="bg-white text-dark rounded-3 p-3">
                        <small class="text-uppercase text-muted fw-semibold">Kode Booking</small>
                        <div class="d-flex align-items-center justify-content-between mt-2">
                            <strong class="fs-5 text-primary">{{ $booking->booking_code }}</strong>
                            <span class="badge bg-light text-dark">{{ strtoupper($booking->status) }}</span>
                        </div>
                    </div>
                    <p class="mt-4 mb-0 text-white-75">Butuh bantuan lanjutan? Tim support kami standby 24/7.</p>
                </aside>
            </div>
        </div>
    </div>
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
        navbar.classList.toggle('scrolled', window.scrollY > 40);
    });
</script>
</body>
</html>
