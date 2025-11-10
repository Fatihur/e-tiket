@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Detail Tiket - {{ $booking->booking_code }}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.reports') }}">Laporan</a></li>
                        <li class="breadcrumb-item active">Detail Tiket</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Info -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-information-line me-2"></i>Informasi Booking
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Kode Booking:</strong></td>
                                    <td><code>{{ $booking->booking_code }}</code></td>
                                </tr>
                                <tr>
                                    <td><strong>Nama Pengunjung:</strong></td>
                                    <td>{{ $booking->visitor_name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $booking->visitor_email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>No. Telepon:</strong></td>
                                    <td>{{ $booking->visitor_phone }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Paket Wisata:</strong></td>
                                    <td>{{ $booking->wisataPackage->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Kunjungan:</strong></td>
                                    <td>{{ $booking->visit_date->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jumlah Pengunjung:</strong></td>
                                    <td>{{ $booking->quantity }} orang</td>
                                </tr>
                                <tr>
                                    <td><strong>Total Bayar:</strong></td>
                                    <td><strong class="text-success">{{ $booking->formatted_total_amount }}</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-calendar-check-line me-2"></i>Status & Timeline
                    </h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6>Booking Dibuat</h6>
                                <p class="text-muted small mb-0">{{ $booking->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        
                        @if($booking->validated_at)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6>Booking Dikonfirmasi</h6>
                                <p class="text-muted small mb-1">{{ $booking->validated_at->format('d M Y, H:i') }}</p>
                                <p class="text-muted small mb-0">oleh {{ $booking->validator->name ?? 'System' }}</p>
                            </div>
                        </div>
                        @endif

                        @if($booking->tickets->where('is_used', true)->count() > 0)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6>Tiket Digunakan</h6>
                                <p class="text-muted small mb-0">
                                    {{ $booking->tickets->where('is_used', true)->first()->used_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tickets -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="ri-ticket-line me-2"></i>Daftar Tiket ({{ $booking->tickets->count() }} tiket)
                        </h5>
                        <div>
                            @if($booking->status == 'confirmed')
                            <button type="button" class="btn btn-primary btn-sm" onclick="resendAllTickets()">
                                <i class="ri-mail-line me-1"></i>Kirim Ulang Semua Tiket
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($booking->tickets->count() > 0)
                    <div class="row">
                        @foreach($booking->tickets as $ticket)
                        <div class="col-lg-6 col-xl-4">
                            <div class="card border {{ $ticket->is_used ? 'border-success' : 'border-primary' }} mb-3">
                                <div class="card-header bg-light">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">Tiket #{{ $loop->iteration }}</h6>
                                        @if($ticket->is_used)
                                        <span class="badge bg-success">Terpakai</span>
                                        @else
                                        <span class="badge bg-primary">Belum Terpakai</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body text-center">
                                    <!-- QR Code -->
                                    <div class="mb-3">
                                        {!! QrCode::size(150)->generate($ticket->qr_code) !!}
                                    </div>
                                    
                                    <p class="mb-1"><strong>Kode Tiket:</strong></p>
                                    <code class="fs-6">{{ $ticket->ticket_code }}</code>
                                    
                                    @if($ticket->is_used)
                                    <div class="mt-3">
                                        <p class="mb-1"><strong>Digunakan pada:</strong></p>
                                        <small class="text-muted">{{ $ticket->used_at->format('d M Y, H:i') }}</small>
                                        @if($ticket->scanner)
                                        <br><small class="text-muted">oleh {{ $ticket->scanner->name }}</small>
                                        @endif
                                    </div>
                                    @else
                                    <div class="mt-3">
                                        <small class="text-muted">Berlaku untuk tanggal: {{ $booking->visit_date->format('d M Y') }}</small>
                                    </div>
                                    @endif
                                </div>
                                <div class="card-footer">
                                    <div class="d-grid gap-2">
                                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="downloadTicket('{{ $ticket->id }}')">
                                            <i class="ri-download-line me-1"></i>Download QR
                                        </button>
                                        @if(!$ticket->is_used)
                                        <button type="button" class="btn btn-outline-info btn-sm" onclick="printTicket('{{ $ticket->id }}')">
                                            <i class="ri-printer-line me-1"></i>Print Tiket
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="ri-ticket-line font-size-48 text-muted"></i>
                        <h5 class="mt-3">Belum ada tiket</h5>
                        <p class="text-muted">Tiket akan di-generate setelah booking dikonfirmasi</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Usage Statistics -->
    @if($booking->tickets->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-bar-chart-line me-2"></i>Statistik Penggunaan Tiket
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <h4 class="text-primary">{{ $booking->tickets->count() }}</h4>
                            <p class="text-muted mb-0">Total Tiket</p>
                        </div>
                        <div class="col-md-3">
                            <h4 class="text-success">{{ $booking->tickets->where('is_used', true)->count() }}</h4>
                            <p class="text-muted mb-0">Terpakai</p>
                        </div>
                        <div class="col-md-3">
                            <h4 class="text-warning">{{ $booking->tickets->where('is_used', false)->count() }}</h4>
                            <p class="text-muted mb-0">Belum Terpakai</p>
                        </div>
                        <div class="col-md-3">
                            @php
                                $usagePercentage = $booking->tickets->count() > 0 
                                    ? round(($booking->tickets->where('is_used', true)->count() / $booking->tickets->count()) * 100) 
                                    : 0;
                            @endphp
                            <h4 class="text-info">{{ $usagePercentage }}%</h4>
                            <p class="text-muted mb-0">Tingkat Penggunaan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
function resendAllTickets() {
    if (confirm('Kirim ulang semua tiket ke email pengunjung?')) {
        fetch(`{{ route('admin.reports.resend-ticket', $booking->id) }}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Semua tiket berhasil dikirim ulang!');
            } else {
                alert('Gagal mengirim tiket: ' + data.message);
            }
        });
    }
}

function downloadTicket(ticketId) {
    window.open(`/admin/tickets/${ticketId}/download`, '_blank');
}

function printTicket(ticketId) {
    window.open(`/admin/tickets/${ticketId}/print`, '_blank');
}
</script>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline:before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #e9ecef;
}

.timeline-content {
    margin-left: 10px;
}
</style>
@endsection