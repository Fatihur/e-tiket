@extends('layouts.app')

@section('title', 'Tiket Tervalidasi')

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Tiket Tervalidasi</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-muted" href="{{ route('petugas.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tiket Tervalidasi</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Tickets Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Kode Tiket</th>
                            <th>Booking</th>
                            <th>Pengunjung</th>
                            <th>Paket Wisata</th>
                            <th>Waktu Scan</th>
                            <th>Petugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                        <tr>
                            <td><code>{{ $ticket->ticket_code }}</code></td>
                            <td>{{ $ticket->booking->booking_code }}</td>
                            <td>
                                {{ $ticket->booking->visitor_name }}<br>
                                <small class="text-muted">{{ $ticket->booking->visitor_email }}</small>
                            </td>
                            <td>{{ $ticket->booking->wisataPackage->name }}</td>
                            <td>{{ $ticket->used_at->format('d/m/Y H:i:s') }}</td>
                            <td>{{ $ticket->scanner->name }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada tiket tervalidasi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $tickets->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

