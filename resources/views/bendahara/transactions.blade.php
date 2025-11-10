@extends('layouts.app')

@section('title', 'Daftar Transaksi')

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Daftar Transaksi</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-muted" href="{{ route('bendahara.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Transaksi</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>
                                <input type="checkbox" id="select-all">
                            </th>
                            <th>Tanggal</th>
                            <th>Kode Booking</th>
                            <th>Pengunjung</th>
                            <th>Paket</th>
                            <th>Total</th>
                            <th>Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr>
                            <td>
                                @if(!$transaction->verified_at)
                                <input type="checkbox" class="transaction-checkbox" value="{{ $transaction->id }}">
                                @endif
                            </td>
                            <td>{{ $transaction->created_at->format('d/m/Y') }}</td>
                            <td><strong>{{ $transaction->booking_code }}</strong></td>
                            <td>{{ $transaction->visitor_name }}</td>
                            <td>{{ $transaction->wisataPackage->name }}</td>
                            <td>{{ 'Rp ' . number_format($transaction->total_amount, 0, ',', '.') }}</td>
                            <td>
                                @if($transaction->verified_at)
                                    <span class="badge bg-success">
                                        <i class="ti ti-check"></i> Terverifikasi
                                    </span><br>
                                    <small class="text-muted">{{ $transaction->verified_at->format('d/m/Y H:i') }}</small>
                                @else
                                    <span class="badge bg-warning">Belum Verifikasi</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada transaksi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($transactions->count() > 0)
            <div class="mt-3">
                <button type="button" id="verify-selected" class="btn btn-success">
                    <i class="ti ti-check"></i> Verifikasi Terpilih
                </button>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all checkbox
    document.getElementById('select-all')?.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.transaction-checkbox');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });

    // Verify selected
    document.getElementById('verify-selected')?.addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('.transaction-checkbox:checked');
        const ids = Array.from(checkboxes).map(cb => cb.value);
        
        if (ids.length === 0) {
            alert('Pilih minimal satu transaksi untuk diverifikasi');
            return;
        }

        if (!confirm(`Verifikasi ${ids.length} transaksi?`)) {
            return;
        }

        // Send verification request
        fetch('{{ route("bendahara.verify.report") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ booking_ids: ids })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Gagal memverifikasi transaksi');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    });
});
</script>
@endpush
@endsection

