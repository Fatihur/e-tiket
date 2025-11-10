@extends('layouts.app')

@section('title', 'Detail Booking')

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Detail Booking</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-muted" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a class="text-muted" href="{{ route('admin.bookings') }}">Booking</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Booking Info -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informasi Booking</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="200">Kode Booking</th>
                            <td><strong>{{ $booking->booking_code }}</strong></td>
                        </tr>
                        <tr>
                            <th>Paket Wisata</th>
                            <td>{{ $booking->wisataPackage->name }}</td>
                        </tr>
                        <tr>
                            <th>Nama Pengunjung</th>
                            <td>{{ $booking->visitor_name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $booking->visitor_email }}</td>
                        </tr>
                        <tr>
                            <th>No. Telepon</th>
                            <td>{{ $booking->visitor_phone }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Kunjungan</th>
                            <td>{{ $booking->visit_date->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Pengunjung</th>
                            <td>{{ $booking->quantity }} orang</td>
                        </tr>
                        <tr>
                            <th>Total Pembayaran</th>
                            <td><strong>{{ $booking->formatted_total_amount }}</strong></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($booking->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($booking->status == 'confirmed')
                                    <span class="badge bg-success">Confirmed</span>
                                @elseif($booking->status == 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @else
                                    <span class="badge bg-secondary">Expired</span>
                                @endif
                            </td>
                        </tr>
                        @if($booking->validated_by)
                        <tr>
                            <th>Divalidasi Oleh</th>
                            <td>{{ $booking->validator->name }} - {{ $booking->validated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @endif
                        @if($booking->notes)
                        <tr>
                            <th>Catatan</th>
                            <td>{{ $booking->notes }}</td>
                        </tr>
                        @endif
                    </table>

                    @if($booking->status == 'pending')
                    <div class="mt-4">
                        <h5>Validasi Booking</h5>
                        <form action="{{ route('admin.bookings.approve', $booking->id) }}" method="POST" class="d-inline">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Catatan (Opsional)</label>
                                <textarea name="notes" class="form-control" rows="2"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success" onclick="return confirm('Setujui booking ini?')">
                                <i class="ti ti-check"></i> Setujui Booking
                            </button>
                        </form>
                        
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            <i class="ti ti-x"></i> Tolak Booking
                        </button>
                    </div>
                    @endif

                    @if($booking->status == 'confirmed' && $booking->tickets->count() > 0)
                    <div class="mt-4">
                        <h5>Tiket yang Digenerate</h5>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Kode Tiket</th>
                                        <th>Status</th>
                                        <th>Waktu Scan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($booking->tickets as $ticket)
                                    <tr>
                                        <td><code>{{ $ticket->ticket_code }}</code></td>
                                        <td>
                                            @if($ticket->is_used)
                                                <span class="badge bg-success">Sudah Digunakan</span>
                                            @else
                                                <span class="badge bg-warning">Belum Digunakan</span>
                                            @endif
                                        </td>
                                        <td>{{ $ticket->used_at ? $ticket->used_at->format('d/m/Y H:i') : '-' }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="showQRCode({{ $ticket->id }}, '{{ addslashes($ticket->qr_code) }}')">
                                                <i class="ti ti-qrcode"></i> Lihat QR
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Payment Proof -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Bukti Pembayaran</h5>
                </div>
                <div class="card-body text-center">
                    @if($booking->payment_proof)
                        <img src="{{ Storage::url($booking->payment_proof) }}" class="img-fluid rounded" alt="Bukti Pembayaran">
                        <div class="mt-3">
                            <a href="{{ Storage::url($booking->payment_proof) }}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="ti ti-external-link"></i> Lihat Fullscreen
                            </a>
                        </div>
                    @else
                        <p class="text-muted">Tidak ada bukti pembayaran</p>
                    @endif
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <a href="{{ route('admin.bookings') }}" class="btn btn-secondary w-100">
                        <i class="ti ti-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.bookings.reject', $booking->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tolak Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea name="notes" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Booking</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- QR Code Modal -->
<div class="modal fade" id="qrModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">QR Code Tiket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <div id="qrcode" class="d-flex justify-content-center mb-3"></div>
                <p class="text-muted mb-0">Scan QR Code ini untuk validasi tiket</p>
                <div class="mt-3">
                    <small class="text-muted" id="qrDataText"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
let currentQR = null;

function showQRCode(ticketId, qrData) {
    // Clear previous QR code
    document.getElementById('qrcode').innerHTML = '';
    
    // Show QR data text
    document.getElementById('qrDataText').textContent = qrData;
    
    // Generate new QR code
    currentQR = new QRCode(document.getElementById('qrcode'), {
        text: qrData,
        width: 256,
        height: 256,
        colorDark: '#000000',
        colorLight: '#ffffff',
        correctLevel: QRCode.CorrectLevel.H
    });
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('qrModal'));
    modal.show();
}
</script>
@endpush
@endsection

