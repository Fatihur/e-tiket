<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Berhasil - E-Tiket Wisata Lapade</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('landing.index') }}">
                <i class="bi bi-ticket-perforated"></i> E-Tiket Wisata Lapade
            </a>
        </div>
    </nav>

    <!-- Success Content -->
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Success Card -->
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                        </div>
                        <h2 class="text-success mb-3">Booking Berhasil!</h2>
                        <p class="lead text-muted mb-4">
                            Terima kasih telah melakukan booking. Kami akan segera memverifikasi pembayaran Anda.
                        </p>

                        <!-- Booking Details -->
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Detail Booking</h5>
                                <table class="table table-borderless mb-0">
                                    <tr>
                                        <td class="text-start"><strong>Kode Booking:</strong></td>
                                        <td class="text-end"><span class="badge bg-primary fs-6">{{ $booking->booking_code }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start"><strong>Nama:</strong></td>
                                        <td class="text-end">{{ $booking->visitor_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-start"><strong>Email:</strong></td>
                                        <td class="text-end">{{ $booking->visitor_email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-start"><strong>Paket Wisata:</strong></td>
                                        <td class="text-end">{{ $booking->wisataPackage->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-start"><strong>Tanggal Kunjungan:</strong></td>
                                        <td class="text-end">{{ $booking->visit_date->format('d F Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-start"><strong>Jumlah Pengunjung:</strong></td>
                                        <td class="text-end">{{ $booking->quantity }} orang</td>
                                    </tr>
                                    <tr>
                                        <td class="text-start"><strong>Total Pembayaran:</strong></td>
                                        <td class="text-end"><strong class="text-primary">{{ $booking->formatted_total_amount }}</strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if($booking->status == 'confirmed' && $booking->tickets->count() > 0)
                        <!-- Ticket Available -->
                        <div class="alert alert-success text-start">
                            <h6><i class="bi bi-check-circle"></i> Tiket Anda Sudah Tersedia!</h6>
                            <p class="mb-2">Tiket digital Anda sudah siap digunakan. Download tiket PDF untuk ditunjukkan saat masuk.</p>
                            <div class="d-grid gap-2">
                                <a href="{{ route('landing.booking.download-ticket', $booking->id) }}" class="btn btn-success btn-lg">
                                    <i class="bi bi-download"></i> Download Tiket PDF
                                </a>
                            </div>
                        </div>
                        @else
                        <!-- Instructions -->
                        <div class="alert alert-info text-start">
                            <h6><i class="bi bi-info-circle"></i> Langkah Selanjutnya:</h6>
                            <ol class="mb-0 ps-3">
                                <li>Admin kami akan memverifikasi bukti pembayaran Anda.</li>
                                <li>Setelah diverifikasi, tiket digital (QR Code) akan dikirim ke email Anda.</li>
                                <li>Tunjukkan QR Code tiket saat berkunjung ke tempat wisata.</li>
                                <li>Proses verifikasi biasanya memakan waktu 1x24 jam.</li>
                            </ol>
                        </div>
                        @endif

                        <!-- Actions -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <a href="{{ route('landing.index') }}" class="btn btn-primary btn-lg">
                                <i class="bi bi-house"></i> Kembali ke Beranda
                            </a>
                        </div>

                        <!-- Contact Info -->
                        <div class="mt-4">
                            <p class="text-muted mb-1">Butuh bantuan?</p>
                            <p class="mb-0">
                                <i class="bi bi-envelope"></i> info@wisatalapade.com &nbsp;|&nbsp;
                                <i class="bi bi-whatsapp"></i> +62 812-3456-7890
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4 mt-5">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} E-Tiket Wisata Lapade. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

