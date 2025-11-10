<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tiket Wisata - {{ $booking->booking_code }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        @page {
            margin: 0;
            size: 80mm auto;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10pt;
            color: #000;
            line-height: 1.4;
            padding: 10mm;
            width: 80mm;
        }
        
        .receipt {
            width: 100%;
            max-width: 80mm;
        }
        
        .header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px dashed #000;
        }
        
        .header h1 {
            font-size: 16pt;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        
        .header h2 {
            font-size: 11pt;
            font-weight: normal;
            color: #333;
        }
        
        .header .subtitle {
            font-size: 9pt;
            color: #666;
            margin-top: 3px;
        }
        
        .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
        
        .section {
            margin-bottom: 12px;
        }
        
        .section-title {
            font-size: 9pt;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
            border-bottom: 1px solid #000;
            padding-bottom: 2px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
            font-size: 9pt;
        }
        
        .info-label {
            font-weight: 600;
            width: 40%;
        }
        
        .info-value {
            text-align: right;
            width: 58%;
            word-break: break-word;
        }
        
        .ticket-code {
            text-align: center;
            margin: 15px 0;
            padding: 10px;
            border: 2px solid #000;
            background-color: #f8f9fa;
        }
        
        .ticket-code-label {
            font-size: 8pt;
            margin-bottom: 5px;
            font-weight: 600;
        }
        
        .ticket-code-value {
            font-size: 14pt;
            font-weight: bold;
            letter-spacing: 1px;
            font-family: 'Courier New', monospace;
        }
        
        .qr-section {
            text-align: center;
            margin: 15px 0;
            padding: 10px;
        }
        
        .qr-code {
            margin: 0 auto;
            border: 2px solid #000;
            padding: 5px;
            display: inline-block;
            background-color: #fff;
            width: 150px;
            height: 150px;
        }
        
        .qr-code svg {
            width: 100% !important;
            height: 100% !important;
            display: block;
            margin: 0 auto;
        }
        
        .qr-note {
            font-size: 8pt;
            margin-top: 8px;
            color: #333;
            font-style: italic;
        }
        
        .package-info {
            background-color: #f8f9fa;
            padding: 10px;
            border: 1px solid #000;
            margin: 10px 0;
        }
        
        .package-name {
            font-size: 11pt;
            font-weight: bold;
            margin-bottom: 5px;
            text-align: center;
        }
        
        .price-row {
            display: flex;
            justify-content: space-between;
            font-size: 9pt;
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px dashed #000;
        }
        
        .price-label {
            font-weight: 600;
        }
        
        .price-value {
            font-weight: bold;
            font-size: 11pt;
        }
        
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 2px dashed #000;
            font-size: 8pt;
            color: #666;
        }
        
        .footer p {
            margin: 3px 0;
        }
        
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            padding: 8px;
            margin: 10px 0;
            font-size: 8pt;
            text-align: center;
        }
        
        .center {
            text-align: center;
        }
        
        .bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <h1>Wisata Lapade</h1>
            <h2>Tiket Masuk</h2>
            <div class="subtitle">E-Tiket Booking System</div>
        </div>
        
        <div class="divider"></div>
        
        <div class="section">
            <div class="section-title">Informasi Booking</div>
            <div class="info-row">
                <span class="info-label">Kode Booking:</span>
                <span class="info-value bold">{{ $booking->booking_code }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal Booking:</span>
                <span class="info-value">{{ $booking->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal Kunjungan:</span>
                <span class="info-value bold">{{ $booking->visit_date->format('d/m/Y') }}</span>
            </div>
        </div>
        
        <div class="divider"></div>
        
        <div class="section">
            <div class="section-title">Data Pengunjung</div>
            <div class="info-row">
                <span class="info-label">Nama:</span>
                <span class="info-value">{{ $booking->visitor_name }}</span>
            </div>
            
        </div>
        
        <div class="divider"></div>
        
        <div class="package-info">
            <div class="package-name">{{ $booking->wisataPackage->name }}</div>
            <div class="info-row">
                <span class="info-label">Jumlah Orang:</span>
                <span class="info-value bold">{{ $booking->quantity }} orang</span>
            </div>
        </div>
        
       
        
        <div class="qr-section">
            <div class="qr-code">
                <img src="data:image/svg+xml;base64,{{ $qrcode }}" alt="QR Code" style="width: 150px; height: 150px; display: block; margin: 0 auto;">
            </div>
            <div class="qr-note">Scan QR Code ini saat masuk</div>
        </div>
        
        <div class="divider"></div>
        
        <div class="price-row">
            <span class="price-label">Total Pembayaran:</span>
            <span class="price-value">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
        </div>
        
        <div class="warning">
            <strong>PERHATIAN:</strong><br>
            Tiket ini berlaku untuk {{ $booking->quantity }} orang<br>
            Harap tunjukkan tiket ini saat masuk
        </div>
        
        <div class="footer">
            <p><strong>Terima Kasih</strong></p>
            <p>Selamat Berwisata!</p>
            <p style="margin-top: 10px; font-size: 7pt;">
                Tiket dicetak: {{ now()->format('d/m/Y H:i:s') }}
            </p>
            <p style="font-size: 7pt;">
                Sistem E-Tiket Wisata Lapade
            </p>
        </div>
    </div>
</body>
</html>

