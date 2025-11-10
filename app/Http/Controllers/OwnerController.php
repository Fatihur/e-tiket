<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Ticket;
use App\Models\WisataPackage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OwnerController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_revenue' => Booking::where('status', 'confirmed')->sum('total_amount'),
            'total_visitors' => Ticket::where('is_used', true)->count(),
            'total_packages' => WisataPackage::where('is_active', true)->count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
        ];
        
        // Revenue chart data for last 12 months
        $revenueChart = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $revenueChart[] = [
                'month' => $date->format('M Y'),
                'revenue' => Booking::where('status', 'confirmed')
                                  ->whereMonth('created_at', $date->month)
                                  ->whereYear('created_at', $date->year)
                                  ->sum('total_amount')
            ];
        }
        
        // Visitor chart data for last 12 months
        $visitorChart = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $visitorChart[] = [
                'month' => $date->format('M Y'),
                'visitors' => Ticket::where('is_used', true)
                                   ->whereMonth('used_at', $date->month)
                                   ->whereYear('used_at', $date->year)
                                   ->count()
            ];
        }
        
        return view('owner.dashboard', compact('stats', 'revenueChart', 'visitorChart'));
    }
    
    public function reports()
    {
        $period = request('period', 'monthly');
        
        $data = [];
        
        switch ($period) {
            case 'daily':
                // Last 30 days
                for ($i = 29; $i >= 0; $i--) {
                    $date = now()->subDays($i);
                    $data[] = [
                        'date' => $date->format('d/m/Y'),
                        'revenue' => Booking::where('status', 'confirmed')
                                           ->whereDate('created_at', $date)
                                           ->sum('total_amount'),
                        'visitors' => Ticket::where('is_used', true)
                                           ->whereDate('used_at', $date)
                                           ->count()
                    ];
                }
                break;
                
            case 'weekly':
                // Last 12 weeks
                for ($i = 11; $i >= 0; $i--) {
                    $startOfWeek = now()->subWeeks($i)->startOfWeek();
                    $endOfWeek = now()->subWeeks($i)->endOfWeek();
                    
                    $data[] = [
                        'date' => $startOfWeek->format('d/m') . ' - ' . $endOfWeek->format('d/m/Y'),
                        'revenue' => Booking::where('status', 'confirmed')
                                           ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                                           ->sum('total_amount'),
                        'visitors' => Ticket::where('is_used', true)
                                           ->whereBetween('used_at', [$startOfWeek, $endOfWeek])
                                           ->count()
                    ];
                }
                break;
                
            default: // monthly
                // Last 12 months
                for ($i = 11; $i >= 0; $i--) {
                    $date = now()->subMonths($i);
                    $data[] = [
                        'date' => $date->format('M Y'),
                        'revenue' => Booking::where('status', 'confirmed')
                                           ->whereMonth('created_at', $date->month)
                                           ->whereYear('created_at', $date->year)
                                           ->sum('total_amount'),
                        'visitors' => Ticket::where('is_used', true)
                                           ->whereMonth('used_at', $date->month)
                                           ->whereYear('used_at', $date->year)
                                           ->count()
                    ];
                }
                break;
        }
        
        return view('owner.reports', compact('data', 'period'));
    }
    
    public function packageAnalysis()
    {
        $packages = WisataPackage::withCount(['bookings' => function($query) {
                                    $query->where('status', 'confirmed');
                                }])
                                ->withSum(['bookings' => function($query) {
                                    $query->where('status', 'confirmed');
                                }], 'total_amount')
                                ->get();
        
        return view('owner.package-analysis', compact('packages'));
    }
}
