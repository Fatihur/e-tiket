<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan Tiket - {{ $periodText }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        @page {
            margin: 12mm 15mm;
            size: A4 landscape;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 9pt;
            color: #1a1a1a;
            line-height: 1.4;
            padding: 0;
        }
        
        .container {
            max-width: 100%;
            margin: 0 auto;
            padding: 10px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 3px solid #000;
        }
        
        .header h1 {
            font-size: 16pt;
            color: #000;
            margin-bottom: 4px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }
        
        .header h2 {
            font-size: 11pt;
            color: #444;
            font-weight: normal;
        }
        
        .info-section {
            margin-bottom: 12px;
            padding: 8px 12px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 2px;
        }
        
        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 3px;
        }
        
        .info-row:last-child {
            margin-bottom: 0;
        }
        
        .info-label {
            display: table-cell;
            width: 140px;
            font-weight: 600;
            color: #333;
        }
        
        .info-value {
            display: table-cell;
            color: #555;
        }
        
        .summary-section {
            margin: 12px 0 15px 0;
            padding: 10px;
            background-color: #f8f9fa;
            border: 2px solid #000;
            border-radius: 2px;
        }
        
        .summary-grid {
            display: table;
            width: 100%;
            table-layout: fixed;
        }
        
        .summary-item {
            display: table-cell;
            width: 25%;
            padding: 8px;
            text-align: center;
            vertical-align: middle;
            border-right: 1px solid #dee2e6;
        }
        
        .summary-item:last-child {
            border-right: none;
        }
        
        .summary-label {
            font-size: 8pt;
            color: #666;
            margin-bottom: 4px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        
        .summary-value {
            font-size: 13pt;
            font-weight: bold;
            color: #000;
            line-height: 1.2;
        }
        
        .table-wrapper {
            margin-top: 12px;
            overflow: visible;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt;
            border: 1px solid #000;
            table-layout: fixed;
        }
        
        .table thead {
            background-color: #e9ecef;
        }
        
        .table thead tr {
            background-color: #e9ecef;
        }
        
        .table th {
            padding: 8px 6px;
            text-align: left;
            border: 1px solid #000;
            font-weight: bold;
            font-size: 8pt;
            color: #000;
            background-color: #e9ecef;
            vertical-align: middle;
            line-height: 1.3;
        }
        
        .table td {
            padding: 6px;
            border: 1px solid #666;
            font-size: 8pt;
            color: #1a1a1a;
            vertical-align: middle;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        
        .table tbody tr {
            background-color: #fff;
        }
        
        .table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .table tbody tr:last-child td {
            border-bottom: 1px solid #000;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-left {
            text-align: left;
        }
        
        .col-no {
            width: 3%;
        }
        
        .col-date-booking {
            width: 9%;
        }
        
        .col-code {
            width: 10%;
        }
        
        .col-name {
            width: 13%;
        }
        
        .col-email {
            width: 14%;
        }
        
        .col-package {
            width: 13%;
        }
        
        .col-date-visit {
            width: 9%;
        }
        
        .col-qty {
            width: 5%;
        }
        
        .col-total {
            width: 14%;
        }
        
        .booking-code {
            font-weight: 600;
            color: #000;
            font-size: 7.5pt;
        }
        
        .amount {
            font-weight: 600;
            color: #000;
        }
        
        .email-text {
            font-size: 7pt;
            word-break: break-all;
        }
        
        .footer {
            margin-top: 15px;
            padding-top: 10px;
            border-top: 2px solid #000;
            text-align: center;
            font-size: 7pt;
            color: #555;
        }
        
        .footer p {
            margin: 2px 0;
        }
        
        .page-break {
            page-break-after: always;
        }
        
        .no-data {
            text-align: center;
            margin: 40px 0;
            padding: 40px;
            color: #999;
            font-style: italic;
            background-color: #f8f9fa;
            border: 1px dashed #ccc;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>LAPORAN PENJUALAN TIKET WISATA</h1>
            <h2>Wisata Lapade</h2>
        </div>
        
        <div class="info-section">
            <div class="info-row">
                <span class="info-label">Periode Laporan:</span>
                <span class="info-value">{{ $periodText }}</span>
            </div>
            @if($period === 'custom' && $startDate && $endDate)
            <div class="info-row">
                <span class="info-label">Tanggal:</span>
                <span class="info-value">{{ date('d/m/Y', strtotime($startDate)) }} - {{ date('d/m/Y', strtotime($endDate)) }}</span>
            </div>
            @endif
            <div class="info-row">
                <span class="info-label">Tanggal Export:</span>
                <span class="info-value">{{ now()->format('d/m/Y H:i:s') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Total Data:</span>
                <span class="info-value">{{ $bookings->count() }} booking</span>
            </div>
        </div>
        
        <div class="summary-section">
            <div class="summary-grid">
                <div class="summary-item">
                    <div class="summary-label">Total Penjualan</div>
                    <div class="summary-value">{{ $summary['total_sales'] }}</div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Total Revenue</div>
                    <div class="summary-value">Rp {{ number_format($summary['total_revenue'], 0, ',', '.') }}</div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Total Pengunjung</div>
                    <div class="summary-value">{{ $summary['total_visitors'] }}</div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Rata-rata Transaksi</div>
                    <div class="summary-value">Rp {{ number_format($summary['avg_transaction'], 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
        
        @if($bookings->count() > 0)
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th class="col-no text-center">No</th>
                        <th class="col-date-booking">Tanggal<br>Booking</th>
                        <th class="col-code">Kode<br>Booking</th>
                        <th class="col-name">Nama<br>Pengunjung</th>
                        <th class="col-email">Email</th>
                        <th class="col-package">Paket Wisata</th>
                        <th class="col-date-visit">Tanggal<br>Kunjungan</th>
                        <th class="col-qty text-center">Jml</th>
                        <th class="col-total text-right">Total Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $index => $booking)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $booking->created_at->format('d/m/Y H:i') }}</td>
                        <td><span class="booking-code">{{ $booking->booking_code }}</span></td>
                        <td>{{ $booking->visitor_name }}</td>
                        <td><span class="email-text">{{ $booking->visitor_email }}</span></td>
                        <td>{{ $booking->wisataPackage->name }}</td>
                        <td>{{ $booking->visit_date->format('d/m/Y') }}</td>
                        <td class="text-center">{{ $booking->quantity }}</td>
                        <td class="text-right"><span class="amount">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="no-data">
            <p>Tidak ada data untuk periode ini</p>
        </div>
        @endif
        
        <div class="footer">
            <p>Dicetak pada: {{ now()->format('d/m/Y H:i:s') }} | Halaman 1</p>
            <p>Laporan ini dibuat secara otomatis oleh Sistem E-Tiket Wisata Lapade</p>
        </div>
    </div>
</body>
</html>
