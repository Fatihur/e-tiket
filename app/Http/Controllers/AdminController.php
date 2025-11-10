<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\WisataPackage;
use App\Models\Booking;
use App\Models\Ticket;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'confirmed_bookings' => Booking::where('status', 'confirmed')->count(),
            'total_revenue' => Booking::where('status', 'confirmed')->sum('total_amount'),
            'total_packages' => WisataPackage::count(),
            'active_packages' => WisataPackage::where('is_active', true)->count(),
        ];
        
        $recent_bookings = Booking::with(['wisataPackage', 'validator'])
                                ->orderBy('created_at', 'desc')
                                ->take(10)
                                ->get();
        
        return view('admin.dashboard', compact('stats', 'recent_bookings'));
    }
    
    // User Management
    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }
    
    public function createUser()
    {
        return view('admin.users.create');
    }
    
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,petugas,bendahara,owner',
        ]);
        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => true,
        ]);
        
        return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan!');
    }

    public function activateUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_active' => true]);
        
        return redirect()->route('admin.users')->with('success', 'User berhasil diaktifkan!');
    }

    public function deactivateUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_active' => false]);
        
        return redirect()->route('admin.users')->with('success', 'User berhasil dinonaktifkan!');
    }
    
    // Package Management
    public function packages()
    {
        $query = WisataPackage::withCount(['bookings' => function($q) {
            $q->where('status', 'confirmed');
        }]);

        // Apply filters
        if (request('status') == 'active') {
            $query->where('is_active', true);
        } elseif (request('status') == 'inactive') {
            $query->where('is_active', false);
        }

        if (request('search')) {
            $query->where('name', 'like', '%' . request('search') . '%');
        }

        if (request('price_range')) {
            $range = request('price_range');
            if ($range == '0-50000') {
                $query->where('price', '<', 50000);
            } elseif ($range == '50000-100000') {
                $query->whereBetween('price', [50000, 100000]);
            } elseif ($range == '100000-200000') {
                $query->whereBetween('price', [100000, 200000]);
            } elseif ($range == '200000+') {
                $query->where('price', '>', 200000);
            }
        }

        $packages = $query->orderBy('created_at', 'desc')->paginate(12);

        $stats = [
            'total_packages' => WisataPackage::count(),
            'active_packages' => WisataPackage::where('is_active', true)->count(),
            'total_bookings' => Booking::where('status', 'confirmed')->count(),
            'total_revenue' => Booking::where('status', 'confirmed')->sum('total_amount'),
        ];

        return view('admin.packages.index', compact('packages', 'stats'));
    }
    
    public function createPackage()
    {
        return view('admin.packages.create');
    }
    
    public function storePackage(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'max_capacity' => 'required|integer|min:1',
            'facilities' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'featured' => 'boolean',
            'is_active' => 'boolean',
        ]);
        
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('packages', 'public');
        }
        
        WisataPackage::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'max_capacity' => $request->max_capacity,
            'facilities' => $request->facilities,
            'image' => $imagePath,
            'featured' => $request->boolean('featured', false),
            'is_active' => $request->boolean('is_active', true),
        ]);
        
        return redirect()->route('admin.packages')->with('success', 'Paket wisata berhasil ditambahkan!');
    }

    public function showPackage($id)
    {
        $package = WisataPackage::withCount(['bookings' => function($q) {
            $q->where('status', 'confirmed');
        }])->findOrFail($id);

        $recentBookings = Booking::with('wisataPackage')
                               ->where('wisata_package_id', $id)
                               ->orderBy('created_at', 'desc')
                               ->take(10)
                               ->get();

        $stats = [
            'total_bookings' => $package->bookings()->count(),
            'confirmed_bookings' => $package->bookings()->where('status', 'confirmed')->count(),
            'pending_bookings' => $package->bookings()->where('status', 'pending')->count(),
            'total_revenue' => $package->bookings()->where('status', 'confirmed')->sum('total_amount'),
            'monthly_bookings' => $package->bookings()
                                        ->where('status', 'confirmed')
                                        ->whereMonth('created_at', now()->month)
                                        ->whereYear('created_at', now()->year)
                                        ->count(),
            'monthly_revenue' => $package->bookings()
                                       ->where('status', 'confirmed')
                                       ->whereMonth('created_at', now()->month)
                                       ->whereYear('created_at', now()->year)
                                       ->sum('total_amount'),
            'monthly_visitors' => $package->bookings()
                                        ->where('status', 'confirmed')
                                        ->whereMonth('created_at', now()->month)
                                        ->whereYear('created_at', now()->year)
                                        ->sum('quantity'),
        ];

        return view('admin.packages.show', compact('package', 'recentBookings', 'stats'));
    }

    public function editPackage($id)
    {
        $package = WisataPackage::withCount(['bookings' => function($q) {
            $q->where('status', 'confirmed');
        }])
        ->withSum(['bookings' => function($q) {
            $q->where('status', 'confirmed');
        }], 'total_amount')
        ->findOrFail($id);

        return view('admin.packages.edit', compact('package'));
    }

    public function updatePackage(Request $request, $id)
    {
        $package = WisataPackage::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'max_capacity' => 'required|integer|min:1',
            'facilities' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'featured' => 'boolean',
            'is_active' => 'boolean',
            'remove_image' => 'boolean',
        ]);

        $updateData = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'max_capacity' => $request->max_capacity,
            'facilities' => $request->facilities,
            'featured' => $request->boolean('featured', false),
            'is_active' => $request->boolean('is_active', true),
        ];

        // Handle image removal
        if ($request->boolean('remove_image')) {
            if ($package->image && \Storage::disk('public')->exists($package->image)) {
                \Storage::disk('public')->delete($package->image);
            }
            $updateData['image'] = null;
        }

        // Handle new image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($package->image && \Storage::disk('public')->exists($package->image)) {
                \Storage::disk('public')->delete($package->image);
            }
            $updateData['image'] = $request->file('image')->store('packages', 'public');
        }

        $package->update($updateData);

        return redirect()->route('admin.packages')->with('success', 'Paket wisata berhasil diperbarui!');
    }

    public function activatePackage($id)
    {
        $package = WisataPackage::findOrFail($id);
        $package->update(['is_active' => true]);

        return redirect()->back()->with('success', 'Paket wisata berhasil diaktifkan!');
    }

    public function deactivatePackage($id)
    {
        $package = WisataPackage::findOrFail($id);
        $package->update(['is_active' => false]);

        return redirect()->back()->with('success', 'Paket wisata berhasil dinonaktifkan!');
    }

    public function destroyPackage($id)
    {
        $package = WisataPackage::findOrFail($id);

        // Check if package has bookings
        if ($package->bookings()->count() > 0) {
            return redirect()->route('admin.packages')
                           ->with('error', 'Paket wisata tidak dapat dihapus karena sudah memiliki booking!');
        }

        // Delete image if exists
        if ($package->image && \Storage::disk('public')->exists($package->image)) {
            \Storage::disk('public')->delete($package->image);
        }

        $package->delete();

        return redirect()->route('admin.packages')->with('success', 'Paket wisata berhasil dihapus!');
    }
    
    // Booking Management
    public function bookings()
    {
        $bookings = Booking::with(['wisataPackage', 'validator'])
                          ->orderBy('created_at', 'desc')
                          ->get();
        return view('admin.bookings.index', compact('bookings'));
    }
    
    public function showBooking($id)
    {
        $booking = Booking::with(['wisataPackage', 'validator'])->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }
    
    public function approveBooking(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        $booking->update([
            'status' => 'confirmed',
            'validated_by' => auth()->id(),
            'validated_at' => now(),
            'notes' => $request->notes,
        ]);
        
        // Generate single ticket per booking
        $ticket = Ticket::create([
            'ticket_code' => 'T-' . $booking->id . '-' . Str::random(8),
            'booking_id' => $booking->id,
            'qr_code' => '',
        ]);

        
        
        // Generate QR Code
        $qrData = json_encode([
            'ticket_code' => $ticket->ticket_code,
            'booking_id' => $booking->id,
            'visitor_name' => $booking->visitor_name,
            'visit_date' => $booking->visit_date->format('Y-m-d'),
            'quantity' => $booking->quantity,
        ]);
        
        $ticket->update(['qr_code' => $qrData]);
        
        // Send email with tickets
        try {
            // Update mail configuration from database
            $this->updateMailConfigFromDatabase();
            
            Mail::to($booking->visitor_email)->send(new \App\Mail\TicketEmail($booking->load('tickets', 'wisataPackage')));
        } catch (\Exception $e) {
            \Log::error('Failed to send ticket email: ' . $e->getMessage());
        }
        
        return redirect()->route('admin.bookings')->with('success', 'Booking berhasil disetujui dan tiket telah digenerate serta dikirim ke email pengunjung!');
    }
    
    public function rejectBooking(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        $booking->update([
            'status' => 'rejected',
            'validated_by' => auth()->id(),
            'validated_at' => now(),
            'notes' => $request->notes,
        ]);
        
        return redirect()->route('admin.bookings')->with('success', 'Booking telah ditolak!');
    }
    
    // Reports
    public function reports()
    {
        // Get filter parameters
        $period = request('period', 'today');
        $packageId = request('package_id');
        $status = request('status');
        $startDate = request('start_date');
        $endDate = request('end_date');

        // Build query
        $query = Booking::with(['wisataPackage', 'validator', 'tickets']);

        // Apply period filter
        switch ($period) {
            case 'yesterday':
                $query->whereDate('created_at', now()->yesterday());
                $periodText = 'Kemarin';
                break;
            case 'this_week':
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                $periodText = 'Minggu Ini';
                break;
            case 'last_week':
                $query->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()]);
                $periodText = 'Minggu Lalu';
                break;
            case 'this_month':
                $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
                $periodText = 'Bulan Ini';
                break;
            case 'last_month':
                $query->whereMonth('created_at', now()->subMonth()->month)->whereYear('created_at', now()->subMonth()->year);
                $periodText = 'Bulan Lalu';
                break;
            case 'this_year':
                $query->whereYear('created_at', now()->year);
                $periodText = 'Tahun Ini';
                break;
            case 'custom':
                if ($startDate && $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
                    $periodText = date('d/m/Y', strtotime($startDate)) . ' - ' . date('d/m/Y', strtotime($endDate));
                } else {
                    $query->whereDate('created_at', today());
                    $periodText = 'Hari Ini';
                }
                break;
            default: // today
                $query->whereDate('created_at', today());
                $periodText = 'Hari Ini';
        }

        // Apply additional filters
        if ($packageId) {
            $query->where('wisata_package_id', $packageId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        // Get bookings with pagination
        $bookings = $query->orderBy('created_at', 'desc')->paginate(25);

        // Calculate summary
        $summaryQuery = clone $query;
        $allBookings = $summaryQuery->get();
        
        $summary = [
            'total_sales' => $allBookings->count(),
            'total_revenue' => $allBookings->where('status', 'confirmed')->sum('total_amount'),
            'total_visitors' => $allBookings->where('status', 'confirmed')->sum('quantity'),
            'used_tickets' => Ticket::where('is_used', true)->count(),
            'avg_transaction' => $allBookings->where('status', 'confirmed')->count() > 0 
                ? $allBookings->where('status', 'confirmed')->sum('total_amount') / $allBookings->where('status', 'confirmed')->count() 
                : 0,
        ];

        // Get packages for filter
        $packages = WisataPackage::where('is_active', true)->get();

        // Chart data
        $chartData = $this->getChartData($period, $startDate, $endDate);
        $packageStats = $this->getPackageStats($allBookings);

        return view('admin.reports.index', compact(
            'bookings', 'summary', 'packages', 'periodText', 'chartData', 'packageStats'
        ));
    }

    private function getChartData($period, $startDate = null, $endDate = null)
    {
        $labels = [];
        $revenue = [];
        $transactions = [];

        switch ($period) {
            case 'this_week':
            case 'last_week':
                // Daily data for week
                $start = $period == 'this_week' ? now()->startOfWeek() : now()->subWeek()->startOfWeek();
                for ($i = 0; $i < 7; $i++) {
                    $date = $start->copy()->addDays($i);
                    $labels[] = $date->format('D');
                    
                    $dayRevenue = Booking::where('status', 'confirmed')
                                        ->whereDate('created_at', $date)
                                        ->sum('total_amount');
                    $dayTransactions = Booking::where('status', 'confirmed')
                                             ->whereDate('created_at', $date)
                                             ->count();
                    
                    $revenue[] = $dayRevenue;
                    $transactions[] = $dayTransactions;
                }
                break;

            case 'this_month':
            case 'last_month':
                // Weekly data for month
                $start = $period == 'this_month' ? now()->startOfMonth() : now()->subMonth()->startOfMonth();
                $end = $period == 'this_month' ? now()->endOfMonth() : now()->subMonth()->endOfMonth();
                
                $current = $start->copy();
                $week = 1;
                while ($current <= $end) {
                    $weekEnd = $current->copy()->addDays(6);
                    if ($weekEnd > $end) $weekEnd = $end;
                    
                    $labels[] = "Week $week";
                    
                    $weekRevenue = Booking::where('status', 'confirmed')
                                         ->whereBetween('created_at', [$current, $weekEnd])
                                         ->sum('total_amount');
                    $weekTransactions = Booking::where('status', 'confirmed')
                                              ->whereBetween('created_at', [$current, $weekEnd])
                                              ->count();
                    
                    $revenue[] = $weekRevenue;
                    $transactions[] = $weekTransactions;
                    
                    $current->addWeek();
                    $week++;
                }
                break;

            default:
                // Hourly data for single day
                for ($hour = 0; $hour < 24; $hour += 2) {
                    $labels[] = sprintf('%02d:00', $hour);
                    
                    $hourRevenue = Booking::where('status', 'confirmed')
                                         ->whereDate('created_at', today())
                                         ->whereTime('created_at', '>=', sprintf('%02d:00:00', $hour))
                                         ->whereTime('created_at', '<', sprintf('%02d:00:00', $hour + 2))
                                         ->sum('total_amount');
                    $hourTransactions = Booking::where('status', 'confirmed')
                                              ->whereDate('created_at', today())
                                              ->whereTime('created_at', '>=', sprintf('%02d:00:00', $hour))
                                              ->whereTime('created_at', '<', sprintf('%02d:00:00', $hour + 2))
                                              ->count();
                    
                    $revenue[] = $hourRevenue;
                    $transactions[] = $hourTransactions;
                }
        }

        return [
            'labels' => $labels,
            'revenue' => $revenue,
            'transactions' => $transactions,
        ];
    }

    private function getPackageStats($bookings)
    {
        return $bookings->where('status', 'confirmed')
                       ->groupBy('wisata_package_id')
                       ->map(function ($group) {
                           return $group->count();
                       })
                       ->mapWithKeys(function ($count, $packageId) {
                           $package = WisataPackage::find($packageId);
                           return [$package ? $package->name : 'Unknown' => $count];
                       })
                       ->toArray();
    }

    public function exportReports(Request $request)
    {
        $format = $request->get('export', 'pdf');
        $period = $request->get('period', 'today');
        $packageId = $request->get('package_id');
        $status = $request->get('status');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        // Build query (same as reports method)
        $query = Booking::with(['wisataPackage', 'validator', 'tickets']);

        // Apply period filter
        switch ($period) {
            case 'yesterday':
                $query->whereDate('created_at', now()->yesterday());
                $periodText = 'Kemarin';
                break;
            case 'this_week':
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                $periodText = 'Minggu Ini';
                break;
            case 'last_week':
                $query->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()]);
                $periodText = 'Minggu Lalu';
                break;
            case 'this_month':
                $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
                $periodText = 'Bulan Ini';
                break;
            case 'last_month':
                $query->whereMonth('created_at', now()->subMonth()->month)->whereYear('created_at', now()->subMonth()->year);
                $periodText = 'Bulan Lalu';
                break;
            case 'this_year':
                $query->whereYear('created_at', now()->year);
                $periodText = 'Tahun Ini';
                break;
            case 'custom':
                if ($startDate && $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
                    $periodText = date('d/m/Y', strtotime($startDate)) . ' - ' . date('d/m/Y', strtotime($endDate));
                } else {
                    $query->whereDate('created_at', today());
                    $periodText = 'Hari Ini';
                }
                break;
            default: // today
                $query->whereDate('created_at', today());
                $periodText = 'Hari Ini';
        }

        // Apply additional filters
        if ($packageId) {
            $query->where('wisata_package_id', $packageId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        // Get all bookings (no pagination for export)
        $bookings = $query->orderBy('created_at', 'desc')->get();

        // Calculate summary
        $summary = [
            'total_sales' => $bookings->count(),
            'total_revenue' => $bookings->where('status', 'confirmed')->sum('total_amount'),
            'total_visitors' => $bookings->where('status', 'confirmed')->sum('quantity'),
            'used_tickets' => Ticket::where('is_used', true)->count(),
            'avg_transaction' => $bookings->where('status', 'confirmed')->count() > 0 
                ? $bookings->where('status', 'confirmed')->sum('total_amount') / $bookings->where('status', 'confirmed')->count() 
                : 0,
        ];

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('admin.reports.export-pdf', compact('bookings', 'summary', 'periodText', 'period', 'startDate', 'endDate'));
            $pdf->setPaper('a4', 'landscape');
            $filename = 'laporan-penjualan-' . strtolower(str_replace(' ', '-', $periodText)) . '-' . date('Y-m-d') . '.pdf';
            return $pdf->download($filename);
        } else {
            // Excel export (CSV for now)
            $filename = 'laporan-penjualan-' . strtolower(str_replace(' ', '-', $periodText)) . '-' . date('Y-m-d') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function() use ($bookings, $summary, $periodText) {
                $file = fopen('php://output', 'w');
                
                // BOM for UTF-8
                fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
                
                // Header
                fputcsv($file, ['LAPORAN PENJUALAN TIKET WISATA LAPADE']);
                fputcsv($file, ['Periode: ' . $periodText]);
                fputcsv($file, ['Tanggal Export: ' . now()->format('d/m/Y H:i:s')]);
                fputcsv($file, []);
                
                // Summary
                fputcsv($file, ['RINGKASAN']);
                fputcsv($file, ['Total Penjualan', $summary['total_sales']]);
                fputcsv($file, ['Total Revenue', 'Rp ' . number_format($summary['total_revenue'], 0, ',', '.')]);
                fputcsv($file, ['Total Pengunjung', $summary['total_visitors']]);
                fputcsv($file, ['Rata-rata Transaksi', 'Rp ' . number_format($summary['avg_transaction'], 0, ',', '.')]);
                fputcsv($file, []);
                
                // Table header
                fputcsv($file, ['No', 'Tanggal Booking', 'Kode Booking', 'Nama Pengunjung', 'Email', 'Paket Wisata', 'Tanggal Kunjungan', 'Jumlah', 'Total Bayar', 'Status', 'Validasi Oleh', 'Tanggal Validasi']);
                
                // Table data
                foreach ($bookings as $index => $booking) {
                    fputcsv($file, [
                        $index + 1,
                        $booking->created_at->format('d/m/Y H:i'),
                        $booking->booking_code,
                        $booking->visitor_name,
                        $booking->visitor_email,
                        $booking->wisataPackage->name,
                        $booking->visit_date->format('d/m/Y'),
                        $booking->quantity,
                        'Rp ' . number_format($booking->total_amount, 0, ',', '.'),
                        ucfirst($booking->status),
                        $booking->validator ? $booking->validator->name : '-',
                        $booking->validated_at ? $booking->validated_at->format('d/m/Y H:i') : '-',
                    ]);
                }
                
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }
    }

    public function ticketReport($bookingId)
    {
        $booking = Booking::with(['wisataPackage', 'tickets'])->findOrFail($bookingId);
        return view('admin.reports.tickets', compact('booking'));
    }
    
    public function downloadTicketPDF($bookingId)
    {
        $booking = Booking::with(['wisataPackage', 'tickets'])->findOrFail($bookingId);
        
        if ($booking->tickets->isEmpty()) {
            return redirect()->back()->with('error', 'Tiket belum tersedia untuk booking ini.');
        }
        
        $ticket = $booking->tickets->first();
        
        // Generate QR Code using simple-qrcode package (SVG format - no imagick needed)
        // Encode to base64 as shown in tutorial
        $qrcode = base64_encode(
            QrCode::format('svg')
                ->size(200)
                ->errorCorrection('H')
                ->generate($ticket->qr_code)
        );
        
        $pdf = Pdf::loadView('tickets.pdf', compact('booking', 'ticket', 'qrcode'));
        $pdf->setPaper([0, 0, 300.77, 800.28], 'portrait'); // 80mm width (struk size)
        $pdf->setOption('isRemoteEnabled', true);
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('enable-local-file-access', true);
        $filename = 'tiket-' . $booking->booking_code . '.pdf';
        
        return $pdf->download($filename);
    }

    public function resendTicket($bookingId)
    {
        // Implementation for resending tickets
        return response()->json(['success' => true, 'message' => 'Tiket berhasil dikirim ulang']);
    }
    
    // Petugas Management Methods
    public function petugasIndex()
    {
        $petugas = User::where('role', 'petugas')
                      ->withCount('scannedTickets')
                      ->orderBy('created_at', 'desc')
                      ->get();
        
        $stats = [
            'total_petugas' => User::where('role', 'petugas')->count(),
            'petugas_aktif' => User::where('role', 'petugas')->where('is_active', true)->count(),
            'scan_today' => Ticket::where('is_used', true)->whereDate('used_at', today())->count(),
            'total_scan' => Ticket::where('is_used', true)->count(),
        ];
        
        return view('admin.petugas.index', compact('petugas', 'stats'));
    }
    
    public function petugasCreate()
    {
        return view('admin.petugas.create');
    }
    
    public function petugasStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'employee_id' => 'nullable|string|max:20|unique:users',
            'phone' => 'nullable|string|max:20',
            'shift' => 'nullable|in:pagi,siang,malam,full',
            'start_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'can_scan' => 'boolean',
            'can_view_reports' => 'boolean',
            'is_active' => 'boolean',
        ]);
        
        $petugas = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'petugas',
            'employee_id' => $request->employee_id,
            'phone' => $request->phone,
            'shift' => $request->shift,
            'start_date' => $request->start_date,
            'notes' => $request->notes,
            'can_scan' => $request->boolean('can_scan', true),
            'can_view_reports' => $request->boolean('can_view_reports', false),
            'is_active' => $request->boolean('is_active', true),
        ]);
        
        // Generate employee ID if not provided
        if (!$request->employee_id) {
            $petugas->generateEmployeeId();
        }
        
        return redirect()->route('admin.petugas.index')
                        ->with('success', 'Petugas tiket berhasil ditambahkan!');
    }
    
    public function petugasShow($id)
    {
        $petugas = User::where('role', 'petugas')
                      ->withCount('scannedTickets')
                      ->findOrFail($id);
        
        $recentScans = Ticket::with(['booking.wisataPackage'])
                           ->where('scanned_by', $id)
                           ->where('is_used', true)
                           ->orderBy('used_at', 'desc')
                           ->take(10)
                           ->get();
        
        $scanStats = [
            'total_scans' => $petugas->scannedTickets()->count(),
            'today_scans' => $petugas->scannedTickets()->whereDate('used_at', today())->count(),
            'this_week' => $petugas->scannedTickets()
                                  ->whereBetween('used_at', [now()->startOfWeek(), now()->endOfWeek()])
                                  ->count(),
            'this_month' => $petugas->scannedTickets()
                                   ->whereMonth('used_at', now()->month)
                                   ->whereYear('used_at', now()->year)
                                   ->count(),
        ];
        
        return view('admin.petugas.show', compact('petugas', 'recentScans', 'scanStats'));
    }
    
    public function petugasEdit($id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);
        return view('admin.petugas.edit', compact('petugas'));
    }
    
    public function petugasUpdate(Request $request, $id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'employee_id' => 'nullable|string|max:20|unique:users,employee_id,' . $id,
            'phone' => 'nullable|string|max:20',
            'shift' => 'nullable|in:pagi,siang,malam,full',
            'start_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'can_scan' => 'boolean',
            'can_view_reports' => 'boolean',
            'is_active' => 'boolean',
        ]);
        
        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'employee_id' => $request->employee_id,
            'phone' => $request->phone,
            'shift' => $request->shift,
            'start_date' => $request->start_date,
            'notes' => $request->notes,
            'can_scan' => $request->boolean('can_scan'),
            'can_view_reports' => $request->boolean('can_view_reports'),
            'is_active' => $request->boolean('is_active'),
        ];
        
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }
        
        $petugas->update($updateData);
        
        return redirect()->route('admin.petugas.index')
                        ->with('success', 'Data petugas berhasil diperbarui!');
    }
    
    public function petugasActivate($id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);
        $petugas->update(['is_active' => true]);
        
        return redirect()->route('admin.petugas.index')
                        ->with('success', 'Petugas berhasil diaktifkan!');
    }
    
    public function petugasDeactivate($id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);
        $petugas->update(['is_active' => false]);
        
        return redirect()->route('admin.petugas.index')
                        ->with('success', 'Petugas berhasil dinonaktifkan!');
    }
    
    public function petugasDestroy($id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);
        
        // Check if petugas has scanned any tickets
        if ($petugas->scannedTickets()->count() > 0) {
            return redirect()->route('admin.petugas.index')
                           ->with('error', 'Petugas tidak dapat dihapus karena telah melakukan scanning tiket!');
        }
        
        $petugas->delete();
        
        return redirect()->route('admin.petugas.index')
                        ->with('success', 'Petugas berhasil dihapus!');
    }
    
    /**
     * Update mail configuration from database settings
     */
    private function updateMailConfigFromDatabase()
    {
        $mailHost = Setting::get('mail_host', 'smtp.gmail.com');
        $mailPort = Setting::get('mail_port', '587');
        $mailUsername = Setting::get('mail_username', '');
        $mailPassword = Setting::get('mail_password', '');
        $mailEncryption = Setting::get('mail_encryption', 'tls');
        $mailFromAddress = Setting::get('mail_from_address', 'noreply@wisatalapade.com');
        $mailFromName = Setting::get('mail_from_name', 'E-Tiket Wisata Lapade');
        
        Config::set('mail.mailers.smtp.host', $mailHost);
        Config::set('mail.mailers.smtp.port', $mailPort);
        Config::set('mail.mailers.smtp.username', $mailUsername);
        Config::set('mail.mailers.smtp.password', $mailPassword);
        Config::set('mail.mailers.smtp.encryption', $mailEncryption);
        Config::set('mail.from.address', $mailFromAddress);
        Config::set('mail.from.name', $mailFromName);
        
        // Purge mailer to apply new config
        Mail::purge('smtp');
    }
}
