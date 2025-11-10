@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Laporan Penjualan</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-muted" href="{{ route('owner.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Laporan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Period Filter -->
    <div class="card">
        <div class="card-body">
            <form method="GET" action="{{ route('owner.reports') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Periode</label>
                    <select name="period" class="form-select" onchange="this.form.submit()">
                        <option value="daily" {{ $period == 'daily' ? 'selected' : '' }}>Harian (30 Hari)</option>
                        <option value="weekly" {{ $period == 'weekly' ? 'selected' : '' }}>Mingguan (12 Minggu)</option>
                        <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Bulanan (12 Bulan)</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- Report Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Periode</th>
                            <th class="text-end">Pendapatan</th>
                            <th class="text-end">Pengunjung</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalRevenue = 0;
                            $totalVisitors = 0;
                        @endphp
                        @foreach($data as $item)
                        @php
                            $totalRevenue += $item['revenue'];
                            $totalVisitors += $item['visitors'];
                        @endphp
                        <tr>
                            <td>{{ $item['date'] }}</td>
                            <td class="text-end">{{ 'Rp ' . number_format($item['revenue'], 0, ',', '.') }}</td>
                            <td class="text-end">{{ number_format($item['visitors'], 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th>Total</th>
                            <th class="text-end">{{ 'Rp ' . number_format($totalRevenue, 0, ',', '.') }}</th>
                            <th class="text-end">{{ number_format($totalVisitors, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

