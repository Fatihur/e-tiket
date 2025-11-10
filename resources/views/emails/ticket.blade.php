<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Wisata Anda</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .ticket {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .ticket-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .ticket-row:last-child {
            border-bottom: none;
        }
        .ticket-label {
            font-weight: bold;
            color: #666;
        }
        .ticket-value {
            text-align: right;
        }
        .qr-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin: 20px 0;
        }
        .qr-code {
            margin: 20px 0;
        }
        .qr-code img {
            max-width: 250px;
            border: 5px solid #667eea;
            border-radius: 10px;
            padding: 10px;
        }
        .instructions {
            background: #fff3cd;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #ffc107;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎫 Tiket Wisata Anda</h1>
        <p>Booking Dikonfirmasi!</p>
    </div>

    <div class="content">
        <p>Halo <strong>{{ $booking->visitor_name }}</strong>,</p>
        
        <p>Terima kasih telah melakukan booking di Wisata Lapade! Pembayaran Anda telah diverifikasi dan tiket Anda sudah siap digunakan.</p>

        <div class="ticket">
            <h3 style="margin-top: 0; color: #667eea;">Detail Booking</h3>
            
            <div class="ticket-row">
                <span class="ticket-label">Kode Booking:</span>
                <span class="ticket-value"><strong>{{ $booking->booking_code }}</strong></span>
            </div>
            
            <div class="ticket-row">
                <span class="ticket-label">Paket Wisata:</span>
                <span class="ticket-value">{{ $booking->wisataPackage->name }}</span>
            </div>
            
            <div class="ticket-row">
                <span class="ticket-label">Tanggal Kunjungan:</span>
                <span class="ticket-value">{{ $booking->visit_date->format('d F Y') }}</span>
            </div>
            
            <div class="ticket-row">
                <span class="ticket-label">Jumlah Pengunjung:</span>
                <span class="ticket-value">{{ $booking->quantity }} orang</span>
            </div>
            
            <div class="ticket-row">
                <span class="ticket-label">Total Pembayaran:</span>
                <span class="ticket-value"><strong>{{ $booking->formatted_total_amount }}</strong></span>
            </div>
        </div>

        <div class="qr-section">
            <h3 style="color: #667eea;">Tiket QR Code Anda</h3>
            <p>Tiket ini berlaku untuk <strong>{{ $booking->quantity }} orang</strong></p>
            <p>Tunjukkan QR Code ini kepada petugas di pintu masuk</p>
            
            @if($booking->tickets->count() > 0)
                @php $ticket = $booking->tickets->first(); @endphp
                <div class="qr-code">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ urlencode($ticket->qr_code) }}" alt="QR Code">
                    <p><small><code>{{ $ticket->ticket_code }}</code></small></p>
                </div>
                
                <div style="text-align: center; margin-top: 20px;">
                    <a href="{{ route('landing.booking.download-ticket', $booking->id) }}" class="button" style="background: #28a745;">
                        📥 Download Tiket PDF
                    </a>
                </div>
            @endif
        </div>

        <div class="instructions">
            <h4 style="margin-top: 0;">📋 Instruksi Penting:</h4>
            <ul>
                <li>Simpan email ini dengan baik atau download QR Code-nya</li>
                <li>Tunjukkan QR Code kepada petugas saat masuk lokasi wisata</li>
                <li>Setiap QR Code hanya bisa digunakan 1 kali</li>
                <li>Datang sesuai tanggal kunjungan yang tertera</li>
                <li>Tiket tidak dapat direfund atau ditukar ke tanggal lain</li>
            </ul>
        </div>

        @if($booking->notes)
        <div style="background: #d1ecf1; padding: 15px; border-radius: 5px; border-left: 4px solid #0c5460; margin: 20px 0;">
            <strong>Catatan dari Admin:</strong><br>
            {{ $booking->notes }}
        </div>
        @endif

        <p>Jika ada pertanyaan, silakan hubungi kami di:</p>
        <p>
            📧 Email: info@wisatalapade.com<br>
            📱 WhatsApp: +62 812-3456-7890
        </p>

        <div class="footer">
            <p>Terima kasih telah memilih Wisata Lapade!</p>
            <p>&copy; {{ date('Y') }} E-Tiket Wisata Lapade. All rights reserved.</p>
        </div>
    </div>
</body>
</html>

