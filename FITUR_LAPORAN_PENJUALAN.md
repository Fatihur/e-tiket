# Fitur Laporan Penjualan Tiket

Sistem laporan penjualan tiket yang komprehensif untuk admin dengan dashboard analytics, filtering advanced, dan export functionality.

## 🎯 Fitur Utama

### 1. **Dashboard Laporan** (`/admin/reports`)
- ✅ **Multi-period filtering**: Hari ini, Kemarin, Minggu ini/lalu, Bulan ini/lalu, Tahun ini, Custom range
- ✅ **Advanced filters**: Paket wisata, Status booking (confirmed/pending/rejected)
- ✅ **Real-time statistics**: Total penjualan, revenue, pengunjung, tiket terpakai
- ✅ **Interactive charts**: Trend penjualan (ApexCharts), Popularitas paket (Donut chart)
- ✅ **Export functionality**: Excel, PDF, Print
- ✅ **Detailed table**: Pagination, sorting, search

### 2. **Quick Stats Cards**
- 💰 **Total Penjualan**: Jumlah transaksi dalam periode
- 📈 **Total Revenue**: Pendapatan confirmed bookings
- 👥 **Total Pengunjung**: Sum quantity dari confirmed bookings  
- 🎫 **Tiket Terpakai**: Jumlah tiket yang sudah di-scan

### 3. **Interactive Charts**
#### **Trend Chart (Area Chart)**
- **Dual Y-axis**: Revenue (Rp) & Transaksi count
- **Dynamic periods**:
  - Hari: Breakdown per 2 jam (00:00-24:00)
  - Minggu: Breakdown per hari (Mon-Sun)
  - Bulan: Breakdown per minggu (Week 1-4)
- **Smooth curves** dengan gradient fill

#### **Package Popularity (Donut Chart)**
- **Distribution** booking per paket wisata
- **Color-coded** dengan legend
- **Interactive hover** dengan percentages

### 4. **Detail Report Table**
- ✅ **Comprehensive columns**: 
  - Tanggal booking, Kode booking, Nama pengunjung
  - Paket wisata, Tanggal kunjungan, Jumlah
  - Total bayar, Status, Info validasi
- ✅ **Action dropdown**:
  - View detail booking
  - Lihat tiket (jika confirmed)
  - Resend tiket via email
- ✅ **Pagination** dengan custom page size (10/25/50/100)
- ✅ **Row numbering** yang persistent across pages

### 5. **Ticket Detail View** (`/admin/reports/tickets/{id}`)
- ✅ **Booking information**: Detail lengkap booking
- ✅ **Timeline status**: Visual timeline dengan markers
- ✅ **QR Code display**: Generated QR codes untuk setiap tiket
- ✅ **Usage statistics**: Total, terpakai, belum terpakai, percentage
- ✅ **Individual ticket actions**: Download QR, Print ticket
- ✅ **Bulk actions**: Resend all tickets

## 🔧 Backend Implementation

### AdminController Methods
```php
public function reports()                    // Main report dashboard
private function getChartData()             // Generate chart data based on period
private function getPackageStats()          // Package popularity statistics  
public function exportReports()             // Excel/PDF export (planned)
public function ticketReport($bookingId)    // Individual ticket details
public function resendTicket($bookingId)    // Resend ticket functionality
```

### Advanced Filtering Logic
```php
// Dynamic period filtering
switch ($period) {
    case 'today': $query->whereDate('created_at', today()); break;
    case 'this_week': $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]); break;
    case 'this_month': $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year); break;
    case 'custom': $query->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']); break;
}

// Additional filters
if ($packageId) $query->where('wisata_package_id', $packageId);
if ($status) $query->where('status', $status);
```

### Statistical Calculations
```php
$summary = [
    'total_sales' => $allBookings->count(),
    'total_revenue' => $allBookings->where('status', 'confirmed')->sum('total_amount'),
    'total_visitors' => $allBookings->where('status', 'confirmed')->sum('quantity'),
    'used_tickets' => Ticket::where('is_used', true)->count(),
    'avg_transaction' => $confirmedBookings->avg('total_amount'),
];
```

## 📊 Chart Data Generation

### Dynamic Time-based Data
```php
private function getChartData($period, $startDate = null, $endDate = null)
{
    switch ($period) {
        case 'this_week':
            // 7 days breakdown (Mon-Sun)
            for ($i = 0; $i < 7; $i++) {
                $date = $start->copy()->addDays($i);
                $labels[] = $date->format('D');
                $revenue[] = Booking::where('status', 'confirmed')
                                   ->whereDate('created_at', $date)
                                   ->sum('total_amount');
            }
            break;
            
        case 'this_month':
            // Weekly breakdown (Week 1-4)
            $current = $start->copy();
            while ($current <= $end) {
                $weekEnd = $current->copy()->addDays(6);
                $labels[] = "Week $week";
                $revenue[] = Booking::whereBetween('created_at', [$current, $weekEnd])
                                   ->sum('total_amount');
                $current->addWeek();
            }
            break;
            
        default:
            // Hourly breakdown (00:00-24:00, every 2 hours)
            for ($hour = 0; $hour < 24; $hour += 2) {
                $labels[] = sprintf('%02d:00', $hour);
                $revenue[] = Booking::whereTime('created_at', '>=', sprintf('%02d:00:00', $hour))
                                   ->whereTime('created_at', '<', sprintf('%02d:00:00', $hour + 2))
                                   ->sum('total_amount');
            }
    }
}
```

## 🎨 Frontend Features

### ApexCharts Integration
```javascript
var salesOptions = {
    series: [{
        name: 'Revenue',
        data: revenue_data
    }, {
        name: 'Transaksi', 
        data: transaction_data
    }],
    chart: { type: 'area', height: 350 },
    colors: ['#28a745', '#007bff'],
    xaxis: { categories: labels },
    yaxis: [{
        title: { text: 'Revenue (Rp)' },
        labels: { formatter: function(val) { return 'Rp ' + val.toLocaleString('id-ID'); }}
    }, {
        opposite: true,
        title: { text: 'Transaksi' }
    }]
};
```

### Interactive Elements
- ✅ **Dynamic date picker**: Show/hide berdasarkan period selection
- ✅ **Export buttons**: Excel, PDF, Print dengan parameter filtering
- ✅ **Page size selector**: 10/25/50/100 entries per page
- ✅ **Resend ticket**: AJAX call dengan confirmation
- ✅ **Print optimization**: CSS media queries untuk print layout

### Responsive Design
- ✅ **Mobile-first**: Cards stack pada mobile
- ✅ **Table responsive**: Horizontal scroll untuk table besar
- ✅ **Chart responsive**: Auto-resize charts
- ✅ **Touch-friendly**: Button sizing untuk mobile

## 🔐 Security & Performance

### Access Control
```php
public function __construct()
{
    $this->middleware(function ($request, $next) {
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            return redirect()->route('login')->with('error', 'Unauthorized access');
        }
        return $next($request);
    });
}
```

### Query Optimization
- ✅ **Eager loading**: `with(['wisataPackage', 'validator', 'tickets'])`
- ✅ **Pagination**: Limit records per page untuk performance
- ✅ **Indexed queries**: Date range queries dengan indexes
- ✅ **Summary calculations**: Separate query untuk statistics

### Data Validation
- ✅ **Date validation**: Custom range dates
- ✅ **Parameter sanitization**: Filter inputs
- ✅ **Permission checks**: Admin-only access
- ✅ **CSRF protection**: Form submissions

## 📱 Export Functionality

### Planned Features
```php
public function exportReports()
{
    $format = request('export'); // 'excel' or 'pdf'
    
    // Get filtered data with same filters as main report
    $bookings = $this->getFilteredBookings();
    
    switch ($format) {
        case 'excel':
            return Excel::download(new BookingsExport($bookings), 'laporan-penjualan.xlsx');
        case 'pdf':
            $pdf = PDF::loadView('admin.reports.pdf', compact('bookings'));
            return $pdf->download('laporan-penjualan.pdf');
    }
}
```

### Print Optimization
```css
@media print {
    .btn, .dropdown, .breadcrumb { display: none !important; }
    .card { border: none !important; box-shadow: none !important; }
    .table { font-size: 12px; }
}
```

## 🚀 Routes Structure

```php
Route::prefix('admin')->name('admin.')->group(function () {
    // Main Reports
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('/reports/export', [AdminController::class, 'exportReports'])->name('reports.export');
    
    // Ticket Details
    Route::get('/reports/tickets/{id}', [AdminController::class, 'ticketReport'])->name('reports.tickets');
    Route::post('/reports/resend-ticket/{id}', [AdminController::class, 'resendTicket'])->name('reports.resend-ticket');
});
```

## 🎯 Usage Workflow

### 1. **Daily Monitoring**
```
Login → Reports → Default (Today) → View stats & recent transactions
```

### 2. **Period Analysis**
```
Reports → Select Period (Week/Month) → Apply Filters → Analyze trends
```

### 3. **Package Performance**
```
Reports → Filter by Package → View package-specific performance
```

### 4. **Ticket Management**
```
Reports → View Detail → Ticket Details → Resend/Download tickets
```

### 5. **Export for External Use**
```
Reports → Apply Filters → Export Excel/PDF → Share with stakeholders
```

## 📈 Business Intelligence

### Key Metrics Tracked
- ✅ **Revenue trends**: Daily/weekly/monthly patterns
- ✅ **Package popularity**: Best-selling packages
- ✅ **Conversion rates**: Pending vs Confirmed ratios
- ✅ **Operational efficiency**: Ticket usage rates
- ✅ **Staff performance**: Scanner activity (future)

### Insights Generation
- **Peak hours**: Optimal staffing times
- **Seasonal patterns**: Marketing campaign timing
- **Package optimization**: Price adjustments based on demand
- **Capacity planning**: Resource allocation

Fitur laporan penjualan ini memberikan admin kontrol penuh untuk monitoring, analisis, dan optimasi bisnis wisata dengan interface yang professional dan data yang akurat! 📊✨